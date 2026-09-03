<?php

namespace App\Http\Controllers;

use App\Exports\FreedomWallExport;
use App\Models\FreedomWall;
use App\Models\Quotes;
use App\Models\SentimentKeyword;
use App\Models\SystemSetting;
use App\Models\Admin\Counselor;
use App\Services\SentimentService;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class FreedomwallController extends Controller
{
    protected SentimentService $sentiment;

    public function __construct(SentimentService $sentiment)
    {
        $this->sentiment = $sentiment;
    }

    /* ── ADMIN: posts list ── */
    public function index(Request $request)
    {
        $query = FreedomWall::query();

        if ($request->filled('program'))    $query->where('program',    $request->program);
        if ($request->filled('year_level')) $query->where('year_level', $request->year_level);
        if ($request->filled('sentiment'))  $query->where('sentiment',  $request->sentiment);
        if ($request->filled('ai_flagged')) $query->where('ai_flagged', true);

        $start_date = $request->filled('start_date') ? $request->start_date : null;
        $end_date   = $request->filled('end_date')   ? $request->end_date   : null;

        if ($start_date) $query->whereDate('created_at', '>=', $start_date);
        if ($end_date)   $query->whereDate('created_at', '<=', $end_date);

        $entries = $query->latest()->paginate(15)->withQueryString();

        return view('admin.freedomwall.freedomwall', compact('entries', 'start_date', 'end_date'));
    }

    /* ── USER: landing page ── */
    public function add()
    {
        return view('user.freedomwall.freedomwall_add');
    }

    /* ── USER: submission form ── */
    public function create()
    {
        return view('user.freedomwall.freedomwall_create');
    }

    /* ── USER: thank-you page ── */
    public function submitted()
    {
        if (! session('ehayag_just_submitted')) {
            return redirect()->route('user.freedomwall.add');
        }

        $postId      = session('ehayag_post_id');
        $isHighRisk  = session('ehayag_is_high_risk', false);
        $highRiskUrl = session('ehayag_high_risk_url');
        $randomQuote = Quotes::inRandomOrder()->first();

        return response()
            ->view('user.freedomwall.freedomwall_submitted', compact(
                'randomQuote', 'postId', 'isHighRisk', 'highRiskUrl'
            ))
            ->header('Cache-Control', 'no-store, no-cache, must-revalidate, max-age=0')
            ->header('Pragma', 'no-cache')
            ->header('Expires', '0');
    }

    /* ── USER: save post ── */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'postName' => [
                'required', 'email', 'max:255',
                function ($attribute, $value, $fail) {
                    $allowed = ['@students.nu-laguna.edu.ph', '@shs.nu-laguna.edu.ph'];
                    $v = strtolower($value);
                    $valid = false;
                    foreach ($allowed as $domain) {
                        if (str_ends_with($v, $domain)) { $valid = true; break; }
                    }
                    if (! $valid) {
                        $fail('Please use your NU Laguna student email (@students.nu-laguna.edu.ph or @shs.nu-laguna.edu.ph).');
                    }
                },
            ],
            'post' => 'required|string',
        ]);

        // Verify registered active student
        $student = \App\Models\User::where('email', strtolower(trim($validated['postName'])))
            ->where('roles', 'user')
            ->first();

        if (! $student) {
            return back()->withInput()->withErrors([
                'postName' => 'This email is not registered. Please register first at /student/register.',
            ]);
        }

        if (! $student->is_active) {
            return back()->withInput()
                ->withErrors(['postName' => 'Your account is deactivated. Please reactivate it first.'])
                ->with('deactivated_email', $validated['postName']);
        }

        $validated['postName']   = $student->name;
        $validated['student_email'] = strtolower(trim($request->postName));
        $validated['program']    = $student->program    ?? 'Unknown';
        $validated['year_level'] = $student->year_level ?? 'Unknown';
        $validated['sentiment']  = $this->sentiment->analyzeByKeywords($validated['post']);

        $post = FreedomWall::create($validated);

        $isHighRisk = $post->sentiment === 'high_risk';

        // Non-blocking AI analysis after response is sent
        dispatch(function () use ($post) {
            try {
                $service  = app(SentimentService::class);
                $aiResult = $service->analyzeWithAI($post->post);

                if (! empty($aiResult['ai_sentiment'])) {
                    $post->update($aiResult);

                    $isAiHighRisk = $aiResult['ai_sentiment'] === 'high_risk' || ($aiResult['ai_flagged'] ?? false);
                    if ($isAiHighRisk) {
                        $post->update(['sentiment' => 'high_risk']);
                    }

                    // Auto-send email alert if post is high-risk and recipients are configured
                    if ($isAiHighRisk) {
                        \App\Http\Controllers\FreedomwallController::dispatchHighRiskAlert($post);
                    }
                }
            } catch (\Exception $e) {
                \Illuminate\Support\Facades\Log::error('Post-response AI analysis failed: ' . $e->getMessage());
            }
        })->afterResponse();

        // Also auto-send if keyword already flagged high-risk (before AI)
        if ($isHighRisk) {
            dispatch(function () use ($post) {
                \App\Http\Controllers\FreedomwallController::dispatchHighRiskAlert($post);
            })->afterResponse();
        }

        session([
            'ehayag_post_id'       => $post->id,
            'ehayag_is_high_risk'  => $isHighRisk,
            'ehayag_high_risk_url' => $isHighRisk
                ? SystemSetting::get('high_risk_contact_url', route('user.services'))
                : null,
        ]);

        return redirect()->route('user.freedomwall.submitted')
            ->with('ehayag_just_submitted', true);
    }

    /* ── ADMIN: view single post ── */
    public function details($id)
    {
        $post = FreedomWall::findOrFail($id);
        return view('admin.freedomwall.details', compact('post'));
    }

    /**
     * Static helper — auto-send high-risk email alert after post submission.
     * Called from the afterResponse dispatch. Only sends if:
     *  - Recipients are configured in system_settings
     *  - Alert has not already been sent for this post
     */
    public static function dispatchHighRiskAlert(FreedomWall $post): void
    {
        try {
            $raw = SystemSetting::get('alert_recipients', '');
            $recipients = collect(explode(',', $raw))
                ->map(fn($e) => trim($e))
                ->filter()
                ->values()
                ->toArray();

            if (empty($recipients)) return;

            // Only send once per post
            $alreadySent = \App\Models\HighRiskAlert::where('freedom_wall_id', $post->id)->exists();
            if ($alreadySent) return;

            foreach ($recipients as $email) {
                \Illuminate\Support\Facades\Mail::to($email)
                    ->send(new \App\Mail\HighRiskAlertMail($post, 'System (Auto-Alert)'));
            }

            \App\Models\HighRiskAlert::create([
                'freedom_wall_id' => $post->id,
                'sent_by'         => 'auto',
                'recipients'      => $recipients,
                'sent_at'         => now(),
            ]);

        } catch (\Exception $e) {
            \Illuminate\Support\Facades\Log::error('Auto high-risk alert failed: ' . $e->getMessage());
        }
    }

    /* ── ADMIN: manual send high-risk alert email ── */
    public function sendHighRiskAlert(Request $request)
    {
        $request->validate([
            'post_ids'   => 'required|array|min:1',
            'post_ids.*' => 'integer|exists:freedom_walls,id',
            'recipients' => 'required|array|min:1',
            'recipients.*' => 'email',
        ]);

        $posts      = FreedomWall::whereIn('id', $request->post_ids)->get();
        $recipients = $request->recipients;
        $adminName  = auth()->user()->name ?? 'Admin';
        $sent       = 0;
        $skipped    = 0;

        foreach ($posts as $post) {
            // Skip if already alerted
            $alreadySent = \App\Models\HighRiskAlert::where('freedom_wall_id', $post->id)->exists();
            if ($alreadySent) { $skipped++; continue; }

            try {
                foreach ($recipients as $email) {
                    \Illuminate\Support\Facades\Mail::to($email)
                        ->send(new \App\Mail\HighRiskAlertMail($post, $adminName));
                }

                \App\Models\HighRiskAlert::create([
                    'freedom_wall_id' => $post->id,
                    'sent_by'         => $adminName,
                    'recipients'      => $recipients,
                    'sent_at'         => now(),
                ]);

                $sent++;
            } catch (\Exception $e) {
                \Illuminate\Support\Facades\Log::error('High-risk alert email failed: ' . $e->getMessage());
                return response()->json([
                    'success' => false,
                    'message' => 'Email failed: ' . $e->getMessage(),
                ], 500);
            }
        }

        $msg = "Alert sent for {$sent} post(s).";
        if ($skipped) $msg .= " {$skipped} already alerted (skipped).";

        return response()->json(['success' => true, 'message' => $msg, 'sent' => $sent, 'skipped' => $skipped]);
    }

    /* ── ADMIN: delete post ── */
    public function destroy($id)
    {
        FreedomWall::findOrFail($id)->delete();
        return redirect()->route('admin.freedomwall.freedomwall')->with('deleted', 'Post deleted successfully.');
    }

    /* ── ADMIN: AI analyse single post (AJAX) ── */
    public function aiAnalyzePost(Request $request, $id)
    {
        $post   = FreedomWall::findOrFail($id);
        $result = $this->sentiment->analyzeWithAI($post->post);

        $post->update($result);

        if (($result['ai_sentiment'] ?? '') === 'high_risk' || ($result['ai_flagged'] ?? false)) {
            $post->update(['sentiment' => 'high_risk']);
        }

        $post->refresh();

        return response()->json([
            'success'             => true,
            'ai_sentiment'        => $post->ai_sentiment,
            'ai_emotion_category' => $post->ai_emotion_category,
            'ai_confidence'       => $post->ai_confidence,
            'ai_counselor_note'   => $post->ai_counselor_note,
            'ai_flagged'          => $post->ai_flagged,
        ]);
    }

    /* ── ADMIN: bulk AI analyse (AJAX) ── */
    public function aiBulkAnalyze(Request $request)
    {
        $posts     = FreedomWall::whereNull('ai_sentiment')->latest()->limit(20)->get();
        $processed = 0;

        foreach ($posts as $post) {
            $result = $this->sentiment->analyzeWithAI($post->post);
            $post->update($result);
            if (($result['ai_sentiment'] ?? '') === 'high_risk' || ($result['ai_flagged'] ?? false)) {
                $post->update(['sentiment' => 'high_risk']);
            }
            $processed++;
        }

        return response()->json([
            'success'   => true,
            'processed' => $processed,
            'message'   => $processed > 0
                ? "AI analysed {$processed} post(s) successfully."
                : 'All visible posts already have AI analysis.',
        ]);
    }

    /* ── ADMIN: high-risk posts ── */
    public function highRiskPosts()
    {
        $posts = FreedomWall::where(function ($q) {
                $q->where('sentiment', 'high_risk')
                  ->orWhere('ai_sentiment', 'high_risk')
                  ->orWhere('ai_flagged', true);
            })
            ->whereDate('created_at', now()->toDateString())
            ->latest()
            ->get();

        // For each post, check if an alert has already been sent
        $alertedIds = \App\Models\HighRiskAlert::whereIn('freedom_wall_id', $posts->pluck('id'))
            ->pluck('freedom_wall_id')
            ->toArray();

        // Load saved alert recipients
        $alertRecipients = collect(explode(',', SystemSetting::get('alert_recipients', '')))
            ->map(fn($e) => trim($e))
            ->filter()
            ->values();

        // Load counselors for recipient selector
        $counselors = \App\Models\Admin\Counselor::whereNotNull('email')
            ->where('email', '!=', '')
            ->get(['id', 'name', 'email']);

        return view('admin.freedomwall.highrisk', compact(
            'posts', 'alertedIds', 'alertRecipients', 'counselors'
        ));
    }

    /* ── ADMIN: analytics ── */
    public function analytics(Request $request)
    {
        $query = FreedomWall::query();

        if ($request->filled('program'))    $query->where('program',    $request->program);
        if ($request->filled('year_level')) $query->where('year_level', $request->year_level);

        // Year filter — sets start/end to Jan 1 – Dec 31 of selected year
        if ($request->filled('year')) {
            $y = (int) $request->year;
            $query->whereYear('created_at', $y);
            // Also apply to monthly chart below
        } else {
            if ($request->filled('start_date')) $query->whereDate('created_at', '>=', $request->start_date);
            if ($request->filled('end_date'))   $query->whereDate('created_at', '<=', $request->end_date);
        }

        $filtered = $query->get();

        $programData   = $filtered->groupBy('program')->map->count();
        $yearData      = $filtered->groupBy('year_level')->map->count();
        $weeklyData    = $filtered->groupBy(fn($i) => $i->created_at->format('Y-m-d'))->map->count();
        $sentimentData = $filtered->groupBy('sentiment')->map->count();
        $emotionData   = $filtered->whereNotNull('ai_emotion_category')
                                  ->groupBy('ai_emotion_category')->map->count();

        $mostAffectedProgram = $filtered
            ->where('created_at', '>=', now()->startOfDay())
            ->groupBy('program')->map->count()->sortDesc()->keys()->first();

        // Monthly chart — scoped to selected year if set, else last 12 months
        $monthlyQuery = FreedomWall::selectRaw("strftime('%Y-%m', created_at) as month, COUNT(*) as total");
        if ($request->filled('year')) {
            $monthlyQuery->whereYear('created_at', (int) $request->year);
        } else {
            $monthlyQuery->where('created_at', '>=', now()->subMonths(11)->startOfMonth());
        }
        $monthlyData = $monthlyQuery->groupBy('month')->orderBy('month')->get();

        // Build year list: from earliest post year to current year + 2
        $earliestYear = FreedomWall::selectRaw("strftime('%Y', MIN(created_at)) as yr")->value('yr');
        $earliestYear = $earliestYear ? (int) $earliestYear : now()->year;
        $latestYear   = now()->year + 2;
        $yearOptions  = range($earliestYear, $latestYear);

        return view('admin.freedomwall.analytics', [
            'programLabels'       => $programData->keys(),
            'programCounts'       => $programData->values(),
            'yearLabels'          => $yearData->keys(),
            'yearCounts'          => $yearData->values(),
            'weeklyLabels'        => $weeklyData->keys(),
            'weeklyCounts'        => $weeklyData->values(),
            'sentimentLabels'     => $sentimentData->keys(),
            'sentimentCounts'     => $sentimentData->values(),
            'emotionLabels'       => $emotionData->keys(),
            'emotionCounts'       => $emotionData->values(),
            'mostAffectedProgram' => $mostAffectedProgram,
            'monthlyLabels'       => $monthlyData->pluck('month'),
            'monthlyCounts'       => $monthlyData->pluck('total'),
            'yearOptions'         => $yearOptions,
        ]);
    }

    /* ── ADMIN: export posts ── */
    public function export(Request $request)
    {
        $filters = $request->only(['program', 'year_level', 'sentiment', 'ai_flagged', 'start_date', 'end_date']);

        $filename = 'ehayag-posts';
        if (! empty($filters['program']))    $filename .= '-' . $filters['program'];
        if (! empty($filters['sentiment']))  $filename .= '-' . $filters['sentiment'];
        if (! empty($filters['start_date'])) $filename .= '-from-' . $filters['start_date'];
        if (! empty($filters['end_date']))   $filename .= '-to-'   . $filters['end_date'];
        $filename .= '.xlsx';

        return Excel::download(new FreedomWallExport($filters), $filename);
    }

    /* ── ADMIN: export analytics ── */
    public function analyticsExport(Request $request)
    {
        $filename = 'ehayag-analytics-' . now()->format('Y-m-d') . '.xlsx';
        return Excel::download(new \App\Exports\FreedomWallAnalyticsExport(), $filename);
    }

    /* ── ADMIN: sentiment keywords ── */
    public function keywords()
    {
        $keywords = SentimentKeyword::orderBy('category')->get();
        return view('admin.sentiment.keywords', compact('keywords'));
    }

    public function storeKeyword(Request $request)
    {
        $request->validate(['word' => 'required|string|max:255', 'category' => 'required|string']);
        SentimentKeyword::create([
            'word'     => strtolower($request->word),
            'category' => $request->category,
        ]);
        return back()->with('added', 'Keyword added.');
    }

    public function updateKeyword(Request $request, $id)
    {
        $request->validate(['word' => 'required|string|max:255', 'category' => 'required|string']);
        SentimentKeyword::findOrFail($id)->update([
            'word'     => strtolower($request->word),
            'category' => $request->category,
        ]);
        return back()->with('updated', 'Keyword updated.');
    }

    public function deleteKeyword($id)
    {
        SentimentKeyword::findOrFail($id)->delete();
        return back()->with('deleted', 'Keyword removed.');
    }
}

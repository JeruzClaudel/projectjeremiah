<?php

namespace App\Http\Controllers;

use App\Models\Quotes;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class QuoteController extends Controller
{
    public function index()
    {
        $quotes    = Quotes::latest()->get();
        $page_data = ['quotes' => $quotes];
        return view('admin.quote.quote', $page_data);
    }

    public function add()
    {
        return view('admin.quote.quote_add');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'author' => 'nullable|string|max:100',
            'quote'  => 'required|string|max:10000',
        ]);

        $quote = Quotes::create($validated);

        // AJAX request (from AI single-save) — return JSON
        if ($request->expectsJson() || $request->wantsJson()) {
            return response()->json(['success' => true, 'id' => $quote->id]);
        }

        return redirect()->route('admin.quote.details', $quote->id)
            ->with('added', 'Quote has been added.');
    }

    public function details($id)
    {
        $quote = Quotes::findOrFail($id);
        return view('admin.quote.quote_details', compact('quote'));
    }

    public function edit($id)
    {
        $quote = Quotes::findOrFail($id);
        return view('admin.quote.quote_edit', compact('quote'));
    }

    public function update(Request $request, Quotes $id)
    {
        $validated = $request->validate([
            'author' => 'nullable|string|max:100',
            'quote'  => 'required|string|max:10000',
        ]);

        $id->author = $validated['author'] ?? null;
        $id->quote  = $validated['quote'];
        $id->save();

        return redirect()->route('admin.quote.details', $id)
            ->with('updated', 'Quote has been updated.');
    }

    public function destroy($id)
    {
        Quotes::findOrFail($id)->delete();
        return redirect()->route('admin.quote.index')
            ->with('deleted', 'Quote deleted successfully.');
    }

    public function aiGenerate(Request $request)
    {
        $request->validate([
            'theme'       => 'nullable|string|max:200',
            'real_author' => 'nullable|boolean',
        ]);

        $theme      = $request->input('theme', 'mental health, hope, and student resilience');
        $realAuthor = $request->boolean('real_author', true);
        $apiKey     = env('OPENROUTER_API_KEY');
        $model      = env('OPENROUTER_MODEL', 'openai/gpt-4o-mini');
        $base       = env('OPENROUTER_BASE_URL', 'https://openrouter.ai/api/v1');

        if (empty($apiKey)) {
            return response()->json(['error' => 'OpenRouter API key is not configured.'], 500);
        }

        $authorInstruction = $realAuthor
            ? 'For "author", use a real historical person, philosopher, psychologist, or well-known public figure whose name is widely recognised. Only fall back to "Guidance Services Office" if no suitable real person fits.'
            : 'For "author", use "Guidance Services Office".';

        $prompt = "Generate one original, inspiring quote about: {$theme}. "
                . "The quote should be suitable for a school guidance office and helpful for students facing mental health challenges. "
                . "{$authorInstruction} "
                . 'Return a JSON object with exactly two fields: "quote" (the quote text, without surrounding quotation marks) and "author" (the attribution). '
                . 'Respond with valid JSON only — no markdown, no explanation.';

        try {
            $response = Http::withToken($apiKey)
                ->timeout(30)
                ->post("{$base}/chat/completions", [
                    'model'    => $model,
                    'messages' => [['role' => 'user', 'content' => $prompt]],
                ]);

            if (! $response->successful()) {
                Log::error('AI Quote generation failed: ' . $response->body());
                return response()->json(['error' => 'AI service returned an error. Please try again.'], 500);
            }

            $content = $response->json('choices.0.message.content', '');
            $content = preg_replace('/^```(?:json)?\s*/m', '', $content);
            $content = preg_replace('/```\s*$/m', '', $content);

            $data = json_decode(trim($content), true);

            if (! is_array($data) || empty($data['quote'])) {
                return response()->json(['error' => 'Could not parse AI response. Please try again.'], 500);
            }

            return response()->json([
                'quote'  => $data['quote'],
                'author' => $data['author'] ?? 'Guidance Services Office',
            ]);

        } catch (\Exception $e) {
            Log::error('AI Quote exception: ' . $e->getMessage());
            return response()->json(['error' => 'Request failed: ' . $e->getMessage()], 500);
        }
    }
}

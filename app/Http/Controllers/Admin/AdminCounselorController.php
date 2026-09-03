<?php

namespace App\Http\Controllers\Admin;

use App\Exports\CounselorExport;
use App\Http\Controllers\Controller;
use App\Imports\CounselorImport;
use App\Models\Admin\Counselor;
use App\Models\Admin\CounselorSchedule;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Facades\Excel;

class AdminCounselorController extends Controller
{
    public function index()
    {
        $counselors = Counselor::all();
        return view('admin.counselors.counselor', ['counselors' => $counselors]);
    }

    public function add()
    {
        return view('admin.counselors.counselor_add');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name'             => 'required|string|max:255',
            'position'         => 'nullable|string|max:255',
            'college'          => 'nullable|string|max:255',
            'email'            => 'nullable|email|max:255',
            'ms_teams_account' => 'nullable|string|max:255',
            'image'            => 'nullable|file|mimes:jpg,jpeg,png,webp|max:2048',
            'availability'     => 'nullable|array',
        ]);

        DB::beginTransaction();
        try {
            $counselor = new Counselor();
            $counselor->name             = $validated['name'];
            $counselor->position         = $validated['position'] ?? null;
            $counselor->college          = $validated['college']  ?? null;
            $counselor->email            = $validated['email']    ?? null;
            $counselor->ms_teams_account = $validated['ms_teams_account'] ?? null;

            if ($request->hasFile('image')) {
                $counselor->image = $request->file('image')->store('counselors', 'public');
            }

            $counselor->save();

            foreach ($validated['availability'] ?? [] as $day => $dayData) {
                if (isset($dayData['available'], $dayData['times'])) {
                    foreach ($dayData['times'] as $time) {
                        if (! empty($time['start']) && ! empty($time['end'])) {
                            CounselorSchedule::create([
                                'counselor_id' => $counselor->id,
                                'day_of_week'  => $day,
                                'start_time'   => $time['start'],
                                'end_time'     => $time['end'],
                            ]);
                        }
                    }
                }
            }

            DB::commit();
            return redirect()->route('admin.counselor.dashboard')->with('success', 'Counselor added successfully!');
        } catch (\Exception $e) {
            DB::rollBack();
            \Illuminate\Support\Facades\Log::error('Counselor store failed: ' . $e->getMessage());
            return back()->with('error', 'Failed to add counselor. Please try again.');
        }
    }

    public function edit($id)
    {
        $counselor = Counselor::with('schedules')->findOrFail($id);
        return view('admin.counselors.counselor_edit', compact('counselor'));
    }

    public function show($id)
    {
        $counselor = Counselor::with('schedules')->findOrFail($id);
        return view('admin.counselors.counselor_details', compact('counselor'));
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'name'             => 'required|string|max:255',
            'position'         => 'nullable|string|max:255',
            'college'          => 'nullable|string|max:255',
            'email'            => 'nullable|email|max:255',
            'ms_teams_account' => 'nullable|string|max:255',
            'image'            => 'nullable|file|mimes:jpg,jpeg,png,webp|max:2048',
            'availability'     => 'nullable|array',
        ]);

        $counselor = Counselor::findOrFail($id);

        if ($request->hasFile('image')) {
            if ($counselor->image && Storage::disk('public')->exists($counselor->image)) {
                Storage::disk('public')->delete($counselor->image);
            }
            $counselor->image = $request->file('image')->store('counselors', 'public');
        }

        $counselor->name             = $validated['name'];
        $counselor->position         = $validated['position'] ?? null;
        $counselor->college          = $validated['college']  ?? null;
        $counselor->email            = $validated['email']    ?? null;
        $counselor->ms_teams_account = $validated['ms_teams_account'] ?? null;
        $counselor->save();

        $counselor->schedules()->delete();

        foreach ($validated['availability'] ?? [] as $day => $data) {
            if (isset($data['available']) && $data['available'] && isset($data['times'])) {
                foreach ($data['times'] as $t) {
                    if (! empty($t['start']) && ! empty($t['end'])) {
                        CounselorSchedule::create([
                            'counselor_id' => $counselor->id,
                            'day_of_week'  => $day,
                            'start_time'   => $t['start'],
                            'end_time'     => $t['end'],
                        ]);
                    }
                }
            }
        }

        return redirect()->route('admin.counselor.dashboard')->with('success', 'Counselor updated successfully.');
    }

    public function delete($id)
    {
        $counselor = Counselor::findOrFail($id);

        if ($counselor->image && Storage::disk('public')->exists($counselor->image)) {
            Storage::disk('public')->delete($counselor->image);
        }

        $counselor->schedules()->delete();
        $counselor->delete();

        return redirect()->route('admin.counselor.dashboard')->with('success', 'Counselor deleted successfully.');
    }

    /* ── Export ── */
    public function export()
    {
        return Excel::download(
            new CounselorExport(),
            'counselors-' . now()->format('Y-m-d') . '.xlsx'
        );
    }

    /* ── Import ── */
    public function import(Request $request)
    {
        $request->validate([
            'import_file' => 'required|file|mimes:xlsx,xls,csv|max:5120',
        ]);

        $import = new CounselorImport();

        try {
            Excel::import($import, $request->file('import_file'));
        } catch (\Exception $e) {
            \Illuminate\Support\Facades\Log::error('Counselor import exception: ' . $e->getMessage());
            return redirect()->route('admin.counselor.dashboard')
                ->with('error', 'Import failed. Please check the file format and try again.');
        }

        $added   = $import->getImportedCount();
        $updated = $import->getUpdatedCount();

        return redirect()->route('admin.counselor.dashboard')
            ->with('added', "Import complete — {$added} added, {$updated} updated.");
    }
}

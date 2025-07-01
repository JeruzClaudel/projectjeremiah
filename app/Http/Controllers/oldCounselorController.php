<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Storage;
use App\Models\Counselor;
use App\Models\CounselorSchedule;
use Illuminate\Http\Request;

class CounselorController extends Controller
{

    public function index() {
        $counselors = Counselor::all();
        
        $page_data = ['counselors' => $counselors];

        return view('admin.counselors.index', $page_data);
    }

    public function create()
    {
        return view('admin.counselors.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'department' => 'required|string|max:255',
            'image' => 'nullable|image|max:2048', // max 2MB
            'email' => 'required|email|unique:counselors,email',
            'ms_teams_account' => 'nullable|string|max:255',
            'availability' => 'required|array',
        ]);

        // Upload image if exists
        $imagePath = null;
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('counselor_images', 'public');
        }

        // Create counselor
        $counselor = Counselor::create([
            'name' => $validated['name'],
            'department' => $validated['department'],
            'image' => $imagePath,
            'email' => $validated['email'],
            'ms_teams_account' => $validated['ms_teams_account'] ?? null,
        ]);

        // Save schedules
        $availability = $request->input('availability');

        foreach ($availability as $day => $data) {
            if (isset($data['available']) && $data['available'] == '1') {
                if (!empty($data['times']) && is_array($data['times'])) {
                    foreach ($data['times'] as $timeRange) {
                        if (!empty($timeRange['start']) && !empty($timeRange['end'])) {
                            CounselorSchedule::create([
                                'counselor_id' => $counselor->id,
                                'day_of_week' => $day,
                                'start_time' => $timeRange['start'],
                                'end_time' => $timeRange['end'],
                            ]);
                        }
                    }
                }
            }
        }

        return redirect()->route('admin.counselors.index')->with('success', 'Counselor created with schedule!');
    }


    public function edit(Counselor $counselor)
    {
    // Prepare schedule data grouped by day for easy Blade usage
    $schedule = [];

    foreach ($counselor->schedules as $sch) {
        $schedule[$sch->day_of_week][] = [
            'start' => $sch->start_time,
            'end' => $sch->end_time,
        ];
    }

    return view('counselors.edit', compact('counselor', 'schedule'));
    }

public function update(Request $request, Counselor $counselor)
{
    $validated = $request->validate([
        'name' => 'required|string|max:255',
        'department' => 'required|string|max:255',
        'image' => 'nullable|image|max:2048',
        'email' => 'required|email|unique:counselors,email,' . $counselor->id,
        'ms_teams_account' => 'nullable|string|max:255',
        'availability' => 'required|array',
    ]);

    // Update image if new one uploaded
    if ($request->hasFile('image')) {
        // Optional: Delete old image if exists
        if ($counselor->image) {
            Storage::disk('public')->delete($counselor->image);
        }
        $imagePath = $request->file('image')->store('counselor_images', 'public');
        $counselor->image = $imagePath;
    }

    $counselor->update([
        'name' => $validated['name'],
        'department' => $validated['department'],
        'email' => $validated['email'],
        'ms_teams_account' => $validated['ms_teams_account'] ?? null,
    ]);

    // Remove old schedules
    $counselor->schedules()->delete();

    // Save new schedules
    $availability = $request->input('availability');

    foreach ($availability as $day => $data) {
        if (isset($data['available']) && $data['available'] == '1') {
            if (!empty($data['times']) && is_array($data['times'])) {
                foreach ($data['times'] as $timeRange) {
                    if (!empty($timeRange['start']) && !empty($timeRange['end'])) {
                        CounselorSchedule::create([
                            'counselor_id' => $counselor->id,
                            'day_of_week' => $day,
                            'start_time' => $timeRange['start'],
                            'end_time' => $timeRange['end'],
                        ]);
                    }
                }
            }
        }
    }

    return redirect()->route('counselors.edit', $counselor)->with('success', 'Counselor updated!');
}

public function show(Counselor $counselor)
{
    $schedule = [];

    foreach ($counselor->schedules as $sch) {
        $schedule[$sch->day_of_week][] = [
            'start' => $sch->start_time,
            'end' => $sch->end_time,
        ];
    }

    return view('counselors.show', compact('counselor', 'schedule'));
}

}

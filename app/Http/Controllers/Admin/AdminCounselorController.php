<?php

namespace App\Http\Controllers\Admin;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use App\Models\Admin\Counselor;
use App\Models\Admin\CounselorSchedule;

class AdminCounselorController extends Controller
{
    //

    public function index(){
        $counselor = Counselor::all();
        $page_data = ['counselors' => $counselor];
        return view('admin.counselors.counselor', $page_data);
    }

    public function add(){
        return view('admin.counselors.counselor_add');
    }


    public function store(Request $request)
{
    DB::beginTransaction();

    try {
        // 1️⃣ Save counselor details
        $counselor = new Counselor();
        $counselor->name = $request->input('name');
        $counselor->position = $request->input('position');
        $counselor->college = $request->input('college') ?? null;
        $counselor->email = $request->input('email');
        $counselor->ms_teams_account = $request->input('ms_teams_account');

        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('counselors', 'public');
            $counselor->image = $imagePath;
        }

        $counselor->save();

        // 2️⃣ Save counselor schedule
        $availability = $request->input('availability', []);

        foreach ($availability as $day => $dayData) {
            if (isset($dayData['available']) && isset($dayData['times'])) {
                foreach ($dayData['times'] as $time) {
                    if (!empty($time['start']) && !empty($time['end'])) {
                        CounselorSchedule::create([
                            'counselor_id' => $counselor->id,
                            'day_of_week' => $day,
                            'start_time' => $time['start'],
                            'end_time' => $time['end'],
                        ]);
                    }
                }
            }
        }

        DB::commit();

        return redirect()->route('admin.counselor.dashboard')->with('success', 'Counselor added successfully!');
    } catch (\Exception $e) {
        DB::rollBack();
        return back()->with('error', 'Failed to add counselor: ' . $e->getMessage());
    }
}

        public function edit($id) {
            $counselor = Counselor::with('schedules')->findOrFail($id);
            return view('admin.counselors.counselor_edit', compact('counselor'));
        }


        public function show($id) {
            $counselor = Counselor::with('schedules')->findOrFail($id);
            return view('admin.counselors.counselor_details', compact('counselor'));
        }

        public function update(Request $request, $id)
        {
            // Validate basic inputs, customize as needed
            $validated = $request->validate([
                'name' => 'required|string|max:255',
                'position' => 'nullable|string|max:255',
                'college' => 'nullable|string|max:255',
                'email' => 'nullable|email|max:255',
                'ms_teams_account' => 'nullable|string|max:255',
                'image' => 'nullable|image|max:2048', // max 2MB
                'availability' => 'nullable|array',
            ]);

            $counselor = Counselor::findOrFail($id);

            // Handle image upload if new image is provided
            if ($request->hasFile('image')) {
                // Delete old image if exists
                if ($counselor->image && Storage::disk('public')->exists($counselor->image)) {
                    Storage::disk('public')->delete($counselor->image);
                }

                $path = $request->file('image')->store('counselors', 'public');
                $counselor->image = $path;
            }

            // Update counselor info
            $counselor->name = $validated['name'];
            $counselor->position = $validated['position'] ?? null;
            $counselor->college = $validated['college'] ?? null;
            $counselor->email = $validated['email'] ?? null;
            $counselor->ms_teams_account = $validated['ms_teams_account'] ?? null;

            $counselor->save();

            // Update schedules
            // Clear old schedules first
            $counselor->schedules()->delete();

            if (!empty($validated['availability'])) {
                foreach ($validated['availability'] as $day => $data) {
                    if (isset($data['available']) && $data['available']) {
                        if (isset($data['times']) && is_array($data['times'])) {
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
            }

            return redirect()->route('admin.counselor.dashboard')->with('success', 'Counselor updated successfully.');
        }


        public function delete($id)
        {
            $counselor = Counselor::findOrFail($id);

            // Delete counselor image if exists
            if ($counselor->image && Storage::disk('public')->exists($counselor->image)) {
                Storage::disk('public')->delete($counselor->image);
            }

            // Delete related schedules (if set up with relation)
            $counselor->schedules()->delete();

            // Delete the counselor record
            $counselor->delete();

            return redirect()->route('admin.counselor.dashboard')->with('success', 'Counselor deleted successfully.');
        }

}


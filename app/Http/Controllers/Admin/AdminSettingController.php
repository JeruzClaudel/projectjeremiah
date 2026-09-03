<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SystemSetting;
use App\Models\User;
use Illuminate\Http\Request;

class AdminSettingController extends Controller
{
    public function index()
    {
        $settings = SystemSetting::orderBy('key')->get()->keyBy('key');

        $defaults = [
            'high_risk_contact_url' => '',
            'maintenance_mode'      => '0',
            'deactivation_date'     => '',
            'deactivation_done'     => '0',
            'alert_recipients'      => '',
        ];

        foreach ($defaults as $key => $default) {
            if (! isset($settings[$key])) {
                $settings[$key] = (object)['value' => $default];
            }
        }

        $studentCount         = User::where('roles', 'user')->count();
        $activeStudentCount   = User::where('roles', 'user')->where('is_active', true)->count();
        $inactiveStudentCount = User::where('roles', 'user')->where('is_active', false)->count();

        return view('admin.settings.index', compact(
            'settings', 'studentCount', 'activeStudentCount', 'inactiveStudentCount'
        ));
    }

    public function update(Request $request)
    {
        $request->validate([
            'high_risk_contact_url' => 'nullable|url|max:2048',
            'deactivation_date'     => 'nullable|date',
        ]);

        SystemSetting::set('high_risk_contact_url', $request->input('high_risk_contact_url', ''));

        $newDate = $request->input('deactivation_date', '');
        $oldDate = SystemSetting::get('deactivation_date', '');
        SystemSetting::set('deactivation_date', $newDate);

        if ($newDate !== $oldDate) {
            SystemSetting::set('deactivation_done', '0');
        }

        return back()->with('updated', 'Settings saved successfully.');
    }

    public function toggleMaintenance(Request $request)
    {
        $current = SystemSetting::get('maintenance_mode', '0');
        SystemSetting::set('maintenance_mode', $current === '1' ? '0' : '1');
        return back()->with('updated', 'Maintenance mode updated.');
    }

    public function deactivateAllStudents()
    {
        User::where('roles', 'user')->update(['is_active' => false]);
        return back()->with('updated', 'All student accounts deactivated.');
    }

    public function activateAllStudents()
    {
        User::where('roles', 'user')->update(['is_active' => true]);
        return back()->with('updated', 'All student accounts activated.');
    }

    public function updateAlertRecipients(Request $request)
    {
        $request->validate([
            'alert_recipients' => 'nullable|string',
        ]);

        // Store as comma-separated string, trimmed
        $raw   = $request->input('alert_recipients', '');
        $clean = collect(explode(',', $raw))
            ->map(fn($e) => trim($e))
            ->filter(fn($e) => filter_var($e, FILTER_VALIDATE_EMAIL))
            ->implode(',');

        SystemSetting::set('alert_recipients', $clean);

        return back()->with('updated', 'Alert recipients saved.');
    }
}

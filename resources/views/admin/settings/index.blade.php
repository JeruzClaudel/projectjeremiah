
<x-app-layout title="Settings">
<style>
.settings-card {
    background:#fff;border:1.5px solid #e5e7eb;border-radius:14px;
    padding:22px 26px;margin-bottom:22px;
    box-shadow:0 2px 10px rgba(0,0,0,.05);
}
.settings-card h3 {
    font-size:.82rem;font-weight:800;color:#0a1931;text-transform:uppercase;
    letter-spacing:.4px;margin-bottom:6px;
}
.settings-card .desc { font-size:.82rem;color:#6b7280;margin-bottom:18px;line-height:1.6; }
.setting-field { margin-bottom:14px; }
.setting-field label { display:block;font-size:.78rem;font-weight:700;color:#374151;margin-bottom:5px; }
.setting-field input[type="text"],
.setting-field input[type="url"],
.setting-field input[type="date"] {
    width:100%;max-width:420px;padding:9px 12px;
    border:1.5px solid #e5e7eb;border-radius:8px;font-size:.9rem;
}
.setting-field input:focus { border-color:#0a1931;outline:none; }
.btn-save {
    padding:10px 26px;background:linear-gradient(135deg,#0a1931,#1c2a4d);
    color:#f0c419;border:none;border-radius:9px;font-weight:800;
    font-size:.9rem;cursor:pointer;transition:opacity .2s;
}
.btn-save:hover { opacity:.88; }
.status-dot { width:10px;height:10px;border-radius:50%;display:inline-block;margin-right:6px; }
</style>

<div class="top-bar">
    <h2 class="navigation-title">System Settings</h2>
</div>
<div class="nav-line-separator"></div>

@if(session('updated'))
    <div style="background:#f0fdf4;border:1.5px solid #bbf7d0;border-radius:9px;
                padding:11px 16px;margin-bottom:18px;color:#166534;font-size:.88rem;">
        ✅ {{ session('updated') }}
    </div>
@endif

<form method="POST" action="{{ route('admin.settings.update') }}" id="main-settings-form">
    @csrf

    {{-- High Risk Contact URL --}}
    <div class="settings-card">
        <h3><i class="fas fa-triangle-exclamation" style="color:#dc2626;margin-right:6px;"></i>High-Risk Contact URL</h3>
        <p class="desc">
            Link shown to students when their e-Hayag post is detected as high-risk.
            Should point to a counselor contact form or guidance office page.
        </p>
        <div class="setting-field">
            <label>Contact URL</label>
            <input type="url" name="high_risk_contact_url"
                   value="{{ old('high_risk_contact_url', $settings['high_risk_contact_url']->value ?? '') }}"
                   placeholder="https://...">
        </div>
    </div>

    {{-- Deactivation Date --}}
    <div class="settings-card">
        <h3><i class="fas fa-calendar-days" style="color:#0a1931;margin-right:6px;"></i>Academic Year Deactivation Date</h3>
        <p class="desc">
            On or after this date, all student accounts are automatically deactivated on the next admin page load.
            Changing the date resets the trigger so it fires again on the new date.
        </p>
        @php
            $deactivationDate = $settings['deactivation_date']->value ?? '';
            $deactivationDone = ($settings['deactivation_done']->value ?? '0') === '1';
        @endphp
        <div style="display:flex;align-items:center;gap:14px;flex-wrap:wrap;">
            <div class="setting-field" style="margin-bottom:0;flex:1;min-width:200px;">
                <label>Deactivation Date</label>
                <input type="date" name="deactivation_date"
                       value="{{ old('deactivation_date', $deactivationDate) }}">
            </div>
            <div style="padding-top:18px;">
                @if($deactivationDone)
                    <span style="background:#dcfce7;color:#166534;border:1px solid #bbf7d0;
                                 padding:5px 12px;border-radius:999px;font-size:.72rem;font-weight:700;">
                        <i class="fas fa-check"></i> Deactivated on {{ $deactivationDate }}
                    </span>
                @elseif($deactivationDate)
                    <span style="background:#fef9e7;color:#92400e;border:1px solid rgba(201,162,39,.3);
                                 padding:5px 12px;border-radius:999px;font-size:.72rem;font-weight:700;">
                        <i class="fas fa-clock"></i> Scheduled: {{ $deactivationDate }}
                    </span>
                @else
                    <span style="background:#f3f4f6;color:#9ca3af;border:1px solid #e5e7eb;
                                 padding:5px 12px;border-radius:999px;font-size:.72rem;font-weight:700;">
                        Not set
                    </span>
                @endif
            </div>
        </div>
        <div style="margin-top:12px;padding:9px 14px;background:#fef9e7;
                    border:1px solid rgba(201,162,39,.3);border-radius:8px;font-size:.78rem;color:#92400e;">
            <i class="fas fa-info-circle me-1"></i>
            Students can reactivate via the <strong>Reactivate Account</strong> page using their email and OTP.
        </div>
    </div>

    <button type="submit" class="btn-save">
        <i class="fas fa-floppy-disk me-2"></i> Save Settings
    </button>
</form>

{{-- Alert Recipients Card --}}
<div class="settings-card">
    <h3><i class="fas fa-bell" style="color:#dc2626;margin-right:6px;"></i>High-Risk Alert Recipients</h3>
    <p class="desc">
        Enter the email addresses that should receive notifications when a high-risk post is detected
        and an admin triggers the alert. Separate multiple emails with commas.
        Alerts are <strong>optional</strong> — an admin must manually send them from the High-Risk page.
    </p>
    <form method="POST" action="{{ route('admin.settings.alert_recipients') }}" style="margin:0;">
        @csrf
        <div class="setting-field">
            <label>Recipient Emails <span style="color:var(--muted);font-weight:400;font-size:.72rem;">(comma-separated)</span></label>
            <input type="text" name="alert_recipients"
                   value="{{ $settings['alert_recipients']->value ?? '' }}"
                   placeholder="counselor1@nu-laguna.edu.ph, counselor2@nu-laguna.edu.ph"
                   style="max-width:100%;">
            <div style="font-size:.72rem;color:var(--muted);margin-top:5px;">
                Only valid email addresses are saved. Invalid entries are silently discarded.
            </div>
        </div>
        <button type="submit" class="btn-save">
            <i class="fas fa-floppy-disk me-2"></i> Save Recipients
        </button>
    </form>

    {{-- Show saved list --}}
    @php $savedRecipients = collect(explode(',', $settings['alert_recipients']->value ?? ''))->map(fn($e)=>trim($e))->filter(); @endphp
    @if($savedRecipients->count())
    <div style="margin-top:16px;padding:12px 16px;background:#f0fdf4;border:1px solid #bbf7d0;border-radius:9px;">
        <div style="font-size:.68rem;font-weight:800;color:var(--muted);text-transform:uppercase;letter-spacing:.4px;margin-bottom:8px;">
            Current Recipients ({{ $savedRecipients->count() }})
        </div>
        <div style="display:flex;flex-wrap:wrap;gap:6px;">
            @foreach($savedRecipients as $email)
            <span style="display:inline-flex;align-items:center;gap:4px;padding:3px 10px;
                         background:#dcfce7;color:#166534;border:1px solid #bbf7d0;
                         border-radius:999px;font-size:.75rem;font-weight:600;">
                <i class="fas fa-envelope" style="font-size:.62rem;"></i> {{ $email }}
            </span>
            @endforeach
        </div>
    </div>
    @endif
</div>

{{-- Maintenance Mode --}}
<div class="settings-card" style="margin-top:22px;">
    <h3><i class="fas fa-wrench" style="color:#6b7280;margin-right:6px;"></i>Maintenance Mode</h3>
    <p class="desc">
        When enabled, all public pages show a maintenance screen. Admin panel remains accessible.
    </p>
    @php $maintenance = ($settings['maintenance_mode']->value ?? '0') === '1'; @endphp
    <div style="display:flex;align-items:center;gap:14px;flex-wrap:wrap;">
        <div style="display:flex;align-items:center;gap:8px;">
            <span class="status-dot" style="background:{{ $maintenance ? '#ef4444' : '#22c55e' }};"></span>
            <span style="font-size:.88rem;font-weight:700;color:{{ $maintenance ? '#dc2626' : '#166534' }};">
                {{ $maintenance ? 'Maintenance Mode is ON' : 'Site is Live' }}
            </span>
        </div>
        <form method="POST" action="{{ route('admin.settings.toggle_maintenance') }}" style="margin:0;">
            @csrf
            <button type="submit"
                    style="padding:9px 22px;border:none;border-radius:9px;font-weight:700;
                           font-size:.88rem;cursor:pointer;
                           {{ $maintenance
                               ? 'background:#f0fdf4;color:#166534;border:1.5px solid #bbf7d0;'
                               : 'background:#fef2f2;color:#dc2626;border:1.5px solid #fecaca;' }}">
                <i class="fas fa-{{ $maintenance ? 'globe' : 'ban' }} me-1"></i>
                {{ $maintenance ? 'Disable Maintenance' : 'Enable Maintenance' }}
            </button>
        </form>
    </div>
</div>

{{-- Manual Student Deactivation --}}
<div class="settings-card">
    <h3><i class="fas fa-users" style="color:#0a1931;margin-right:6px;"></i>Manual Student Deactivation</h3>
    <p class="desc">
        Manually activate or deactivate all student accounts at once.
        Active students: <strong>{{ $activeStudentCount }}</strong> /
        Deactivated: <strong>{{ $inactiveStudentCount }}</strong> /
        Total: <strong>{{ $studentCount }}</strong>
    </p>
    <div style="display:flex;gap:12px;flex-wrap:wrap;">
        <form id="deactivate-all-form" method="POST"
              action="{{ route('admin.settings.deactivate_students') }}" style="margin:0;">
            @csrf
            <button type="button"
                    onclick="confirmDelete('deactivate-all-form','all {{ $activeStudentCount }} active student accounts (deactivate)')"
                    style="padding:9px 22px;background:#fef2f2;color:#dc2626;
                           border:1.5px solid #fecaca;border-radius:9px;font-weight:700;
                           font-size:.88rem;cursor:pointer;">
                <i class="fas fa-ban me-1"></i> Deactivate All Students
            </button>
        </form>
        <form method="POST" action="{{ route('admin.settings.activate_students') }}" style="margin:0;">
            @csrf
            <button type="submit"
                    style="padding:9px 22px;background:#f0fdf4;color:#166534;
                           border:1.5px solid #bbf7d0;border-radius:9px;font-weight:700;
                           font-size:.88rem;cursor:pointer;">
                <i class="fas fa-check-circle me-1"></i> Activate All Students
            </button>
        </form>
    </div>
</div>

</x-app-layout>

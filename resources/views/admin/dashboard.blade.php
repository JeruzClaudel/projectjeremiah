
<x-app-layout title="Dashboard">
<style>
.dash-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(220px, 1fr));
    gap: 18px;
    margin-bottom: 32px;
}
.stat-card {
    background: #fff;
    border: 1.5px solid #e5e7eb;
    border-radius: 16px;
    padding: 22px 24px;
    display: flex;
    align-items: center;
    gap: 18px;
    box-shadow: 0 2px 10px rgba(0,0,0,.05);
    transition: transform .2s, box-shadow .2s;
}
.stat-card:hover { transform: translateY(-3px); box-shadow: 0 8px 24px rgba(0,0,0,.09); }
.stat-icon {
    width: 50px; height: 50px;
    border-radius: 14px;
    display: flex; align-items: center; justify-content: center;
    font-size: 1.3rem;
    flex-shrink: 0;
}
.stat-label { font-size: .72rem; font-weight: 700; color: #9ca3af; text-transform: uppercase; letter-spacing: .5px; margin-bottom: 4px; }
.stat-value { font-size: 1.9rem; font-weight: 800; color: #0a1931; line-height: 1; }
.stat-sub   { font-size: .75rem; color: #6b7280; margin-top: 4px; }

.risk-banner {
    background: linear-gradient(135deg, #7f1d1d, #b91c1c);
    border-radius: 14px;
    padding: 18px 24px;
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 16px;
    margin-bottom: 28px;
    flex-wrap: wrap;
}
.risk-banner .rb-text h3 { color: #fca5a5; font-size: 1rem; font-weight: 800; margin: 0 0 4px; }
.risk-banner .rb-text p  { color: rgba(255,255,255,.7); font-size: .82rem; margin: 0; }
.risk-banner .rb-btn {
    display: inline-flex; align-items: center; gap: 8px;
    padding: 9px 20px;
    background: rgba(255,255,255,.15);
    border: 1.5px solid rgba(255,255,255,.3);
    border-radius: 9px;
    color: #fff; font-weight: 700; font-size: .85rem;
    text-decoration: none;
    transition: background .2s;
    white-space: nowrap;
}
.risk-banner .rb-btn:hover { background: rgba(255,255,255,.25); color: #fff; text-decoration: none; }

.quick-actions {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(180px, 1fr));
    gap: 12px;
    margin-bottom: 28px;
}
.qa-btn {
    display: flex; align-items: center; gap: 12px;
    padding: 14px 18px;
    background: #fff;
    border: 1.5px solid #e5e7eb;
    border-radius: 12px;
    text-decoration: none;
    color: #374151;
    font-weight: 600;
    font-size: .88rem;
    transition: border-color .2s, transform .2s;
}
.qa-btn:hover {
    border-color: #0a1931;
    transform: translateY(-2px);
    color: #0a1931;
    text-decoration: none;
}
.qa-btn .qa-icon {
    width: 36px; height: 36px;
    border-radius: 10px;
    display: flex; align-items: center; justify-content: center;
    font-size: .9rem;
    flex-shrink: 0;
}

.section-title {
    font-size: .75rem; font-weight: 800; color: #9ca3af;
    text-transform: uppercase; letter-spacing: .6px;
    margin-bottom: 14px;
}
</style>

<div class="top-bar">
    <h2 class="navigation-title">Dashboard</h2>
    <span style="font-size:.82rem; color:#9ca3af;">
        {{ now()->format('l, F j, Y') }}
    </span>
</div>
<div class="nav-line-separator"></div>

{{-- High risk banner (only show when there are posts today) --}}
@if($highRiskToday > 0)
<div class="risk-banner">
    <div style="display:flex; align-items:center; gap:14px;">
        <div style="width:42px; height:42px; border-radius:50%; background:rgba(255,255,255,.15);
                    display:flex; align-items:center; justify-content:center; font-size:1.2rem;">
            🚨
        </div>
        <div class="rb-text">
            <h3>{{ $highRiskToday }} High-Risk Post{{ $highRiskToday > 1 ? 's' : '' }} Today</h3>
            <p>Student{{ $highRiskToday > 1 ? 's need' : ' needs' }} immediate counselor attention.</p>
        </div>
    </div>
    <a href="{{ route('admin.freedomwall.highrisk') }}" class="rb-btn">
        <i class="fas fa-eye"></i> View Now
    </a>
</div>
@endif

{{-- Stat cards --}}
<div class="section-title">Overview</div>
<div class="dash-grid">
    <div class="stat-card">
        <div class="stat-icon" style="background:#eef4ff; color:#1d4ed8;">
            <i class="fas fa-comment-dots"></i>
        </div>
        <div>
            <div class="stat-label">Total Posts</div>
            <div class="stat-value">{{ number_format($totalPosts) }}</div>
            <div class="stat-sub">{{ $todayPosts }} submitted today</div>
        </div>
    </div>

    <div class="stat-card">
        <div class="stat-icon" style="background:#fef2f2; color:#dc2626;">
            <i class="fas fa-triangle-exclamation"></i>
        </div>
        <div>
            <div class="stat-label">High-Risk Today</div>
            <div class="stat-value" style="{{ $highRiskToday > 0 ? 'color:#dc2626;' : '' }}">
                {{ $highRiskToday }}
            </div>
            <div class="stat-sub">flagged by keyword or AI</div>
        </div>
    </div>

    <div class="stat-card">
        <div class="stat-icon" style="background:#f0fdf4; color:#16a34a;">
            <i class="fas fa-user-tie"></i>
        </div>
        <div>
            <div class="stat-label">Counselors</div>
            <div class="stat-value">{{ $totalCounselors }}</div>
            <div class="stat-sub">registered in the system</div>
        </div>
    </div>

    <div class="stat-card">
        <div class="stat-icon" style="background:#fef9e7; color:#c9a227;">
            <i class="fas fa-users"></i>
        </div>
        <div>
            <div class="stat-label">Students</div>
            <div class="stat-value">{{ $totalStudents }}</div>
            <div class="stat-sub">{{ $activeStudents }} active accounts</div>
        </div>
    </div>
</div>

{{-- Quick actions --}}
<div class="section-title">Quick Actions</div>
<div class="quick-actions">
    <a href="{{ route('admin.freedomwall.freedomwall') }}" class="qa-btn">
        <div class="qa-icon" style="background:#eef4ff; color:#1d4ed8;"><i class="fas fa-comment-dots"></i></div>
        e-Hayag Posts
    </a>
    <a href="{{ route('admin.freedomwall.highrisk') }}" class="qa-btn">
        <div class="qa-icon" style="background:#fef2f2; color:#dc2626;"><i class="fas fa-triangle-exclamation"></i></div>
        High-Risk Posts
    </a>
    <a href="{{ route('admin.freedomwall.analytics') }}" class="qa-btn">
        <div class="qa-icon" style="background:#f0fdf4; color:#16a34a;"><i class="fas fa-chart-bar"></i></div>
        Analytics
    </a>
    <a href="{{ route('admin.counselor.dashboard') }}" class="qa-btn">
        <div class="qa-icon" style="background:#fdf4ff; color:#9333ea;"><i class="fas fa-user-tie"></i></div>
        Counselors
    </a>
    <a href="{{ route('admin.services.dashboard') }}" class="qa-btn">
        <div class="qa-icon" style="background:#fff7ed; color:#ea580c;"><i class="fas fa-concierge-bell"></i></div>
        Services
    </a>
    <a href="{{ route('admin.students.index') }}" class="qa-btn">
        <div class="qa-icon" style="background:#fef9e7; color:#c9a227;"><i class="fas fa-users"></i></div>
        Students
    </a>
    <a href="{{ route('admin.quote.index') }}" class="qa-btn">
        <div class="qa-icon" style="background:#f0fdf4; color:#16a34a;"><i class="fas fa-quote-left"></i></div>
        Quotes
    </a>
    <a href="{{ route('admin.settings.index') }}" class="qa-btn">
        <div class="qa-icon" style="background:#f3f4f6; color:#6b7280;"><i class="fas fa-gear"></i></div>
        Settings
    </a>
</div>

</x-app-layout>

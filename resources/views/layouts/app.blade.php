<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $title ?? 'Admin' }} — Project Jeremiah 33:3</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    @vite(['resources/css/style1.css'])
</head>
<body>

{{-- ── Sidebar overlay (mobile) ── --}}
<div id="sidebar-overlay" onclick="closeSidebar()"></div>

{{-- ── Sidebar ── --}}
<aside id="sidebar" class="admin-sidebar">

    <div class="sb-brand">
        <div class="sb-brand-icon"><i class="fas fa-dove"></i></div>
        <div class="sb-brand-text">
            <div class="sb-brand-name">Project Jeremiah</div>
            <div class="sb-brand-sub">Admin Panel</div>
        </div>
        <button class="sb-close" onclick="closeSidebar()" aria-label="Close">
            <i class="fas fa-xmark"></i>
        </button>
    </div>

    @auth
    <div class="sb-user">
        <div class="sb-user-avatar">{{ strtoupper(substr(Auth::user()->name, 0, 1)) }}</div>
        <div class="sb-user-info">
            <div class="sb-user-name">{{ Auth::user()->name }}</div>
            <div class="sb-user-role">Administrator</div>
        </div>
    </div>
    @endauth

    <nav class="sb-nav">
        <div class="sb-nav-section">Main</div>

        <a href="{{ route('admin.dashboard') }}"
           class="sb-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
            <i class="fas fa-gauge-high"></i><span>Dashboard</span>
        </a>

        <a href="{{ route('admin.freedomwall.freedomwall') }}"
           class="sb-link {{ request()->routeIs('admin.freedomwall.freedomwall') || request()->routeIs('admin.freedomwall.details') ? 'active' : '' }}">
            <i class="fas fa-comment-dots"></i><span>e-Hayag Posts</span>
        </a>

        <a href="{{ route('admin.freedomwall.highrisk') }}"
           class="sb-link {{ request()->routeIs('admin.freedomwall.highrisk') ? 'active' : '' }}"
           style="padding-left:38px;">
            <i class="fas fa-triangle-exclamation" style="color:#f87171;"></i>
            <span>High-Risk</span>
            @if(!empty($highRiskTodayCount) && $highRiskTodayCount > 0)
            <span style="margin-left:auto;min-width:20px;height:20px;padding:0 5px;
                         background:#ef4444;color:#fff;border-radius:999px;
                         font-size:.62rem;font-weight:800;
                         display:inline-flex;align-items:center;justify-content:center;
                         animation:pulse-red 1.8s infinite;flex-shrink:0;">
                {{ $highRiskTodayCount > 99 ? '99+' : $highRiskTodayCount }}
            </span>
            @endif
        </a>

        <a href="{{ route('admin.freedomwall.analytics') }}"
           class="sb-link {{ request()->routeIs('admin.freedomwall.analytics') ? 'active' : '' }}"
           style="padding-left:38px;">
            <i class="fas fa-chart-bar"></i><span>Analytics</span>
        </a>

        <div class="sb-nav-section">Manage</div>

        <a href="{{ route('admin.counselor.dashboard') }}"
           class="sb-link {{ request()->routeIs('admin.counselor.*') ? 'active' : '' }}">
            <i class="fas fa-user-tie"></i><span>Counselors</span>
        </a>

        <a href="{{ route('admin.services.dashboard') }}"
           class="sb-link {{ request()->routeIs('admin.services.*') ? 'active' : '' }}">
            <i class="fas fa-concierge-bell"></i><span>Services</span>
        </a>

        <a href="{{ route('admin.hotline.dashboard') }}"
           class="sb-link {{ request()->routeIs('admin.hotline.*') ? 'active' : '' }}">
            <i class="fas fa-phone-alt"></i><span>Hotlines</span>
        </a>

        <a href="{{ route('admin.consultation.dashboard') }}"
           class="sb-link {{ request()->routeIs('admin.consultation.*') ? 'active' : '' }}">
            <i class="fas fa-calendar-check"></i><span>Consultation</span>
        </a>

        <a href="{{ route('admin.quote.index') }}"
           class="sb-link {{ request()->routeIs('admin.quote.*') ? 'active' : '' }}">
            <i class="fas fa-quote-left"></i><span>Quotes</span>
        </a>

        <a href="{{ route('admin.link.index') }}"
           class="sb-link {{ request()->routeIs('admin.link.*') ? 'active' : '' }}">
            <i class="fas fa-link"></i><span>Links</span>
        </a>

        <a href="{{ route('admin.support.index') }}"
           class="sb-link {{ request()->routeIs('admin.support.*') ? 'active' : '' }}">
            <i class="fas fa-hands-helping"></i><span>Support Resources</span>
        </a>

        <div class="sb-nav-section">System</div>

        <a href="{{ route('admin.students.index') }}"
           class="sb-link {{ request()->routeIs('admin.students.*') ? 'active' : '' }}">
            <i class="fas fa-users"></i><span>Students</span>
        </a>

        <a href="{{ route('admin.accounts.index') }}"
           class="sb-link {{ request()->routeIs('admin.accounts.*') ? 'active' : '' }}">
            <i class="fas fa-user-shield"></i><span>Admin Accounts</span>
        </a>

        <a href="{{ route('admin.sentiment.keywords') }}"
           class="sb-link {{ request()->routeIs('admin.sentiment.*') ? 'active' : '' }}">
            <i class="fas fa-tags"></i><span>Sentiment Keywords</span>
        </a>

        <a href="{{ route('admin.settings.index') }}"
           class="sb-link {{ request()->routeIs('admin.settings.*') ? 'active' : '' }}">
            <i class="fas fa-gear"></i><span>Settings</span>
        </a>

        <div class="sb-divider"></div>

        <form method="POST" action="{{ route('logout') }}" style="margin:0;">
            @csrf
            <button type="submit" class="sb-link sb-logout"
                    style="width:100%;text-align:left;background:none;border:none;cursor:pointer;">
                <i class="fas fa-right-from-bracket"></i><span>Log Out</span>
            </button>
        </form>

        <a href="{{ route('home') }}" target="_blank"
           class="sb-link" style="color:rgba(255,255,255,.35);margin-top:4px;">
            <i class="fas fa-arrow-up-right-from-square"></i><span>View Public Site</span>
        </a>
    </nav>
</aside>

{{-- ── Top bar ── --}}
<div class="admin-topbar">
    <button class="topbar-hamburger" onclick="openSidebar()" aria-label="Menu">
        <i class="fas fa-bars"></i>
    </button>
    <div class="topbar-title">{{ $title ?? 'Admin' }}</div>
    <div class="topbar-right">
        <span class="topbar-date">{{ now()->format('M j, Y') }}</span>
        @auth
        <div class="topbar-avatar">{{ strtoupper(substr(Auth::user()->name, 0, 1)) }}</div>
        @endauth
    </div>
</div>

{{-- ── Main content ── --}}
<main class="admin-main">
    {{ $slot }}
</main>

{{-- ── Delete confirmation modal ── --}}
<div id="confirm-modal" class="modal-backdrop" style="display:none;">
    <div class="modal-box">
        <div class="modal-icon"><i class="fas fa-triangle-exclamation"></i></div>
        <div class="modal-title">Confirm Delete</div>
        <p id="confirm-msg" class="modal-msg"></p>
        <div class="modal-actions">
            <button onclick="document.getElementById('confirm-modal').style.display='none'"
                    class="btn-cancel">Cancel</button>
            <button id="confirm-ok" class="btn-danger-confirm">
                <i class="fas fa-trash"></i> Delete
            </button>
        </div>
    </div>
</div>

{{-- ── Toast flash notifications ── --}}
@foreach(['success','updated','added','deleted','error'] as $key)
    @if(session($key))
    <div class="admin-toast {{ in_array($key, ['deleted','error']) ? 'toast-red' : 'toast-green' }}"
         id="admin-toast-{{ $loop->index }}">
        <i class="fas fa-{{ in_array($key, ['deleted','error']) ? 'circle-xmark' : 'circle-check' }}"></i>
        <span>{{ session($key) }}</span>
        <button onclick="this.closest('.admin-toast').remove()"
                style="background:none;border:none;cursor:pointer;color:inherit;margin-left:auto;padding:0 0 0 8px;">
            <i class="fas fa-xmark"></i>
        </button>
    </div>
    <script>
    (function(){
        var t = document.getElementById('admin-toast-{{ $loop->index }}');
        if(t) setTimeout(function(){
            t.style.opacity='0'; t.style.transform='translateX(120%)';
            setTimeout(function(){ t && t.remove(); }, 400);
        }, 4000);
    })();
    </script>
    @endif
@endforeach

<script>
function openSidebar() {
    document.getElementById('sidebar').classList.add('open');
    document.getElementById('sidebar-overlay').classList.add('visible');
    document.body.style.overflow = 'hidden';
}
function closeSidebar() {
    document.getElementById('sidebar').classList.remove('open');
    document.getElementById('sidebar-overlay').classList.remove('visible');
    document.body.style.overflow = '';
}
function confirmDelete(formId, label) {
    const modal = document.getElementById('confirm-modal');
    document.getElementById('confirm-msg').textContent =
        'Are you sure you want to delete ' + (label || 'this item') + '? This cannot be undone.';
    modal.style.display = 'flex';
    document.getElementById('confirm-ok').onclick = function () {
        modal.style.display = 'none';
        document.getElementById(formId).submit();
    };
}
document.getElementById('confirm-modal').addEventListener('click', function(e) {
    if (e.target === this) this.style.display = 'none';
});
</script>
</body>
</html>

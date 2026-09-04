<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Project Jeremiah 33:3')</title>
    @vite('resources/css/styles.css')
    @yield('styles')
</head>
<body>

<a class="skip" href="#main-content">Skip to content</a>

{{-- Topbar --}}
<div class="pj-topbar">
    <div class="shell">
        <strong>You are welcome here</strong>
        <span>Confidential channels · Caring people · A safe place to begin</span>
    </div>
</div>

{{-- Header --}}
<header class="pj-header">
    <nav class="pj-nav" aria-label="Main navigation">
        <a href="{{ route('home') }}" class="pj-brand">
            <span class="pj-brand-mark"><img src="{{ asset('nu-logo.png') }}" alt="NU logo"></span>
            <span>Project Jeremiah 33:3<small>Guidance Services Office</small></span>
        </a>

        <button class="pj-menu" id="pj-menu-btn" aria-label="Open navigation" aria-expanded="false">☰</button>

        <ul class="pj-navlinks" id="pj-navlinks" role="list">
            <li><a href="{{ route('home') }}"
                   class="{{ request()->routeIs('home') ? 'active' : '' }}">Home</a></li>
            <li><a href="{{ route('user.services') }}"
                   class="{{ request()->routeIs('user.services*') ? 'active' : '' }}">Services</a></li>
            <li><a href="{{ route('user.freedomwall.add') }}"
                   class="{{ request()->routeIs('user.freedomwall*') ? 'active' : '' }}">e-Hayag</a></li>
            <li><a href="{{ route('user.hotline') }}"
                   class="{{ request()->routeIs('user.hotline*') ? 'active' : '' }}">Hotlines</a></li>
            <li><a href="{{ route('student.register') }}"
                   class="nav-register {{ request()->routeIs('student.register*') ? 'active' : '' }}">Register</a></li>
        </ul>
    </nav>
</header>

{{-- Main content --}}
<main id="main-content">
    @yield('content')
</main>

{{-- Footer --}}
<footer class="pj-footer">
    <div class="shell">
        <div class="footer-grid">
            <div>
                <a href="{{ route('home') }}" class="pj-brand">
                    <span class="pj-brand-mark">J</span>
                    <span>Project Jeremiah<small>Guidance Services Office</small></span>
                </a>
                <p class="footer-quote">"Call to Me and I Will Answer You" — Jeremiah 33:3</p>
            </div>
            <div>
                <h4>Quick links</h4>
                <ul>
                    <li><a href="{{ route('home') }}">Home</a></li>
                    <li><a href="{{ route('user.services') }}">Services</a></li>
                    <li><a href="{{ route('user.freedomwall.add') }}">e-Hayag</a></li>
                </ul>
            </div>
            <div>
                <h4>Get support</h4>
                <ul>
                    <li><a href="{{ route('user.hotline') }}">Hotlines</a></li>
                    <li><a href="{{ route('student.register') }}">Register</a></li>
                    <li><a href="{{ route('student.reactivate.request') }}">Reactivate Account</a></li>
                </ul>
            </div>
            <div>
                <h4>Information</h4>
                <ul>
                    <li><a href="{{ route('student.register') }}">Privacy Notice</a></li>
                    <li><a href="{{ route('home') }}">Contact Us</a></li>
                </ul>
                {{-- Active quick links from DB --}}
                @if(isset($footerLinks) && $footerLinks->count())
                <h4 style="margin-top:16px;">Quick Links</h4>
                <ul>
                    @foreach($footerLinks as $fl)
                    <li>
                        <a href="{{ $fl->url }}" target="_blank">
                            @if($fl->icon)<i class="{{ $fl->icon }}" style="margin-right:4px;font-size:.8rem;"></i>@endif
                            {{ $fl->name }}
                        </a>
                    </li>
                    @endforeach
                </ul>
                @endif
            </div>
        </div>
        <div class="footer-bottom">
            <span>&copy; {{ date('Y') }} Project Jeremiah 33:3 — Guidance Services Office, NU Laguna</span>
            <span>Built for students, with care.</span>
        </div>
    </div>
</footer>

<script>
(function () {
    const btn  = document.getElementById('pj-menu-btn');
    const nav  = document.getElementById('pj-navlinks');
    if (!btn || !nav) return;
    btn.addEventListener('click', function () {
        const open = nav.classList.toggle('open');
        btn.setAttribute('aria-expanded', String(open));
        btn.textContent = open ? '✕' : '☰';
    });
    document.addEventListener('click', function (e) {
        if (!btn.contains(e.target) && !nav.contains(e.target)) {
            nav.classList.remove('open');
            btn.setAttribute('aria-expanded', 'false');
            btn.textContent = '☰';
        }
    });
}());
</script>

@yield('scripts')

{{-- ── Account registered / reactivated modals ── --}}
@if(session('account_registered') || session('account_reactivated'))
@php
    $isRegistered   = session('account_registered');
    $isReactivated  = session('account_reactivated');
    $studentName    = $isRegistered ?: $isReactivated;

    // Pull deactivation date from system settings if available
    try {
        $deactivationDate = \App\Models\SystemSetting::get('deactivation_date', '');
        $deactivationLabel = $deactivationDate
            ? \Carbon\Carbon::parse($deactivationDate)->format('F j, Y')
            : null;
    } catch (\Exception $e) {
        $deactivationLabel = null;
    }
@endphp

<div id="account-modal-overlay"
     style="position:fixed;inset:0;z-index:9999;
            background:rgba(0,0,0,.55);backdrop-filter:blur(3px);
            display:flex;align-items:center;justify-content:center;padding:20px;"
     onclick="if(event.target===this)closeAccountModal()">

    <div style="background:#fff;border-radius:24px;width:min(500px,100%);
                box-shadow:0 28px 64px rgba(0,0,0,.25);overflow:hidden;
                animation:modalIn .35s ease both;">

        {{-- Coloured header --}}
        <div style="background:{{ $isRegistered ? 'linear-gradient(135deg,#31428A,#36408E)' : 'linear-gradient(135deg,#166534,#15803d)' }};
                    padding:32px 32px 28px;text-align:center;position:relative;">

            {{-- Icon circle --}}
            <div style="width:72px;height:72px;border-radius:50%;
                        background:{{ $isRegistered ? '#FAD116' : '#bbf7d0' }};
                        display:flex;align-items:center;justify-content:center;
                        margin:0 auto 16px;font-size:2rem;
                        box-shadow:0 0 0 12px rgba(255,255,255,.15);">
                {{ $isRegistered ? '✓' : '↺' }}
            </div>

            <h2 style="color:#fff;font-family:'Space Grotesk',sans-serif;
                       font-size:1.35rem;font-weight:800;margin-bottom:6px;">
                @if($isRegistered)
                    Account Created Successfully!
                @else
                    Account Reactivated!
                @endif
            </h2>

            <p style="color:rgba(255,255,255,.75);font-size:.9rem;">
                Welcome{{ $studentName ? ', ' . $studentName : '' }}!
            </p>
        </div>

        {{-- Body --}}
        <div style="padding:28px 32px;">

            @if($isRegistered)
            {{-- Registration success message --}}
            <div style="margin-bottom:18px;">
                <p style="color:#111827;font-size:.95rem;line-height:1.75;margin-bottom:14px;">
                    Your student account has been <strong>verified and created</strong>.
                    You can now use your registered email to submit posts on <strong>e-Hayag</strong>.
                </p>

                <div style="background:#f0fdf4;border:1px solid #bbf7d0;border-radius:12px;
                            padding:14px 18px;font-size:.84rem;color:#166534;line-height:1.65;">
                    <i class="fas fa-circle-check" style="margin-right:6px;"></i>
                    <strong>Email verified</strong> · Account active · Ready to use e-Hayag
                </div>
            </div>
            @else
            {{-- Reactivation success message --}}
            <div style="margin-bottom:18px;">
                <p style="color:#111827;font-size:.95rem;line-height:1.75;margin-bottom:14px;">
                    Your account has been <strong>successfully reactivated</strong>.
                    You can now submit posts on e-Hayag again.
                </p>

                <div style="background:#f0fdf4;border:1px solid #bbf7d0;border-radius:12px;
                            padding:14px 18px;font-size:.84rem;color:#166534;line-height:1.65;">
                    <i class="fas fa-rotate-right" style="margin-right:6px;"></i>
                    <strong>Account reactivated</strong> · Access restored
                </div>
            </div>
            @endif

            {{-- Deactivation notice -- shown for both --}}
            <div style="background:#fef9e7;border:1px solid rgba(250,209,22,.4);
                        border-left:4px solid #FAD116;border-radius:0 10px 10px 0;
                        padding:14px 18px;font-size:.84rem;color:#92400e;line-height:1.65;
                        margin-bottom:22px;">
                <i class="fas fa-info-circle" style="margin-right:6px;color:#c9a227;"></i>
                <strong>Important — Academic Year Policy</strong><br>
                Your account will be <strong>automatically deactivated</strong> at the end of the academic year.
                @if($deactivationLabel)
                    The current deactivation date is set to <strong>{{ $deactivationLabel }}</strong>.
                @endif
                To continue using e-Hayag after deactivation, simply <strong>reactivate your account</strong>
                using your email and a new OTP code. No re-registration needed.
            </div>

            {{-- Action buttons --}}
            <div style="display:flex;gap:10px;flex-wrap:wrap;">
                @if($isRegistered)
                <a href="{{ route('user.freedomwall.create') }}"
                   style="flex:1;min-width:160px;display:flex;align-items:center;
                          justify-content:center;gap:7px;padding:12px;
                          background:linear-gradient(135deg,#31428A,#36408E);
                          color:#FAD116;border-radius:11px;font-size:.88rem;
                          font-weight:700;text-decoration:none;transition:opacity .18s;"
                   onmouseover="this.style.opacity='.88'"
                   onmouseout="this.style.opacity='1'">
                    <span>✎</span> Try e-Hayag Now
                </a>
                @else
                <a href="{{ route('user.freedomwall.create') }}"
                   style="flex:1;min-width:160px;display:flex;align-items:center;
                          justify-content:center;gap:7px;padding:12px;
                          background:linear-gradient(135deg,#166534,#15803d);
                          color:#fff;border-radius:11px;font-size:.88rem;
                          font-weight:700;text-decoration:none;transition:opacity .18s;"
                   onmouseover="this.style.opacity='.88'"
                   onmouseout="this.style.opacity='1'">
                    <span>✎</span> Post on e-Hayag
                </a>
                @endif

                <button onclick="closeAccountModal()"
                        style="padding:12px 20px;background:#f3f4f6;color:#374151;
                               border:1.5px solid #e5e7eb;border-radius:11px;
                               font-size:.88rem;font-weight:600;cursor:pointer;
                               transition:background .15s;"
                        onmouseover="this.style.background='#e5e7eb'"
                        onmouseout="this.style.background='#f3f4f6'">
                    Got it
                </button>
            </div>
        </div>

    </div>
</div>

<style>
@@keyframes modalIn {
    from { opacity:0; transform:translateY(20px) scale(.97); }
    to   { opacity:1; transform:translateY(0) scale(1); }
}
</style>

<script>
function closeAccountModal() {
    const overlay = document.getElementById('account-modal-overlay');
    if (overlay) {
        overlay.style.opacity    = '0';
        overlay.style.transition = 'opacity .25s ease';
        setTimeout(() => overlay.remove(), 260);
    }
}
// Close on Escape key
document.addEventListener('keydown', function(e) {
    if (e.key === 'Escape') closeAccountModal();
});
</script>

@endif

</body>
</html>

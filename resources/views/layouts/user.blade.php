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
</body>
</html>

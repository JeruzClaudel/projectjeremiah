<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Project Jeremiah 33:3')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    @yield('styles')
    <style>
        /* ── CSS Variables ── */
        :root {
            --navy:   #0a1931;
            --navy2:  #1c2a4d;
            --gold:   #f0c419;
            --gold2:  #c9a227;
            --light:  #f8f9fc;
            --border: #e5e7eb;
            --text:   #374151;
            --muted:  #6b7280;
            --radius: 14px;
            --shadow: 0 4px 20px rgba(0,0,0,.08);
        }

        /* ── Reset & Base ── */
        *, *::before, *::after { box-sizing: border-box; }
        html { scroll-behavior: smooth; }
        body {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, sans-serif;
            background: #f8f9fc;
            color: var(--text);
            margin: 0;
            padding: 0;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }
        img { max-width: 100%; }
        a { color: inherit; }

        /* ── Navbar ── */
        .pj-nav {
            background: linear-gradient(135deg, var(--navy), var(--navy2));
            padding: 0;
            position: sticky;
            top: 0;
            z-index: 1000;
            box-shadow: 0 2px 16px rgba(0,0,0,.25);
        }
        .pj-nav .nav-inner {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 20px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            height: 64px;
        }
        .pj-nav .brand {
            display: flex;
            align-items: center;
            gap: 10px;
            text-decoration: none;
            color: var(--gold);
            font-size: 1rem;
            font-weight: 800;
            letter-spacing: .3px;
            white-space: nowrap;
        }
        .pj-nav .brand .brand-icon {
            width: 36px; height: 36px;
            background: rgba(240,196,25,.15);
            border: 1.5px solid rgba(240,196,25,.4);
            border-radius: 9px;
            display: flex; align-items: center; justify-content: center;
            font-size: .85rem;
            color: var(--gold);
            flex-shrink: 0;
        }
        .pj-nav .nav-links {
            display: flex;
            align-items: center;
            gap: 4px;
            list-style: none;
            margin: 0; padding: 0;
        }
        .pj-nav .nav-links a {
            display: flex;
            align-items: center;
            gap: 6px;
            padding: 8px 14px;
            color: rgba(255,255,255,.8);
            text-decoration: none;
            font-size: .88rem;
            font-weight: 500;
            border-radius: 8px;
            transition: all .2s;
            white-space: nowrap;
        }
        .pj-nav .nav-links a:hover,
        .pj-nav .nav-links a.active {
            color: var(--gold);
            background: rgba(240,196,25,.12);
        }
        .pj-nav .nav-links a i { font-size: .8rem; }
        .pj-nav .nav-divider {
            width: 1px; height: 28px;
            background: rgba(255,255,255,.12);
            margin: 0 6px;
        }
        /* Register/Reactivate get a different style */
        .pj-nav .nav-links a.nav-register {
            color: var(--gold);
            border: 1px solid rgba(240,196,25,.4);
            padding: 6px 14px;
        }
        .pj-nav .nav-links a.nav-register:hover {
            background: rgba(240,196,25,.2);
        }

        /* Hamburger */
        .pj-nav .hamburger {
            display: none;
            flex-direction: column;
            gap: 5px;
            cursor: pointer;
            padding: 8px;
            background: none;
            border: none;
        }
        .pj-nav .hamburger span {
            display: block;
            width: 22px; height: 2px;
            background: rgba(255,255,255,.8);
            border-radius: 2px;
            transition: all .3s;
        }

        /* Mobile nav drawer */
        .pj-nav .mobile-drawer {
            display: none;
            flex-direction: column;
            background: linear-gradient(135deg, var(--navy), var(--navy2));
            border-top: 1px solid rgba(255,255,255,.08);
            padding: 12px 16px 16px;
        }
        .pj-nav .mobile-drawer.open { display: flex; }
        .pj-nav .mobile-drawer a {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 11px 14px;
            color: rgba(255,255,255,.85);
            text-decoration: none;
            font-size: .92rem;
            font-weight: 500;
            border-radius: 9px;
            transition: all .2s;
        }
        .pj-nav .mobile-drawer a:hover { color: var(--gold); background: rgba(240,196,25,.1); }
        .pj-nav .mobile-drawer .m-divider {
            height: 1px;
            background: rgba(255,255,255,.1);
            margin: 6px 0;
        }
        .pj-nav .mobile-drawer a.m-register {
            color: var(--gold);
            border: 1px solid rgba(240,196,25,.3);
            margin-top: 4px;
        }

        @media (max-width: 900px) {
            .pj-nav .nav-links { display: none; }
            .pj-nav .hamburger { display: flex; }
        }

        /* ── Page wrapper ── */
        .page-wrap {
            flex: 1;
            max-width: 1200px;
            margin: 0 auto;
            width: 100%;
            padding: 28px 20px 48px;
        }

        /* ── Hero banner ── */
        .pub-hero {
            background: linear-gradient(135deg, var(--navy) 0%, var(--navy2) 55%, #2a3f6b 100%);
            border-radius: 20px;
            padding: 64px 40px;
            text-align: center;
            color: #fff;
            position: relative;
            overflow: hidden;
            margin-bottom: 40px;
        }
        .pub-hero::before {
            content: '';
            position: absolute; inset: 0;
            background: radial-gradient(ellipse at 20% 50%, rgba(240,196,25,.08) 0%, transparent 60%),
                        radial-gradient(ellipse at 80% 50%, rgba(240,196,25,.06) 0%, transparent 60%);
        }
        .pub-hero .hero-inner { position: relative; z-index: 1; }
        .pub-hero h1 { color: var(--gold); font-size: clamp(1.8rem,4vw,3rem); font-weight: 800; margin-bottom: 14px; }
        .pub-hero p  { color: rgba(255,255,255,.82); font-size: clamp(.95rem,2vw,1.15rem); line-height: 1.7; max-width: 680px; margin: 0 auto; }
        @media (max-width: 576px) { .pub-hero { padding: 44px 22px; } }

        /* ── Section title ── */
        .sec-title {
            font-size: 1.25rem; font-weight: 800; color: var(--navy);
            margin-bottom: 6px;
        }
        .sec-line {
            width: 48px; height: 4px;
            background: var(--gold); border-radius: 2px;
            margin-bottom: 28px;
        }

        /* ── Cards (generic) ── */
        .pub-card {
            background: #fff;
            border-radius: var(--radius);
            border: 1.5px solid var(--border);
            box-shadow: var(--shadow);
            transition: transform .25s, box-shadow .25s;
            overflow: hidden;
        }
        .pub-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 12px 32px rgba(0,0,0,.12);
        }

        /* ── Option cards (home) ── */
        .opt-card {
            background: #fff;
            border-radius: var(--radius);
            border: 1.5px solid var(--border);
            padding: 32px 24px;
            text-align: center;
            box-shadow: var(--shadow);
            transition: transform .25s, box-shadow .25s, border-color .25s;
            height: 100%;
        }
        .opt-card:hover { transform: translateY(-6px); box-shadow: 0 16px 40px rgba(0,0,0,.12); border-color: var(--gold2); }
        .opt-card .opt-icon {
            width: 64px; height: 64px;
            border-radius: 16px;
            display: flex; align-items: center; justify-content: center;
            margin: 0 auto 20px;
            font-size: 1.6rem;
        }
        .opt-card h3 { font-size: 1.05rem; font-weight: 700; color: var(--navy); margin-bottom: 10px; }
        .opt-card p  { font-size: .88rem; color: var(--muted); line-height: 1.65; margin-bottom: 22px; }
        .opt-btn {
            display: inline-flex; align-items: center; gap: 7px;
            padding: 10px 22px;
            background: linear-gradient(135deg, var(--navy), var(--navy2));
            color: var(--gold);
            border-radius: 999px;
            font-size: .85rem; font-weight: 700;
            text-decoration: none;
            transition: opacity .2s, transform .2s;
        }
        .opt-btn:hover { opacity: .88; transform: translateY(-1px); color: var(--gold); text-decoration: none; }
        .opt-btn.danger { background: linear-gradient(135deg, #991b1b, #dc2626); color: #fff; }

        /* ── Hotline card ── */
        .hotline-card {
            background: #fff;
            border-radius: var(--radius);
            border: 1.5px solid var(--border);
            padding: 24px;
            box-shadow: var(--shadow);
            height: 100%;
            transition: transform .25s, box-shadow .25s;
        }
        .hotline-card:hover { transform: translateY(-4px); box-shadow: 0 12px 32px rgba(0,0,0,.12); }
        .hotline-card .hc-icon {
            width: 52px; height: 52px;
            border-radius: 50%;
            background: linear-gradient(135deg, var(--navy), var(--navy2));
            display: flex; align-items: center; justify-content: center;
            color: var(--gold); font-size: 1.2rem;
            margin-bottom: 14px;
            flex-shrink: 0;
        }
        .hotline-card h5 { font-size: 1rem; font-weight: 700; color: var(--navy); margin-bottom: 6px; }
        .hotline-card .hc-phone {
            font-size: 1.05rem; font-weight: 800; color: #dc2626;
            margin: 8px 0 4px;
        }
        .hotline-card .hc-avail {
            display: inline-flex; align-items: center; gap: 5px;
            font-size: .75rem; font-weight: 700;
            color: #166534; background: #f0fdf4;
            border: 1px solid #bbf7d0;
            padding: 3px 10px; border-radius: 999px;
            margin-top: 8px;
        }

        /* ── e-Hayag form page ── */
        .ehayag-hero { text-align: center; margin-bottom: 32px; }
        .ehayag-hero .ej-icon {
            width: 72px; height: 72px;
            background: linear-gradient(135deg, var(--navy), var(--navy2));
            border-radius: 18px;
            display: flex; align-items: center; justify-content: center;
            margin: 0 auto 16px;
            font-size: 1.8rem; color: var(--gold);
        }
        .ehayag-hero h1 { font-size: 1.9rem; font-weight: 800; color: var(--navy); margin-bottom: 8px; }
        .ehayag-hero p  { color: var(--muted); font-size: .95rem; line-height: 1.7; max-width: 560px; margin: 0 auto; }
        .ehayag-form-card {
            background: #fff;
            border-radius: 18px;
            border: 1.5px solid var(--border);
            padding: 32px;
            box-shadow: var(--shadow);
            max-width: 580px;
            margin: 0 auto;
        }
        .ef-group { margin-bottom: 20px; }
        .ef-group label { display: block; font-size: .8rem; font-weight: 700; color: var(--text); margin-bottom: 6px; }
        .ef-input {
            width: 100%; padding: 11px 14px;
            border: 1.5px solid var(--border);
            border-radius: 9px; font-size: .93rem;
            transition: border-color .2s;
        }
        .ef-input:focus { border-color: var(--navy); outline: none; }
        .ef-textarea { resize: vertical; min-height: 140px; }
        .ef-submit {
            width: 100%; padding: 13px;
            background: linear-gradient(135deg, var(--navy), var(--navy2));
            color: var(--gold); border: none; border-radius: 10px;
            font-size: .95rem; font-weight: 800; cursor: pointer;
            transition: opacity .2s, transform .2s;
        }
        .ef-submit:hover { opacity: .88; transform: translateY(-1px); }
        .ef-helper {
            font-size: .75rem; color: var(--muted);
            margin-top: 5px; display: block; line-height: 1.5;
        }
        .ef-helper a { color: var(--navy); font-weight: 700; text-decoration: underline; }

        /* ── Info box ── */
        .info-box {
            background: #fef9e7;
            border: 1px solid rgba(201,162,39,.3);
            border-left: 4px solid var(--gold);
            border-radius: 10px;
            padding: 14px 18px;
            font-size: .85rem; color: #92400e; line-height: 1.65;
        }
        .danger-box {
            background: #fef2f2;
            border: 1px solid #fecaca;
            border-left: 4px solid #ef4444;
            border-radius: 10px;
            padding: 14px 18px;
            font-size: .88rem; color: #b91c1c; line-height: 1.65;
        }

        /* ── Submitted page ── */
        .submitted-hero {
            background: linear-gradient(135deg, var(--navy), var(--navy2));
            border-radius: 20px;
            padding: 60px 32px;
            text-align: center;
            color: #fff;
            margin-bottom: 32px;
        }
        .submitted-hero .check-circle {
            width: 80px; height: 80px;
            background: rgba(240,196,25,.15);
            border: 3px solid rgba(240,196,25,.5);
            border-radius: 50%;
            display: flex; align-items: center; justify-content: center;
            margin: 0 auto 20px;
            font-size: 2rem; color: var(--gold);
        }
        .submitted-hero h1 { color: var(--gold); font-size: clamp(1.5rem,3vw,2rem); font-weight: 800; margin-bottom: 10px; }
        .submitted-hero p  { color: rgba(255,255,255,.8); font-size: .95rem; line-height: 1.7; }

        /* ── Service card ── */
        .svc-card {
            background: #fff;
            border-radius: var(--radius);
            border: 1.5px solid var(--border);
            padding: 24px;
            box-shadow: var(--shadow);
            height: 100%;
            transition: transform .25s, box-shadow .25s, border-color .25s;
            text-decoration: none;
            display: block;
            color: inherit;
        }
        .svc-card:hover { transform: translateY(-5px); box-shadow: 0 14px 36px rgba(0,0,0,.12); border-color: var(--gold2); color: inherit; text-decoration: none; }
        .svc-card .svc-icon {
            width: 48px; height: 48px;
            background: linear-gradient(135deg, var(--navy), var(--navy2));
            border-radius: 12px;
            display: flex; align-items: center; justify-content: center;
            color: var(--gold); font-size: 1.1rem;
            margin-bottom: 14px;
        }
        .svc-card h4 { font-size: .98rem; font-weight: 700; color: var(--navy); margin-bottom: 8px; }
        .svc-card p  { font-size: .85rem; color: var(--muted); line-height: 1.6; margin: 0; }

        /* ── Counselor card ── */
        .cns-card {
            background: #fff;
            border-radius: var(--radius);
            border: 1.5px solid var(--border);
            padding: 28px 20px;
            text-align: center;
            box-shadow: var(--shadow);
            height: 100%;
            transition: transform .25s, box-shadow .25s;
        }
        .cns-card:hover { transform: translateY(-5px); box-shadow: 0 14px 36px rgba(0,0,0,.12); }
        .cns-avatar {
            width: 100px; height: 100px;
            border-radius: 50%;
            object-fit: cover;
            border: 3px solid var(--gold);
            margin: 0 auto 14px;
            display: block;
        }
        .cns-card h5 { font-size: .98rem; font-weight: 700; color: var(--navy); margin-bottom: 4px; }
        .cns-card .cns-pos { font-size: .8rem; color: var(--muted); margin-bottom: 2px; }
        .cns-card .cns-dept{ font-size: .78rem; color: var(--muted); margin-bottom: 14px; }

        /* ── Back link ── */
        .back-link {
            display: inline-flex; align-items: center; gap: 7px;
            font-size: .85rem; font-weight: 600; color: var(--navy);
            text-decoration: none; margin-bottom: 22px;
        }
        .back-link:hover { color: var(--gold2); }

        /* ── Footer ── */
        .pj-footer {
            background: linear-gradient(135deg, var(--navy), var(--navy2));
            color: rgba(255,255,255,.6);
            text-align: center;
            padding: 22px 20px;
            font-size: .82rem;
            margin-top: auto;
        }
        .pj-footer strong { color: var(--gold); }

        /* ── Alert / error ── */
        .field-error { color: #dc2626; font-size: .78rem; margin-top: 5px; display: block; }
        .deactivate-box {
            margin-top: 10px; padding: 12px 16px;
            background: rgba(201,162,39,.12); border: 1px solid rgba(201,162,39,.35);
            border-radius: 9px;
        }
        .deactivate-box p { color: var(--gold); font-size: .82rem; margin: 0 0 8px; }

        /* ── Animations ── */
        @keyframes fadeUp {
            from { opacity: 0; transform: translateY(24px); }
            to   { opacity: 1; transform: translateY(0); }
        }
        .fade-up { animation: fadeUp .5s ease both; }
        .fade-up-d1 { animation-delay: .1s; }
        .fade-up-d2 { animation-delay: .2s; }
        .fade-up-d3 { animation-delay: .3s; }
        .fade-up-d4 { animation-delay: .4s; }

        /* ── Utilities ── */
        .text-navy  { color: var(--navy); }
        .text-gold  { color: var(--gold); }
        .bg-navy    { background: var(--navy); }

        @media (max-width: 576px) {
            .page-wrap { padding: 20px 14px 40px; }
            .ehayag-form-card { padding: 22px 16px; }
        }
    </style>
</head>
<body>

{{-- ── Sticky Navbar ── --}}
<nav class="pj-nav">
    <div class="nav-inner">
        <a href="{{ route('home') }}" class="brand">
            <div class="brand-icon"><i class="fas fa-dove"></i></div>
            PROJECT JEREMIAH
        </a>

        {{-- Desktop nav --}}
        <ul class="nav-links">
            <li><a href="{{ route('home') }}" class="{{ request()->routeIs('home') ? 'active' : '' }}">
                <i class="fas fa-house"></i> Home
            </a></li>
            <li><a href="{{ route('user.services') }}" class="{{ request()->routeIs('user.services*') ? 'active' : '' }}">
                <i class="fas fa-concierge-bell"></i> Services
            </a></li>
            <li><a href="{{ route('user.freedomwall.add') }}" class="{{ request()->routeIs('user.freedomwall*') ? 'active' : '' }}">
                <i class="fas fa-comment-dots"></i> e-Hayag
            </a></li>
            <li><a href="{{ route('user.hotline') }}" class="{{ request()->routeIs('user.hotline*') ? 'active' : '' }}">
                <i class="fas fa-phone-alt"></i> Hotlines
            </a></li>
            <div class="nav-divider"></div>
            <li><a href="{{ route('student.register') }}" class="nav-register">
                <i class="fas fa-user-plus"></i> Register
            </a></li>
        </ul>

        {{-- Hamburger --}}
        <button class="hamburger" id="hamburger" aria-label="Menu">
            <span></span><span></span><span></span>
        </button>
    </div>

    {{-- Mobile drawer --}}
    <div class="mobile-drawer" id="mobile-drawer">
        <a href="{{ route('home') }}"><i class="fas fa-house"></i> Home</a>
        <a href="{{ route('user.services') }}"><i class="fas fa-concierge-bell"></i> Services</a>
        <a href="{{ route('user.freedomwall.add') }}"><i class="fas fa-comment-dots"></i> e-Hayag</a>
        <a href="{{ route('user.hotline') }}"><i class="fas fa-phone-alt"></i> Emergency Hotlines</a>
        <div class="m-divider"></div>
        <a href="{{ route('student.register') }}" class="m-register"><i class="fas fa-user-plus"></i> Register Account</a>
        <a href="{{ route('student.reactivate.request') }}" class="m-register"><i class="fas fa-rotate-right"></i> Reactivate Account</a>
    </div>
</nav>

{{-- ── Main content ── --}}
<div class="page-wrap">
    @yield('content')
</div>

{{-- ── Footer ── --}}
<footer class="pj-footer">
    @if(isset($footerLinks) && $footerLinks->count())
    <div style="max-width:1200px;margin:0 auto;padding:0 20px 18px;">
        <div style="font-size:.68rem;font-weight:800;color:rgba(255,255,255,.3);
                     text-transform:uppercase;letter-spacing:.6px;margin-bottom:12px;">
            Quick Links
        </div>
        <div style="display:flex;flex-wrap:wrap;gap:8px 16px;justify-content:center;">
            @foreach($footerLinks as $fl)
            <a href="{{ $fl->url }}" target="_blank"
               style="display:inline-flex;align-items:center;gap:5px;
                      font-size:.78rem;color:rgba(255,255,255,.55);text-decoration:none;
                      transition:color .18s;"
               onmouseover="this.style.color='var(--gold)'"
               onmouseout="this.style.color='rgba(255,255,255,.55)'">
                @if($fl->icon)<i class="{{ $fl->icon }}" style="font-size:.7rem;"></i>@endif
                {{ $fl->name }}
            </a>
            @endforeach
        </div>
        <div style="border-top:1px solid rgba(255,255,255,.08);margin-top:16px;"></div>
    </div>
    @endif
    <div style="padding:0 20px;">
        &copy; {{ date('Y') }} <strong>Project Jeremiah 33:3</strong> &mdash; Guidance Services Office, NU Laguna
    </div>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
    // Hamburger toggle
    const btn    = document.getElementById('hamburger');
    const drawer = document.getElementById('mobile-drawer');
    if (btn && drawer) {
        btn.addEventListener('click', function () {
            drawer.classList.toggle('open');
            const spans = btn.querySelectorAll('span');
            if (drawer.classList.contains('open')) {
                spans[0].style.transform = 'rotate(45deg) translate(5px,5px)';
                spans[1].style.opacity   = '0';
                spans[2].style.transform = 'rotate(-45deg) translate(5px,-5px)';
            } else {
                spans.forEach(s => { s.style.transform=''; s.style.opacity=''; });
            }
        });
        // Close on outside click
        document.addEventListener('click', function (e) {
            if (!btn.contains(e.target) && !drawer.contains(e.target)) {
                drawer.classList.remove('open');
                btn.querySelectorAll('span').forEach(s => { s.style.transform=''; s.style.opacity=''; });
            }
        });
    }
</script>
@yield('scripts')
</body>
</html>

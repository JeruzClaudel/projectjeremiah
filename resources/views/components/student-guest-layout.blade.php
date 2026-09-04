<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Student Portal') — Project Jeremiah</title>
    @vite('resources/css/styles.css')
    <style>
        /* Guest layout — register/reactivate pages */
        .guest-shell {
            min-height: 100vh;
            background: var(--sky);
            display: flex;
            flex-direction: column;
        }
        /* Minimal topbar */
        .guest-topbar {
            background: var(--navy);
            padding: 10px 0;
            text-align: center;
        }
        .guest-topbar a {
            font-family: "Space Grotesk", sans-serif;
            font-weight: 700; color: var(--gold);
            font-size: .95rem; text-decoration: none;
            display: inline-flex; align-items: center; gap: 8px;
        }
        .guest-topbar .tm { /* brand mark */
            width: 28px; height: 28px; border-radius: 9px 9px 9px 3px;
            background: var(--gold); color: var(--navy);
            display: inline-grid; place-items: center;
            font-family: serif; font-size: 1rem;
            box-shadow: 3px 3px 0 rgba(255,255,255,.3);
        }
        /* Content area */
        .guest-content {
            flex: 1;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 40px 20px;
        }
        .guest-card {
            background: var(--white);
            border: 1px solid var(--navy-2);
            border-radius: 26px;
            box-shadow: var(--shadow);
            padding: clamp(28px, 5vw, 44px);
            width: 100%;
            max-width: 500px;
        }
        .guest-card-header {
            text-align: center;
            margin-bottom: 28px;
        }
        .guest-icon {
            width: 60px; height: 60px;
            background: var(--gold);
            border-radius: 18px 18px 18px 5px;
            display: grid; place-items: center;
            margin: 0 auto 16px;
            color: var(--navy); font-size: 1.5rem;
            box-shadow: 5px 5px 0 var(--navy-2);
        }
        .guest-card-header h1 {
            font-size: 1.5rem; margin-bottom: 5px;
        }
        .guest-card-header p { color: var(--muted); font-size: .85rem; }

        /* Error banner */
        .guest-error {
            background: #fef2f2; border: 1px solid #fecaca;
            border-radius: 12px; padding: 12px 16px;
            margin-bottom: 18px; font-size: .82rem; color: #dc2626;
        }
        .guest-status {
            background: #f0fdf4; border: 1px solid #bbf7d0;
            border-radius: 12px; padding: 12px 16px;
            margin-bottom: 18px; font-size: .82rem; color: #166534;
        }

        /* Select with icon padding */
        .field select { padding: 11px 12px; }
    </style>
</head>
<body>
<div class="guest-shell">

    {{-- Minimal top nav --}}
    <div class="guest-topbar">
        <a href="{{ route('home') }}">
            <span class="tm">J</span>
            Project Jeremiah 33:3
        </a>
    </div>

    {{-- Card content --}}
    <div class="guest-content">
        <div class="guest-card">
            {{ $slot }}
        </div>
    </div>

</div>
</body>
</html>

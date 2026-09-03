<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Project Jeremiah 33:3') }} — Admin Login</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <style>
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

        body {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, sans-serif;
            min-height: 100vh;
            display: flex;
            background: #f4f6fb;
        }

        /* ── Left panel ── */
        .login-left {
            width: 45%;
            background: linear-gradient(160deg, #0a1931 0%, #1c2a4d 55%, #2a3f6b 100%);
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            padding: 48px 40px;
            position: relative;
            overflow: hidden;
        }
        .login-left::before {
            content: '';
            position: absolute; inset: 0;
            background: radial-gradient(ellipse at 30% 70%, rgba(240,196,25,.07) 0%, transparent 60%),
                        radial-gradient(ellipse at 80% 20%, rgba(240,196,25,.05) 0%, transparent 50%);
        }
        .login-left .inner { position: relative; z-index: 1; text-align: center; max-width: 360px; }

        /* Brand icon */
        .brand-circle {
            width: 80px; height: 80px;
            background: rgba(240,196,25,.14);
            border: 2px solid rgba(240,196,25,.35);
            border-radius: 50%;
            display: flex; align-items: center; justify-content: center;
            margin: 0 auto 22px;
            font-size: 2rem; color: #f0c419;
        }
        .brand-name {
            font-size: 1.5rem; font-weight: 800;
            color: #f0c419; letter-spacing: .3px; margin-bottom: 6px;
        }
        .brand-verse {
            font-size: .88rem; font-style: italic;
            color: rgba(255,255,255,.55); line-height: 1.7;
            margin-bottom: 32px;
        }

        /* Decorative features list */
        .feature-list { text-align: left; width: 100%; }
        .feature-item {
            display: flex; align-items: center; gap: 12px;
            padding: 10px 0;
            border-bottom: 1px solid rgba(255,255,255,.07);
            color: rgba(255,255,255,.7);
            font-size: .84rem;
        }
        .feature-item:last-child { border-bottom: none; }
        .feature-icon {
            width: 34px; height: 34px; flex-shrink: 0;
            background: rgba(240,196,25,.1);
            border-radius: 9px;
            display: flex; align-items: center; justify-content: center;
            color: #f0c419; font-size: .85rem;
        }
        .feature-text strong { color: #fff; display: block; font-size: .86rem; font-weight: 600; margin-bottom: 1px; }

        /* Footer credit */
        .left-footer {
            position: absolute; bottom: 22px; left: 0; right: 0;
            text-align: center;
            font-size: .7rem; color: rgba(255,255,255,.25);
        }

        /* ── Right panel ── */
        .login-right {
            flex: 1;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            padding: 48px 40px;
            background: #f4f6fb;
        }
        .login-card {
            width: 100%; max-width: 420px;
            background: #fff;
            border-radius: 20px;
            padding: 38px 36px 32px;
            box-shadow: 0 8px 32px rgba(0,0,0,.09);
            border: 1.5px solid #e5e7eb;
        }
        .lc-header { text-align: center; margin-bottom: 28px; }
        .lc-header h1 { font-size: 1.35rem; font-weight: 800; color: #0a1931; margin-bottom: 5px; }
        .lc-header p  { font-size: .82rem; color: #6b7280; }

        /* Form fields */
        .lf-group { margin-bottom: 18px; }
        .lf-group label {
            display: block; font-size: .75rem; font-weight: 700;
            color: #374151; margin-bottom: 6px; letter-spacing: .2px;
        }
        .lf-input-wrap {
            position: relative;
            display: flex; align-items: center;
            border: 1.5px solid #e5e7eb; border-radius: 10px;
            background: #fff; transition: border-color .2s;
        }
        .lf-input-wrap:focus-within { border-color: #0a1931; }
        .lf-input-wrap i {
            position: absolute; left: 13px;
            color: #9ca3af; font-size: .85rem; pointer-events: none;
        }
        .lf-input-wrap input {
            width: 100%; padding: 11px 12px 11px 38px;
            border: none; outline: none;
            font-size: .92rem; color: #111827;
            background: transparent; border-radius: 10px;
            font-family: inherit;
        }
        .lf-input-wrap .pw-toggle {
            position: absolute; right: 12px;
            background: none; border: none; cursor: pointer;
            color: #9ca3af; font-size: .85rem; padding: 4px;
            transition: color .15s;
        }
        .lf-input-wrap .pw-toggle:hover { color: #374151; }

        .lf-error {
            color: #dc2626; font-size: .75rem;
            margin-top: 5px; display: flex; align-items: center; gap: 4px;
        }

        /* Remember + forgot row */
        .lf-row {
            display: flex; align-items: center; justify-content: space-between;
            margin-bottom: 22px;
        }
        .lf-remember {
            display: flex; align-items: center; gap: 7px;
            font-size: .8rem; color: #6b7280; cursor: pointer;
        }
        .lf-remember input {
            width: 15px; height: 15px; accent-color: #0a1931; cursor: pointer;
        }
        .lf-forgot {
            font-size: .78rem; font-weight: 600; color: #0a1931;
            text-decoration: none; transition: color .15s;
        }
        .lf-forgot:hover { color: #c9a227; }

        /* Submit button */
        .btn-login {
            width: 100%; padding: 12px;
            background: linear-gradient(135deg, #0a1931, #1c2a4d);
            color: #f0c419; border: none; border-radius: 10px;
            font-size: .95rem; font-weight: 800; cursor: pointer;
            letter-spacing: .2px;
            transition: opacity .2s, transform .18s;
            font-family: inherit;
        }
        .btn-login:hover { opacity: .88; transform: translateY(-1px); }
        .btn-login:active { transform: translateY(0); }

        /* Status / session alert */
        .lf-status {
            padding: 10px 14px;
            background: #f0fdf4; border: 1px solid #bbf7d0;
            border-radius: 9px; font-size: .82rem; color: #166534;
            margin-bottom: 18px;
        }
        .lf-err-banner {
            padding: 10px 14px;
            background: #fef2f2; border: 1px solid #fecaca;
            border-radius: 9px; font-size: .82rem; color: #dc2626;
            margin-bottom: 18px;
            display: flex; align-items: flex-start; gap: 7px;
        }

        /* Back link */
        .lf-back {
            display: inline-flex; align-items: center; gap: 6px;
            margin-top: 20px; font-size: .78rem; color: #9ca3af;
            text-decoration: none; transition: color .15s;
        }
        .lf-back:hover { color: #0a1931; }

        /* Responsive */
        @media (max-width: 768px) {
            body { flex-direction: column; }
            .login-left {
                width: 100%; min-height: 200px;
                padding: 32px 24px;
            }
            .login-left .inner { max-width: 100%; }
            .feature-list { display: none; }
            .left-footer { display: none; }
            .brand-verse { margin-bottom: 0; }
            .login-right { padding: 28px 20px; }
            .login-card  { padding: 28px 22px 24px; }
        }
    </style>
</head>
<body>

    {{-- ── Left decorative panel ── --}}
    <div class="login-left">
        <div class="inner">
            <div class="brand-circle"><i class="fas fa-dove"></i></div>
            <div class="brand-name">Project Jeremiah 33:3</div>
            <p class="brand-verse">
                "Call unto me, and I will answer thee, and shew thee<br>
                great and mighty things, which thou knowest not."
            </p>

            <div class="feature-list">
                <div class="feature-item">
                    <div class="feature-icon"><i class="fas fa-shield-halved"></i></div>
                    <div class="feature-text">
                        <strong>Secure Admin Panel</strong>
                        Role-based access for guidance office staff only
                    </div>
                </div>
                <div class="feature-item">
                    <div class="feature-icon"><i class="fas fa-comment-dots"></i></div>
                    <div class="feature-text">
                        <strong>e-Hayag Monitoring</strong>
                        AI-assisted sentiment analysis and high-risk alerts
                    </div>
                </div>
                <div class="feature-item">
                    <div class="feature-icon"><i class="fas fa-users"></i></div>
                    <div class="feature-text">
                        <strong>Student Management</strong>
                        Manage student accounts and academic year access
                    </div>
                </div>
                <div class="feature-item">
                    <div class="feature-icon"><i class="fas fa-chart-bar"></i></div>
                    <div class="feature-text">
                        <strong>Analytics & Reports</strong>
                        Data-driven insights for guidance programs
                    </div>
                </div>
            </div>
        </div>
        <div class="left-footer">
            Guidance Services Office &mdash; National University Laguna
        </div>
    </div>

    {{-- ── Right form panel ── --}}
    <div class="login-right">
        <div class="login-card">
            <div class="lc-header">
                <h1>Admin Sign In</h1>
                <p>Enter your credentials to access the admin panel</p>
            </div>

            {{ $slot }}

            <div style="text-align:center;">
                <a href="{{ route('home') }}" class="lf-back">
                    <i class="fas fa-arrow-left"></i> Back to Public Site
                </a>
            </div>
        </div>
    </div>

</body>
</html>

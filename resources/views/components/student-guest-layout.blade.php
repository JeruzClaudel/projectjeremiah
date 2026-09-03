<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Student Portal') — Project Jeremiah 33:3</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <style>
        * { box-sizing: border-box; }
        body {
            min-height: 100vh;
            margin: 0;
            background: linear-gradient(135deg, #0a1931 0%, #1c2a4d 50%, #2a3f6b 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 24px 16px;
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif;
        }
        .student-auth-card {
            background: #fff;
            border-radius: 20px;
            padding: 36px 36px 28px;
            width: 100%;
            max-width: 480px;
            box-shadow: 0 24px 64px rgba(0,0,0,.25);
        }
        .student-auth-header {
            text-align: center;
            margin-bottom: 28px;
        }
        .student-auth-header .brand-icon {
            width: 60px; height: 60px;
            background: linear-gradient(135deg, #0a1931, #1c2a4d);
            border-radius: 16px;
            display: flex; align-items: center; justify-content: center;
            margin: 0 auto 14px;
            font-size: 1.4rem; color: #f0c419;
        }
        .student-auth-header h1 {
            font-size: 1.4rem; font-weight: 800;
            color: #0a1931; margin: 0 0 6px;
        }
        .student-auth-header p {
            font-size: .85rem; color: #6b7280; margin: 0;
        }
        .sf-group { margin-bottom: 18px; }
        .sf-group label {
            display: block; font-size: .8rem; font-weight: 700;
            color: #374151; margin-bottom: 6px;
        }
        .input-wrap {
            position: relative;
            display: flex; align-items: center;
            border: 1.5px solid #e5e7eb;
            border-radius: 10px;
            padding: 0 14px;
            transition: border-color .2s;
            background: #fff;
        }
        .input-wrap:focus-within { border-color: #0a1931; }
        .input-wrap i {
            color: #9ca3af; font-size: .85rem;
            margin-right: 10px; flex-shrink: 0;
        }
        .input-wrap input,
        .input-wrap select {
            border: none; outline: none;
            font-size: .92rem; color: #374151;
            padding: 12px 0;
            width: 100%; background: transparent;
        }
        .btn-student-submit {
            width: 100%;
            padding: 13px;
            background: linear-gradient(135deg, #0a1931, #1c2a4d);
            color: #f0c419;
            border: none; border-radius: 10px;
            font-size: .95rem; font-weight: 800;
            cursor: pointer;
            transition: opacity .2s, transform .2s;
            letter-spacing: .3px;
        }
        .btn-student-submit:hover:not(:disabled) {
            opacity: .88; transform: translateY(-1px);
        }
        .btn-student-submit:disabled {
            opacity: .5; cursor: not-allowed;
        }
        .error-banner {
            background: #fef2f2;
            border: 1.5px solid #fecaca;
            border-radius: 10px;
            padding: 12px 16px;
            margin-bottom: 18px;
            font-size: .82rem;
            color: #dc2626;
            line-height: 1.6;
        }
        .status-banner {
            background: #f0fdf4;
            border: 1.5px solid #bbf7d0;
            border-radius: 10px;
            padding: 12px 16px;
            margin-bottom: 18px;
            font-size: .82rem;
            color: #166534;
            line-height: 1.6;
        }
        .text-danger { color: #dc2626; font-size: .75rem; margin-top: 4px; display: block; }

        /* OTP input */
        .otp-input-row {
            display: flex; gap: 10px; justify-content: center; margin: 20px 0;
        }
        .otp-digit {
            width: 52px; height: 60px;
            border: 2px solid #e5e7eb;
            border-radius: 12px;
            text-align: center;
            font-size: 1.5rem; font-weight: 800;
            color: #0a1931;
            transition: border-color .2s;
            outline: none;
        }
        .otp-digit:focus { border-color: #0a1931; }

        .hidden { display: none !important; }
    </style>
</head>
<body>
    {{ $slot }}
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

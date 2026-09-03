<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Email Verification — Project Jeremiah 33:3</title>
    <style>
        body { margin:0; padding:0; background:#f3f4f6; font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif; }
        .wrapper { max-width:560px; margin:40px auto; background:#ffffff; border-radius:16px; overflow:hidden; box-shadow:0 4px 24px rgba(0,0,0,.08); }
        .header { background:linear-gradient(135deg,#0a1931,#1c2a4d); padding:36px 40px; text-align:center; }
        .header h1 { color:#f0c419; font-size:1.3rem; font-weight:800; margin:0 0 4px; letter-spacing:.3px; }
        .header p { color:rgba(255,255,255,.7); font-size:.85rem; margin:0; }
        .body { padding:36px 40px; }
        .greeting { font-size:1rem; color:#111827; margin-bottom:16px; }
        .otp-box { background:#f9fafb; border:2px dashed #d1d5db; border-radius:12px; padding:24px; text-align:center; margin:24px 0; }
        .otp-code { font-size:2.4rem; font-weight:900; letter-spacing:12px; color:#0a1931; font-family:monospace; }
        .otp-note { font-size:.78rem; color:#6b7280; margin-top:8px; }
        .info-box { background:#fef9e7; border:1px solid rgba(201,162,39,.3); border-radius:9px; padding:14px 18px; font-size:.82rem; color:#92400e; margin-bottom:20px; }
        .footer { background:#f9fafb; padding:20px 40px; text-align:center; font-size:.75rem; color:#9ca3af; border-top:1px solid #f3f4f6; }
    </style>
</head>
<body>
<div class="wrapper">
    <div class="header">
        <h1>Project Jeremiah 33:3</h1>
        <p>Guidance Services Office &mdash; NU Laguna</p>
    </div>
    <div class="body">
        <p class="greeting">Hello, <strong>{{ $studentName }}</strong>!</p>
        <p style="color:#374151; font-size:.9rem; line-height:1.7; margin-bottom:20px;">
            Thank you for registering. To complete your account creation, please enter the
            verification code below on the registration page.
        </p>

        <div class="otp-box">
            <div class="otp-code">{{ $otp }}</div>
            <div class="otp-note">This code expires in <strong>5 minutes</strong>.</div>
        </div>

        <div class="info-box">
            <strong>Important:</strong> This code can only be used once. If you did not request this,
            please ignore this email &mdash; no account will be created.
        </div>

        <p style="color:#6b7280; font-size:.82rem; line-height:1.65;">
            Maximum 3 attempts. If the code expires, you can request a new one from the verification page.
        </p>
    </div>
    <div class="footer">
        &copy; {{ date('Y') }} Project Jeremiah 33:3 &mdash; Guidance Services Office, NU Laguna<br>
        This is an automated message. Please do not reply.
    </div>
</div>
</body>
</html>

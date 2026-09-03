<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Under Maintenance — Project Jeremiah 33:3</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <style>
        * { box-sizing: border-box; margin: 0; padding: 0; }
        body {
            min-height: 100vh;
            background: linear-gradient(135deg, #0a1931 0%, #1c2a4d 50%, #2a3f6b 100%);
            display: flex; align-items: center; justify-content: center;
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif;
            padding: 24px;
        }
        .card {
            background: #fff; border-radius: 20px; padding: 52px 44px;
            max-width: 500px; width: 100%; text-align: center;
            box-shadow: 0 24px 64px rgba(0,0,0,.3);
        }
        .icon {
            width: 80px; height: 80px;
            background: linear-gradient(135deg, #0a1931, #1c2a4d);
            border-radius: 50%; display: flex; align-items: center;
            justify-content: center; margin: 0 auto 24px;
            font-size: 2rem; color: #f0c419;
        }
        h1 { font-size: 1.7rem; font-weight: 800; color: #0a1931; margin-bottom: 12px; }
        p  { color: #6b7280; line-height: 1.7; font-size: .95rem; }
        .badge {
            display: inline-flex; align-items: center; gap: 7px;
            margin-top: 28px; padding: 9px 20px;
            background: #fef9e7; border: 1.5px solid rgba(201,162,39,.35);
            border-radius: 999px; font-size: .8rem; font-weight: 700; color: #92400e;
        }
        .footer { margin-top: 32px; font-size: .75rem; color: #9ca3af; }
    </style>
</head>
<body>
    <div class="card">
        <div class="icon"><i class="fas fa-screwdriver-wrench"></i></div>
        <h1>Under Maintenance</h1>
        <p>
            Project Jeremiah 33:3 is currently undergoing scheduled maintenance.<br>
            We'll be back shortly. Thank you for your patience.
        </p>
        <div class="badge">
            <i class="fas fa-clock"></i> Back soon — please check again later
        </div>
        <div class="footer">
            &copy; {{ date('Y') }} Guidance Services Office, NU Laguna
        </div>
    </div>
</body>
</html>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>High-Risk Alert — Project Jeremiah 33:3</title>
    <style>
        body { margin:0;padding:0;background:#f3f4f6;font-family:-apple-system,BlinkMacSystemFont,'Segoe UI',sans-serif; }
        .wrapper { max-width:580px;margin:36px auto;background:#fff;border-radius:16px;overflow:hidden;box-shadow:0 4px 24px rgba(0,0,0,.1); }
        .header  { background:linear-gradient(135deg,#7f1d1d,#b91c1c);padding:28px 36px;text-align:center; }
        .header h1  { color:#fca5a5;font-size:1.1rem;font-weight:800;margin:0 0 4px; }
        .header p   { color:rgba(255,255,255,.7);font-size:.82rem;margin:0; }
        .alert-icon { font-size:2.2rem;margin-bottom:10px;display:block; }
        .body    { padding:28px 36px; }
        .info-row { display:flex;gap:12px;margin-bottom:14px;align-items:flex-start; }
        .info-icon{ width:36px;height:36px;border-radius:9px;display:flex;align-items:center;
                    justify-content:center;font-size:.9rem;flex-shrink:0; }
        .info-label { font-size:.65rem;font-weight:700;color:#9ca3af;text-transform:uppercase;letter-spacing:.4px; }
        .info-value { font-size:.9rem;font-weight:600;color:#111827;margin-top:2px; }
        .post-box { background:#fef2f2;border:1px solid #fecaca;border-left:4px solid #ef4444;
                    border-radius:0 10px 10px 0;padding:16px 18px;margin:18px 0;
                    font-size:.9rem;color:#374151;line-height:1.75;white-space:pre-wrap; }
        .ai-box   { background:#0a1931;border-radius:10px;padding:14px 18px;margin-bottom:18px; }
        .ai-box .label { font-size:.62rem;font-weight:800;color:#f0c419;text-transform:uppercase;letter-spacing:.5px;margin-bottom:6px; }
        .ai-box p { color:rgba(255,255,255,.85);font-size:.88rem;font-style:italic;line-height:1.65;margin:0; }
        .btn-row  { text-align:center;margin:20px 0; }
        .btn      { display:inline-block;padding:11px 26px;background:#7f1d1d;color:#fff;
                    border-radius:9px;font-size:.88rem;font-weight:700;text-decoration:none; }
        .footer   { background:#f9fafb;padding:18px 36px;text-align:center;font-size:.72rem;color:#9ca3af;border-top:1px solid #f3f4f6; }
        .badge    { display:inline-flex;align-items:center;gap:4px;padding:3px 10px;border-radius:999px;
                    font-size:.68rem;font-weight:800; }
        .badge-risk { background:#7f1d1d;color:#fca5a5; }
        .badge-ai   { background:#0a1931;color:#f0c419; }
    </style>
</head>
<body>
<div class="wrapper">
    <div class="header">
        <span class="alert-icon">🚨</span>
        <h1>High-Risk Post Detected</h1>
        <p>Project Jeremiah 33:3 — Guidance Services Office, NU Laguna</p>
    </div>

    <div class="body">
        <p style="font-size:.9rem;color:#374151;line-height:1.7;margin-bottom:20px;">
            Hello,<br><br>
            A student post has been flagged as <strong>high-risk</strong> and requires your immediate attention.
            This alert was sent by <strong>{{ $adminName }}</strong>.
        </p>

        {{-- Post meta --}}
        <div class="info-row">
            <div class="info-icon" style="background:#fef2f2;color:#dc2626;">
                <span>👤</span>
            </div>
            <div>
                <div class="info-label">Student</div>
                <div class="info-value">{{ $post->postName }}</div>
            </div>
        </div>

        <div class="info-row">
            <div class="info-icon" style="background:#eef4ff;color:#1d4ed8;">
                <span>🎓</span>
            </div>
            <div>
                <div class="info-label">Program / Year</div>
                <div class="info-value">{{ $post->program ?? '—' }} · {{ $post->year_level ?? '—' }}</div>
            </div>
        </div>

        <div class="info-row">
            <div class="info-icon" style="background:#fef9e7;color:#c9a227;">
                <span>🕐</span>
            </div>
            <div>
                <div class="info-label">Submitted</div>
                <div class="info-value">{{ $post->created_at->format('F d, Y \a\t h:i A') }}</div>
            </div>
        </div>

        {{-- Sentiment badges --}}
        <div style="margin-bottom:16px;display:flex;gap:6px;flex-wrap:wrap;">
            <span class="badge badge-risk">🔤 KEYWORD: {{ strtoupper(str_replace('_',' ',$post->sentiment ?? 'high_risk')) }}</span>
            @if($post->ai_sentiment)
            <span class="badge badge-ai">🤖 AI: {{ strtoupper(str_replace('_',' ',$post->ai_sentiment)) }}</span>
            @endif
            @if($post->ai_flagged)
            <span class="badge badge-risk">⚠ AI FLAGGED</span>
            @endif
        </div>

        {{-- Post content --}}
        <div style="font-size:.68rem;font-weight:800;color:#9ca3af;text-transform:uppercase;letter-spacing:.4px;margin-bottom:6px;">Post Content</div>
        <div class="post-box">{{ $post->post }}</div>

        {{-- AI counselor note --}}
        @if($post->ai_counselor_note)
        <div class="ai-box">
            <div class="label">🧠 AI Counselor Note</div>
            <p>{{ $post->ai_counselor_note }}</p>
        </div>
        @endif

        <div class="btn-row">
            <a href="{{ url('/admin/freedomwall/'.$post->id.'/details') }}" class="btn">
                View Full Post in Admin Panel
            </a>
        </div>

        <p style="font-size:.8rem;color:#6b7280;line-height:1.65;border-top:1px solid #f3f4f6;padding-top:14px;margin-top:0;">
            <strong>Please respond promptly.</strong>
            If this student is in immediate danger, follow your institution's crisis intervention protocol and contact emergency services if necessary.
        </p>
    </div>

    <div class="footer">
        &copy; {{ date('Y') }} Project Jeremiah 33:3 — Guidance Services Office, NU Laguna<br>
        This is an automated alert. Do not reply to this email.
    </div>
</div>
</body>
</html>

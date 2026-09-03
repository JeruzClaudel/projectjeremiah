@extends('layouts.user')
@section('title', 'e-Hayag — Share Your Thoughts')

@section('content')

<div class="pub-hero fade-up">
    <div class="hero-inner">
        <div style="display:inline-flex;align-items:center;gap:8px;
                    padding:5px 16px;border:1px solid rgba(240,196,25,.35);
                    border-radius:999px;background:rgba(240,196,25,.1);
                    color:var(--gold);font-size:.78rem;font-weight:700;
                    text-transform:uppercase;letter-spacing:.5px;margin-bottom:18px;">
            <i class="fas fa-lock"></i> Private &amp; Confidential
        </div>
        <h1>e-Hayag</h1>
        <p>
            Welcome to your safe space. Share your thoughts, feelings, and experiences
            without fear of judgment. Everything you write is seen only by your guidance counselors
            who are here to support you.
        </p>
        <div style="margin-top:24px;">
            <a href="{{ route('user.freedomwall.create') }}"
               style="display:inline-flex;align-items:center;gap:8px;
                      padding:13px 32px;background:var(--gold);color:var(--navy);
                      border-radius:999px;font-size:.95rem;font-weight:800;
                      text-decoration:none;transition:opacity .2s,transform .2s;"
               onmouseover="this.style.transform='translateY(-2px)';this.style.opacity='.9'"
               onmouseout="this.style.transform='';this.style.opacity='1'">
                <i class="fas fa-pen"></i> Start Writing
            </a>
        </div>
    </div>
</div>

{{-- How to use --}}
<div class="row g-3 mb-4">
    @foreach([
        ['fas fa-heart',         '#dc2626', '#fff0f0', 'Be Honest',    'Share what you truly feel. No filters, no judgment — this is your honest space.'],
        ['fas fa-shield-halved', '#0a1931', '#f0f9ff', 'Stay Safe',    'Your post is read only by guidance counselors. Your privacy is always protected.'],
        ['fas fa-comment-dots',  '#16a34a', '#f0fdf4', 'You Are Heard','Every submission is read with care. You are never alone on this journey.'],
    ] as [$icon, $color, $bg, $title, $desc])
    <div class="col-md-4 fade-up" style="animation-delay:{{ $loop->index * .1 }}s">
        <div style="background:#fff;border-radius:14px;border:1.5px solid var(--border);
                    padding:22px 20px;height:100%;box-shadow:var(--shadow);">
            <div style="width:46px;height:46px;border-radius:12px;background:{{ $bg }};
                        display:flex;align-items:center;justify-content:center;
                        color:{{ $color }};font-size:1.1rem;margin-bottom:12px;">
                <i class="{{ $icon }}"></i>
            </div>
            <div style="font-weight:700;font-size:.95rem;color:var(--navy);margin-bottom:6px;">{{ $title }}</div>
            <div style="font-size:.84rem;color:var(--muted);line-height:1.6;">{{ $desc }}</div>
        </div>
    </div>
    @endforeach
</div>

<div class="info-box fade-up" style="text-align:center;">
    <i class="fas fa-quote-left me-2"></i>
    Take a moment. Breathe. Write.<br>
    Here, you are heard. You are valued. You are not alone.
</div>

@endsection

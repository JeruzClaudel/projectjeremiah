@extends('layouts.user')
@section('title', 'Home — Project Jeremiah 33:3')

@section('content')

{{-- Hero --}}
<div class="pub-hero fade-up">
    <div class="hero-inner">
        <div style="display:inline-flex;align-items:center;gap:8px;
                    padding:5px 16px;border:1px solid rgba(240,196,25,.35);
                    border-radius:999px;background:rgba(240,196,25,.1);
                    color:var(--gold);font-size:.78rem;font-weight:700;
                    text-transform:uppercase;letter-spacing:.5px;margin-bottom:20px;">
            <i class="fas fa-dove"></i> Guidance Services Office &mdash; NU Laguna
        </div>
        <h1>Project Jeremiah 33:3</h1>
        <p>
            "Call unto me, and I will answer thee, and shew thee great and mighty things, which thou knowest not."<br>
            <em style="font-size:.9rem;opacity:.7;">— Jeremiah 33:3</em>
        </p>
        <p style="margin-top:14px;">
            Your trusted partner in academic success, personal growth, and mental wellness.
            We are here to support every step of your journey with compassion and expertise.
        </p>
        <div style="display:flex;gap:12px;justify-content:center;flex-wrap:wrap;margin-top:28px;">
            <a href="{{ route('user.freedomwall.add') }}" class="opt-btn" style="padding:12px 28px;font-size:.92rem;">
                <i class="fas fa-comment-dots"></i> Share on e-Hayag
            </a>
            <a href="{{ route('user.services') }}"
               style="display:inline-flex;align-items:center;gap:7px;padding:12px 28px;
                      background:rgba(255,255,255,.1);color:#fff;border:1.5px solid rgba(255,255,255,.25);
                      border-radius:999px;font-size:.92rem;font-weight:700;text-decoration:none;
                      transition:background .2s;"
               onmouseover="this.style.background='rgba(255,255,255,.18)'"
               onmouseout="this.style.background='rgba(255,255,255,.1)'">
                <i class="fas fa-concierge-bell"></i> Our Services
            </a>
        </div>
    </div>
</div>

{{-- 3 Feature Cards --}}
<div class="row g-3 mb-4">
    <div class="col-lg-4 col-md-6 fade-up fade-up-d1">
        <div class="opt-card">
            <div class="opt-icon" style="background:linear-gradient(135deg,#eff6ff,#dbeafe);color:#1d4ed8;">
                <i class="fas fa-concierge-bell"></i>
            </div>
            <h3>Guidance Services</h3>
            <p>Counseling, academic support, peer mediation, and personal development programs designed to help you thrive.</p>
            <a href="{{ route('user.services') }}" class="opt-btn">
                <i class="fas fa-arrow-right"></i> Explore Services
            </a>
        </div>
    </div>
    <div class="col-lg-4 col-md-6 fade-up fade-up-d2">
        <div class="opt-card">
            <div class="opt-icon" style="background:linear-gradient(135deg,#f0fdf4,#dcfce7);color:#16a34a;">
                <i class="fas fa-comment-dots"></i>
            </div>
            <h3>e-Hayag Platform</h3>
            <p>Your safe, confidential digital space to express thoughts and feelings. Seen only by your guidance counselors.</p>
            <a href="{{ route('user.freedomwall.add') }}" class="opt-btn">
                <i class="fas fa-arrow-right"></i> Share Anonymously
            </a>
        </div>
    </div>
    <div class="col-lg-4 col-md-6 fade-up fade-up-d3">
        <div class="opt-card">
            <div class="opt-icon" style="background:linear-gradient(135deg,#fff0f0,#fee2e2);color:#dc2626;">
                <i class="fas fa-phone-alt"></i>
            </div>
            <h3>Emergency Hotlines</h3>
            <p>24/7 crisis support and mental health resources. Professional help is always available when you need it most.</p>
            <a href="{{ route('user.hotline') }}" class="opt-btn danger">
                <i class="fas fa-arrow-right"></i> Get Help Now
            </a>
        </div>
    </div>
</div>

{{-- Register / Reactivate strip --}}
<div style="background:#fff;border:1.5px solid var(--border);border-radius:14px;
            padding:22px 28px;display:flex;align-items:center;justify-content:space-between;
            flex-wrap:wrap;gap:16px;box-shadow:var(--shadow);" class="fade-up fade-up-d4">
    <div>
        <div style="font-size:.95rem;font-weight:700;color:var(--navy);margin-bottom:4px;">
            <i class="fas fa-shield-halved" style="color:var(--gold);margin-right:7px;"></i>
            Need an account to post on e-Hayag?
        </div>
        <div style="font-size:.82rem;color:var(--muted);">
            Register with your school email — your program and year level are saved so you won't need to re-enter them.
        </div>
    </div>
    <div style="display:flex;gap:10px;flex-wrap:wrap;">
        <a href="{{ route('student.register') }}"
           style="display:inline-flex;align-items:center;gap:7px;padding:9px 20px;
                  background:linear-gradient(135deg,var(--navy),var(--navy2));
                  color:var(--gold);border-radius:9px;font-size:.85rem;font-weight:700;
                  text-decoration:none;">
            <i class="fas fa-user-plus"></i> Register
        </a>
        <a href="{{ route('student.reactivate.request') }}"
           style="display:inline-flex;align-items:center;gap:7px;padding:9px 20px;
                  background:#f3f4f6;color:var(--navy);border:1px solid var(--border);
                  border-radius:9px;font-size:.85rem;font-weight:700;text-decoration:none;">
            <i class="fas fa-rotate-right"></i> Reactivate
        </a>
    </div>
</div>

@if(isset($quote) && $quote)
<div style="text-align:center;margin-top:32px;padding:22px;
            color:var(--muted);font-style:italic;font-size:.9rem;line-height:1.7;">
    "{{ $quote->quote }}"
    @if($quote->author)
        <div style="margin-top:6px;font-style:normal;font-weight:700;font-size:.8rem;color:var(--navy);">
            — {{ $quote->author }}
        </div>
    @endif
</div>
@endif

@endsection

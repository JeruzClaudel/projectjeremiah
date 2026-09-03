@extends('layouts.user')
@section('title', $hotline->name . ' — Hotline Details')

@section('content')

<a href="{{ route('user.hotline') }}" class="back-link fade-up">
    <i class="fas fa-arrow-left"></i> Back to Hotlines
</a>

<div style="background:#fff;border-radius:18px;border:1.5px solid var(--border);
            padding:32px;box-shadow:var(--shadow);max-width:640px;" class="fade-up fade-up-d1">

    <div style="display:flex;align-items:center;gap:16px;margin-bottom:22px;flex-wrap:wrap;">
        <div style="width:56px;height:56px;border-radius:50%;
                    background:linear-gradient(135deg,#991b1b,#dc2626);
                    display:flex;align-items:center;justify-content:center;
                    color:#fff;font-size:1.3rem;flex-shrink:0;">
            <i class="fas fa-phone-alt"></i>
        </div>
        <h1 style="font-size:1.4rem;font-weight:800;color:var(--navy);margin:0;">
            {{ $hotline->name }}
        </h1>
    </div>

    <div class="sec-line"></div>

    @if($hotline->description)
    <p style="font-size:.92rem;color:var(--text);line-height:1.75;margin-bottom:20px;">
        {{ $hotline->description }}
    </p>
    @endif

    <div style="display:flex;flex-direction:column;gap:12px;">
        @if($hotline->phone_number)
        <div style="display:flex;align-items:center;gap:12px;padding:14px 16px;
                    background:#fff0f0;border:1px solid #fecaca;border-radius:10px;">
            <i class="fas fa-phone" style="color:#dc2626;width:20px;text-align:center;"></i>
            <div>
                <div style="font-size:.7rem;font-weight:700;color:#9ca3af;text-transform:uppercase;letter-spacing:.4px;">Phone</div>
                <div style="font-size:1.1rem;font-weight:800;color:#dc2626;">{{ $hotline->phone_number }}</div>
            </div>
        </div>
        @endif

        @if($hotline->email)
        <div style="display:flex;align-items:center;gap:12px;padding:14px 16px;
                    background:#eef4ff;border:1px solid #bfdbfe;border-radius:10px;">
            <i class="fas fa-envelope" style="color:#1d4ed8;width:20px;text-align:center;"></i>
            <div>
                <div style="font-size:.7rem;font-weight:700;color:#9ca3af;text-transform:uppercase;letter-spacing:.4px;">Email</div>
                <div style="font-size:.95rem;font-weight:700;color:#1d4ed8;">{{ $hotline->email }}</div>
            </div>
        </div>
        @endif

        @if($hotline->availability)
        <div style="display:flex;align-items:center;gap:12px;padding:14px 16px;
                    background:#f0fdf4;border:1px solid #bbf7d0;border-radius:10px;">
            <i class="fas fa-clock" style="color:#16a34a;width:20px;text-align:center;"></i>
            <div>
                <div style="font-size:.7rem;font-weight:700;color:#9ca3af;text-transform:uppercase;letter-spacing:.4px;">Availability</div>
                <div style="font-size:.95rem;font-weight:700;color:#166534;">{{ $hotline->availability }}</div>
            </div>
        </div>
        @endif
    </div>

    @if($hotline->site_link)
    <div style="margin-top:22px;">
        <a href="{{ $hotline->site_link }}" target="_blank" class="opt-btn" style="font-size:.88rem;">
            <i class="fas fa-arrow-up-right-from-square"></i> Visit Website
        </a>
    </div>
    @endif
</div>

@endsection

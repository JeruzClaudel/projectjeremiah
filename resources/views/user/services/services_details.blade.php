@extends('layouts.user')
@section('title', $service->name . ' — Services')

@section('content')

<a href="{{ route('user.services') }}" class="back-link fade-up">
    <i class="fas fa-arrow-left"></i> Back to Services
</a>

<div style="background:#fff;border-radius:18px;border:1.5px solid var(--border);
            padding:36px 32px;box-shadow:var(--shadow);" class="fade-up fade-up-d1">

    <div style="display:flex;align-items:center;gap:16px;margin-bottom:22px;">
        <div style="width:54px;height:54px;border-radius:14px;
                    background:linear-gradient(135deg,var(--navy),var(--navy2));
                    display:flex;align-items:center;justify-content:center;
                    color:var(--gold);font-size:1.3rem;flex-shrink:0;">
            <i class="fas fa-hands-holding-heart"></i>
        </div>
        <h1 style="font-size:1.5rem;font-weight:800;color:var(--navy);margin:0;">{{ $service->name }}</h1>
    </div>

    <div class="sec-line"></div>

    @if($service->description)
    <p style="font-size:.95rem;color:var(--text);line-height:1.85;margin-bottom:24px;white-space:pre-wrap;">{{ $service->description }}</p>
    @endif

    @if($service->consultations_id)
    <div style="background:#fef9e7;border:1px solid rgba(201,162,39,.3);border-left:4px solid var(--gold);
                border-radius:10px;padding:18px 20px;margin-top:12px;">
        <div style="font-weight:700;color:var(--navy);margin-bottom:8px;">
            <i class="fas fa-calendar-check" style="color:var(--gold);margin-right:7px;"></i>
            Schedule a Consultation
        </div>
        <p style="font-size:.85rem;color:var(--muted);margin-bottom:14px;">
            Interested in this service? Request a consultation using the link below.
        </p>
        <a href="{{ $service->consultations_id }}" target="_blank" class="opt-btn" style="font-size:.85rem;">
            <i class="fas fa-external-link-alt"></i> Request Here
        </a>
    </div>
    @endif
</div>

@endsection

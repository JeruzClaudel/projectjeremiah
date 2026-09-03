@extends('layouts.user')
@section('title', 'Services — Project Jeremiah')

@section('content')

<div class="pub-hero fade-up">
    <div class="hero-inner">
        <h1>Guidance Services</h1>
        <p>Empowering students through professional counseling, academic support, and personal development programs.</p>
    </div>
</div>

{{-- Services --}}
<div class="sec-title fade-up">Services Offered</div>
<div class="sec-line"></div>
<div class="row g-3 mb-5">
    @forelse($services as $service)
    <div class="col-lg-4 col-md-6 fade-up" style="animation-delay:{{ $loop->index * .07 }}s">
        <a href="{{ route('user.services.details', $service->id) }}" class="svc-card">
            <div class="svc-icon"><i class="fas fa-hands-holding-heart"></i></div>
            <h4>{{ $service->name }}</h4>
            <p>{{ Str::limit(strip_tags($service->description ?? ''), 120, '…') }}</p>
        </a>
    </div>
    @empty
    <div class="col-12">
        <div style="text-align:center;padding:52px;background:#fff;border-radius:14px;
                    border:1.5px solid var(--border);color:var(--muted);">
            No services have been added yet.
        </div>
    </div>
    @endforelse
</div>

{{-- Counselors --}}
@if(isset($counselors) && $counselors->count())
<div class="sec-title fade-up">Meet Our Counselors</div>
<div class="sec-line"></div>
<div class="row g-3 mb-5">
    @foreach($counselors as $counselor)
    <div class="col-lg-4 col-md-6 fade-up" style="animation-delay:{{ $loop->index * .08 }}s">
        <a href="{{ route('user.counselors.details', $counselor->id) }}"
           style="text-decoration:none;display:block;height:100%;">
            <div class="cns-card">
                @if($counselor->image)
                    <img src="{{ asset('storage/' . $counselor->image) }}"
                         alt="{{ $counselor->name }}" class="cns-avatar">
                @else
                    <div class="cns-avatar" style="background:linear-gradient(135deg,var(--navy),var(--navy2));
                                                    display:flex;align-items:center;justify-content:center;
                                                    color:var(--gold);font-size:2.2rem;">
                        {{ strtoupper(substr($counselor->name, 0, 1)) }}
                    </div>
                @endif
                <h5>{{ $counselor->name }}</h5>
                <div class="cns-pos">{{ $counselor->position }}</div>
                <div class="cns-dept">{{ $counselor->college }}</div>
                <span style="display:inline-flex;align-items:center;gap:5px;
                             padding:4px 12px;background:#fef9e7;color:#92400e;
                             border:1px solid rgba(201,162,39,.3);border-radius:999px;
                             font-size:.72rem;font-weight:700;">
                    <i class="fas fa-graduation-cap"></i> Guidance Counselor
                </span>
            </div>
        </a>
    </div>
    @endforeach
</div>
@endif

{{-- Consultations --}}
@if(isset($consultations) && $consultations->count())
<div class="sec-title fade-up">Consultation Links</div>
<div class="sec-line"></div>
<div class="row g-3 mb-3">
    @foreach($consultations as $consultation)
    <div class="col-md-6 fade-up" style="animation-delay:{{ $loop->index * .08 }}s">
        <div style="background:#fff;border-radius:14px;border:1.5px solid var(--border);
                    padding:28px 24px;text-align:center;box-shadow:var(--shadow);height:100%;">
            <div style="width:52px;height:52px;border-radius:50%;
                        background:linear-gradient(135deg,var(--navy),var(--navy2));
                        display:flex;align-items:center;justify-content:center;
                        margin:0 auto 16px;color:var(--gold);font-size:1.2rem;">
                <i class="fas fa-calendar-check"></i>
            </div>
            <h5 style="font-weight:700;color:var(--navy);margin-bottom:8px;">{{ $consultation->name }}</h5>
            @if($consultation->description)
                <p style="font-size:.85rem;color:var(--muted);margin-bottom:18px;">{{ $consultation->description }}</p>
            @endif
            <a href="{{ $consultation->request_link }}" target="_blank" class="opt-btn" style="font-size:.85rem;">
                <i class="fas fa-external-link-alt"></i> Request Consultation
            </a>
        </div>
    </div>
    @endforeach
</div>
@endif

@endsection

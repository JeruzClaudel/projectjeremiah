@extends('layouts.user')
@section('title', $service->name . ' — Services')

@section('content')

<div class="page-hero">
    <div class="shell">
        <div class="breadcrumbs">Project Jeremiah / Services / {{ $service->name }}</div>
        <h1>{{ $service->name }}</h1>
    </div>
</div>

<div class="section">
    <div class="shell">
        <a href="{{ route('user.services') }}" class="back-link">← Back to Services</a>
        <div class="service-detail-card">
            <h1>{{ $service->name }}</h1>
            @if($service->description)
            <div class="desc">{{ $service->description }}</div>
            @endif

            @if($service->consultations_id)
            <div class="consult-link-box">
                <strong>Ready to request this service?</strong>
                <p style="font-size:.84rem;color:var(--muted);margin-bottom:14px;">
                    Use the link below to request a consultation or submit an inquiry.
                </p>
                <a class="btn btn-primary" href="{{ $service->consultations_id }}" target="_blank">
                    Request Consultation ↗
                </a>
            </div>
            @endif
        </div>
    </div>
</div>

@endsection

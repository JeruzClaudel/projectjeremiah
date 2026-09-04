@extends('layouts.user')
@section('title', $hotline->name . ' — Hotline Details')

@section('content')
<div class="page-hero hotline-hero">
    <div class="shell">
        <div class="breadcrumbs">Project Jeremiah / Hotlines / {{ $hotline->name }}</div>
        <h1>{{ $hotline->name }}</h1>
    </div>
</div>

<div class="section">
    <div class="shell">
        <a href="{{ route('user.hotline') }}" class="back-link">← Back to Hotlines</a>
        <div class="hotline-detail-card">
            @if($hotline->phone_number)
            <div class="hotline-detail-row">
                <div class="hotline-detail-icon">📞</div>
                <div>
                    <div class="hotline-detail-label">Phone</div>
                    <div class="hotline-detail-value" style="font-family:'Space Grotesk',sans-serif;font-size:1.4rem;">{{ $hotline->phone_number }}</div>
                </div>
                <a class="btn btn-primary btn-sm" href="tel:{{ preg_replace('/[^0-9+]/','',$hotline->phone_number) }}" style="margin-left:auto;">Call Now</a>
            </div>
            @endif
            @if($hotline->email)
            <div class="hotline-detail-row">
                <div class="hotline-detail-icon">✉</div>
                <div>
                    <div class="hotline-detail-label">Email</div>
                    <div class="hotline-detail-value">{{ $hotline->email }}</div>
                </div>
            </div>
            @endif
            @if($hotline->availability)
            <div class="hotline-detail-row">
                <div class="hotline-detail-icon">◷</div>
                <div>
                    <div class="hotline-detail-label">Availability</div>
                    <div class="hotline-detail-value">{{ $hotline->availability }}</div>
                </div>
            </div>
            @endif
            @if($hotline->site_link)
            <div style="margin-top:20px;">
                <a class="btn btn-secondary" href="{{ $hotline->site_link }}" target="_blank">Visit Website ↗</a>
            </div>
            @endif
        </div>
    </div>
</div>

@endsection

@extends('layouts.user')
@section('title', $counselor->name . ' — Counselor')

@section('content')

<a href="{{ route('user.services') }}" class="back-link fade-up">
    <i class="fas fa-arrow-left"></i> Back to Services
</a>

<div style="background:#fff;border-radius:18px;border:1.5px solid var(--border);
            padding:32px;box-shadow:var(--shadow);" class="fade-up fade-up-d1">

    {{-- Profile header --}}
    <div style="display:flex;align-items:flex-start;gap:24px;flex-wrap:wrap;margin-bottom:28px;">
        <div style="flex-shrink:0;">
            @if($counselor->image)
                <img src="{{ asset('storage/' . $counselor->image) }}"
                     alt="{{ $counselor->name }}"
                     style="width:110px;height:110px;border-radius:50%;object-fit:cover;
                            border:3px solid var(--gold);">
            @else
                <div style="width:110px;height:110px;border-radius:50%;
                            background:linear-gradient(135deg,var(--navy),var(--navy2));
                            display:flex;align-items:center;justify-content:center;
                            color:var(--gold);font-size:2.5rem;font-weight:800;
                            border:3px solid var(--gold);">
                    {{ strtoupper(substr($counselor->name, 0, 1)) }}
                </div>
            @endif
        </div>
        <div style="flex:1;min-width:200px;">
            <h1 style="font-size:1.5rem;font-weight:800;color:var(--navy);margin-bottom:6px;">
                {{ $counselor->name }}
            </h1>
            @if($counselor->position)
            <div style="font-size:.88rem;color:var(--muted);margin-bottom:4px;">
                <i class="fas fa-briefcase me-1" style="color:var(--gold);"></i> {{ $counselor->position }}
            </div>
            @endif
            @if($counselor->college)
            <div style="font-size:.88rem;color:var(--muted);margin-bottom:4px;">
                <i class="fas fa-building-columns me-1" style="color:var(--gold);"></i> {{ $counselor->college }}
            </div>
            @endif
            @if($counselor->email)
            <div style="font-size:.88rem;color:var(--muted);margin-bottom:4px;">
                <i class="fas fa-envelope me-1" style="color:var(--gold);"></i>
                <a href="mailto:{{ $counselor->email }}" style="color:var(--navy);font-weight:600;">{{ $counselor->email }}</a>
            </div>
            @endif
            @if($counselor->ms_teams_account)
            <div style="font-size:.88rem;color:var(--muted);">
                <i class="fas fa-video me-1" style="color:var(--gold);"></i> {{ $counselor->ms_teams_account }}
            </div>
            @endif
        </div>
    </div>

    {{-- Weekly availability --}}
    <div class="sec-title">Weekly Availability</div>
    <div class="sec-line"></div>

    @php
        $days = ['Monday','Tuesday','Wednesday','Thursday','Friday','Saturday'];
    @endphp

    <div class="row g-2">
        @foreach($days as $day)
        @php $daySchedules = $counselor->schedules->where('day_of_week', $day); @endphp
        <div class="col-lg-4 col-md-6">
            <div style="background:{{ $daySchedules->isNotEmpty() ? '#f0fdf4' : '#f9fafb' }};
                        border:1.5px solid {{ $daySchedules->isNotEmpty() ? '#bbf7d0' : '#e5e7eb' }};
                        border-radius:10px;padding:14px 16px;">
                <div style="font-size:.78rem;font-weight:800;color:{{ $daySchedules->isNotEmpty() ? '#166534' : '#9ca3af' }};
                             text-transform:uppercase;letter-spacing:.5px;margin-bottom:6px;">
                    {{ $day }}
                </div>
                @if($daySchedules->isNotEmpty())
                    @foreach($daySchedules as $schedule)
                    <div style="font-size:.88rem;font-weight:600;color:#111827;
                                display:flex;align-items:center;gap:6px;">
                        <i class="fas fa-clock" style="color:#16a34a;font-size:.7rem;"></i>
                        {{ \Carbon\Carbon::parse($schedule->start_time)->format('h:i A') }}
                        &mdash;
                        {{ \Carbon\Carbon::parse($schedule->end_time)->format('h:i A') }}
                    </div>
                    @endforeach
                @else
                    <div style="font-size:.84rem;color:#9ca3af;">Not Available</div>
                @endif
            </div>
        </div>
        @endforeach
    </div>
</div>

@endsection

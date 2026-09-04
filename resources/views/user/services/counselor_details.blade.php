@extends('layouts.user')
@section('title', $counselor->name . ' — Counselor')

@section('content')

<div class="page-hero">
    <div class="shell">
        <div class="breadcrumbs">Project Jeremiah / Services / {{ $counselor->name }}</div>
        <h1>{{ $counselor->name }}</h1>
    </div>
</div>

<div class="section">
    <div class="shell">
        <a href="{{ route('user.services') }}" class="back-link">← Back to Services</a>

        <div class="counselor-detail-wrap">
            {{-- Photo / initials --}}
            @if($counselor->image)
                <img src="{{ asset('storage/'.$counselor->image) }}"
                     alt="{{ $counselor->name }}"
                     class="counselor-detail-photo">
            @else
                <div class="counselor-detail-initials">
                    {{ strtoupper(substr($counselor->name, 0, 2)) }}
                </div>
            @endif

            {{-- Info --}}
            <div class="counselor-detail-info">
                <h1>{{ $counselor->name }}</h1>
                @if($counselor->position)
                    <div class="counselor-role">{{ $counselor->position }}</div>
                @endif

                @if($counselor->college)
                <div class="counselor-contact-row">
                    <i>🏛</i>
                    <span>{{ $counselor->college }}</span>
                </div>
                @endif
                @if($counselor->email)
                <div class="counselor-contact-row">
                    <i>✉</i>
                    <a href="mailto:{{ $counselor->email }}" style="color:var(--navy);font-weight:600;">{{ $counselor->email }}</a>
                </div>
                @endif
                @if($counselor->ms_teams_account)
                <div class="counselor-contact-row">
                    <i>🎥</i>
                    <span>{{ $counselor->ms_teams_account }}</span>
                </div>
                @endif

                {{-- Schedule --}}
                @if($counselor->schedules && $counselor->schedules->count())
                <h3 style="margin-top:28px;margin-bottom:16px;">Weekly Availability</h3>
                <div class="schedule-grid">
                    @foreach(['Monday','Tuesday','Wednesday','Thursday','Friday','Saturday'] as $day)
                    @php $ds = $counselor->schedules->where('day_of_week', $day); @endphp
                    <div class="schedule-day {{ $ds->isNotEmpty() ? 'available' : '' }}">
                        <div class="day-name">{{ $day }}</div>
                        @if($ds->isNotEmpty())
                            @foreach($ds as $sch)
                            <div class="day-time">
                                {{ \Carbon\Carbon::parse($sch->start_time)->format('h:i A') }}
                                &mdash;
                                {{ \Carbon\Carbon::parse($sch->end_time)->format('h:i A') }}
                            </div>
                            @endforeach
                        @else
                            <div class="unavail">Not available</div>
                        @endif
                    </div>
                    @endforeach
                </div>
                @endif

                <div style="margin-top:24px;">
                    <a class="btn btn-primary" href="{{ route('user.freedomwall.create') }}">
                        Send a Concern ↗
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

@extends('layouts.user')

@section('styles')
    @vite('resources/css/styles.css')
@endsection

@section('content')
<div class="container my-5">
    <div class="card p-4">
        <div class="row align-items-center">
            <!-- Image Section -->
            <div class="col-md-3 text-center mb-3 mb-md-0">
                <img src="{{ asset('storage/' . $counselor->image) }}" 
                     alt="{{ $counselor->name }}" 
                     class="rounded-circle img-fluid counselor-img shadow" 
                     style="width: 160px; height: 160px; object-fit: cover;">
            </div>

            <!-- Information Section -->
            <div class="col-md-9">
                <h2 class="text-primary mb-2">{{ $counselor->name }}</h2>
                <p class="mb-1"><strong>Position:</strong> {{ $counselor->position }}</p>
                <p class="mb-1"><strong>Assigned Department:</strong> {{ $counselor->college }}</p>
                <p class="mb-1"><strong>Email:</strong> <a href="mailto:{{ $counselor->email }}">{{ $counselor->email }}</a></p>
                <p class="mb-1"><strong>MS Teams:</strong> {{ $counselor->ms_teams_account }}</p>
            </div>
        </div>

        <!-- Weekly Availability -->
        <hr class="my-4">
        <div class="counselor-schedule">
            <h3 class="text-blue">Weekly Availability</h3>
            @php
                $days = ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday'];
            @endphp

            <div class="row">
                @foreach($days as $day)
                    @php
                        $daySchedules = $counselor->schedules->where('day_of_week', $day);
                    @endphp
                    <div class="col-md-4 mb-3">
                        <div class="schedule-block p-3 border rounded shadow-sm h-100">
                            <h5 class="text-gold">{{ $day }}</h5>
                            @if($daySchedules->isNotEmpty())
                                <ul class="list-unstyled mb-0">
                                    @foreach($daySchedules as $schedule)
                                        <li>
                                            {{ \Carbon\Carbon::parse($schedule->start_time)->format('h:i A') }} - 
                                            {{ \Carbon\Carbon::parse($schedule->end_time)->format('h:i A') }}
                                        </li>
                                    @endforeach
                                </ul>
                            @else
                                <p class="text-muted mb-0">Not Available</p>
                            @endif
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</div>
@endsection

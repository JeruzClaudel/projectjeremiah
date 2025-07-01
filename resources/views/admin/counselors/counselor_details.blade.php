@vite('resources/css/style1.css')
<x-app-layout>
    <div class="top-bar">
        <a class="top-button back" href="{{ route('admin.counselor.dashboard') }}">&larr; BACK</a>
        
        <h2 class="navigation-title">Counselor Details</h2>
    </div>
    <div class="nav-line-separator"></div>

    <div class="pane">
        <div class="counselor-details-card">

            {{-- EDIT --}}
            <a class="top-button back" href="{{ route('admin.counselor.edit', $counselor->id) }}">EDIT</a>

            {{-- DELETE --}}
            <a href="#" class="top-button back" onclick="event.preventDefault(); if(confirm('Are you sure you want to delete this counselor?')) { document.getElementById('delete-counselor-{{ $counselor->id }}').submit(); }">
            DELETE
            </a>
            <form id="delete-counselor-{{ $counselor->id }}" action="{{ route('admin.counselor.delete', $counselor->id) }}"  method="POST" 
                style="display: none;">
                @csrf
                @method('DELETE')
            </form>

            {{-- COUNSELOR DETAILS --}}
            <div class="counselor-info">
                <h2>{{ $counselor->name }}</h2>
                <p><strong>Position:</strong> {{ $counselor->position }}</p>
                <p><strong>College:</strong> {{ $counselor->college }}</p>
                <p><strong>Email:</strong> {{ $counselor->email }}</p>
                <p><strong>MS Teams Account:</strong> {{ $counselor->ms_teams_account }}</p>
            </div>

            {{-- COUNSELOR SCHEDULES --}}

            <div class="counselor-schedule">
                <h3>Weekly Availability</h3>
                @php
                    $days = ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday'];
                @endphp

                @foreach($days as $day)
                    @php
                        $daySchedules = $counselor->schedules->where('day_of_week', $day);
                    @endphp
                    <div class="day-block">
                        <h4>{{ $day }}</h4>
                        @if($daySchedules->isNotEmpty())
                            <ul>
                                @foreach($daySchedules as $schedule)
                                    <li>{{ \Carbon\Carbon::parse($schedule->start_time)->format('h:i A') }} - {{ \Carbon\Carbon::parse($schedule->end_time)->format('h:i A') }}</li>
                                @endforeach
                            </ul>
                        @else
                            <p>Not Available</p>
                        @endif
                    </div>
                @endforeach
            </div>     
            
        </div>
            <div class="counselor-image-large">
                @if($counselor->image)
                    <img src="{{ asset('storage/' . $counselor->image) }}" alt="{{ $counselor->name }}" width="200">
                @else
                    <img src="{{ asset('images/default-avatar.png') }}" alt="Default Image" width="200">
                @endif
            </div>
            
    </div>
</x-app-layout>

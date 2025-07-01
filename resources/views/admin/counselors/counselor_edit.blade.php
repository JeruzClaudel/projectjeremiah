@vite('resources/css/style1.css')
<x-app-layout>
    <div class="top-bar">
        <a class="top-button back" href="{{ route('admin.counselor.dashboard') }}">&larr; BACK</a>
        <h2 class="navigation-title">Edit Counselor</h2>
    </div>
    <div class="nav-line-separator"></div>
    <div class="pane">
        <div class="right-side">
            <form action="{{ route('admin.counselor.update', $counselor->id) }}" method="POST" enctype="multipart/form-data" class="form-example">
                @csrf
                @method('PUT')
                <div class="data-info-pane">
                    
                    {{-- Current IMAGE --}}
                    <label class="image" for="image">CURRENT IMAGE</label>
                    <div class="image-preview">
                        @if($counselor->image)
                            <img src="{{ asset('storage/' . $counselor->image) }}" alt="{{ $counselor->name }}" width="150">
                        @else
                            <img src="{{ asset('images/default-avatar.png') }}" alt="Default Image" width="150">
                        @endif
                    </div>
                    <label class="image" for="image">UPLOAD NEW IMAGE</label>
                    <input type="file" name="image" accept="image/*" id="imageInput">

                    <div class="information name">
                        <label class="type" for="name">NAME</label>
                        <input type="text" id="name" name="name" class="content" value="{{ $counselor->name }}"/>
                    </div>

                    <div class="information name">
                        <label class="type" for="position">POSITION</label>
                        <input type="text" id="position" name="position" class="content" value="{{ $counselor->position }}"/>
                    </div>

                    <div class="information name">
                        <label class="type" for="college">COLLEGE</label>
                        <input type="text" id="college" name="college" class="content" value="{{ $counselor->college }}"/>
                    </div>

                    <div class="information name">
                        <label class="type" for="email">EMAIL</label>
                        <input type="text" id="email" name="email" class="content" value="{{ $counselor->email }}"/>
                    </div>

                    <div class="information name">
                        <label class="type" for="ms_teams_account">MS TEAMS ACCOUNT</label>
                        <input type="text" id="ms_teams_account" name="ms_teams_account" class="content" value="{{ $counselor->ms_teams_account }}"/>
                    </div>

                    <h3>Weekly Availability</h3>

                    @php
                        $days = ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday'];
                    @endphp

                    @foreach($days as $day)
                        @php
                            $daySchedules = $counselor->schedules->where('day_of_week', $day);
                        @endphp
                        <div class="day-block">
                            <label>
                                <input type="checkbox" class="day-checkbox" name="availability[{{ $day }}][available]" value="1" onchange="toggleTimeInputs('{{ $day }}')"
                                    {{ $daySchedules->isNotEmpty() ? 'checked' : '' }}>
                                {{ $day }}
                            </label>
                            <div id="{{ $day }}-times" style="margin-left:20px; {{ $daySchedules->isNotEmpty() ? '' : 'display:none;' }}">

                                @foreach($daySchedules as $index => $schedule)
                                    <div class="time-range" id="{{ $day }}-time-{{ $index }}">
                                        Start: <input type="time" name="availability[{{ $day }}][times][{{ $index }}][start]" value="{{ $schedule->start_time }}">
                                        End: <input type="time" name="availability[{{ $day }}][times][{{ $index }}][end]" value="{{ $schedule->end_time }}">
                                        <button type="button" onclick="removeTimeRange('{{ $day }}', {{ $index }})">Remove</button>
                                    </div>
                                @endforeach

                                <button type="button" onclick="addTimeRange('{{ $day }}')">Add More Time Range</button>
                            </div>
                        </div>
                    @endforeach

                </div>

                <input class="add-button" type="submit" value="UPDATE" />
            </form>
        </div>
    </div>
</x-app-layout>

<script>
    const timeCounters = {};

    function toggleTimeInputs(day) {
        const checkbox = document.querySelector(`input[name="availability[${day}][available]"]`);
        const timesDiv = document.getElementById(`${day}-times`);

        if (checkbox.checked) {
            timesDiv.style.display = 'block';
        } else {
            timesDiv.style.display = 'none';
        }
    }

    function addTimeRange(day) {
        if (!timeCounters[day]) {
            const existingRanges = document.querySelectorAll(`#${day}-times .time-range`);
            timeCounters[day] = existingRanges.length;
        } else {
            timeCounters[day]++;
        }

        const container = document.getElementById(`${day}-times`);
        const index = timeCounters[day];

        const timeRangeDiv = document.createElement('div');
        timeRangeDiv.className = 'time-range';
        timeRangeDiv.id = `${day}-time-${index}`;
        timeRangeDiv.innerHTML = `
            Start: <input type="time" name="availability[${day}][times][${index}][start]">
            End: <input type="time" name="availability[${day}][times][${index}][end]">
            <button type="button" onclick="removeTimeRange('${day}', ${index})">Remove</button>
        `;

        container.insertBefore(timeRangeDiv, container.querySelector('button[onclick^="addTimeRange"]'));
    }

    function removeTimeRange(day, index) {
        const timeRangeDiv = document.getElementById(`${day}-time-${index}`);
        if (timeRangeDiv) {
            timeRangeDiv.remove();
        }
    }

        document.getElementById('imageInput').addEventListener('change', function(event) {
            const input = event.target;
            if (input.files && input.files[0]) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    document.querySelector('.image-preview img').src = e.target.result;
                };
                reader.readAsDataURL(input.files[0]);
            }
        });

</script>

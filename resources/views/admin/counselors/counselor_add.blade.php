@vite('resources/css/style1.css')
<x-app-layout>
        <div class="top-bar">
            <a class="top-button back" href="{{ route('admin.counselor.dashboard') }}">&larr; BACK</a>
            <h2 class="navigation-title">Add Counselor</h2>
        </div>
        <div class="nav-line-separator"></div>
        <div class="pane">
            <div class="right-side">
               <form action="{{ route('admin.counselor.store') }}" method="POST" enctype="multipart/form-data" class="form-example">
                    @csrf
                    <div class="data-info-pane">
                        
                        {{-- IMAGE HERE --}}
                        <img id="image-preview" src="#" alt="Image Preview" style="display:none; max-width: 200px; margin-top: 10px; border-radius: 8px; border: 1px solid #c5c5c5;">                       
                       <label class="image" for="image">IMAGE</label>
                        <input type="file" id="image" name="image" accept="image/*" onchange="previewImage(event)">               
                        
                        <div class="information name">
                            <label class="type" for="name">NAME</label>
                            <input type="text" id="name" name="name" class="content"/>
                        </div>

                        <div class="information name">
                            <label class="type" for="position">POSITION</label>
                            <input type="text" id="position" name="position" class="content"/>
                        </div>

                        <div class="information name">
                            <label class="type" for="college">COLLEGE</label>
                            <input type="text" id="college" name="college" class="content"/>
                        </div>

                        <div class="information name">
                            <label class="type" for="email">EMAIL</label>
                            <input type="text" id="email" name="email" class="content"/>
                        </div>

                        <div class="information name">
                            <label class="type" for="ms_teams_account">MS TEAMS ACCOUNT</label>
                            <input type="text" id="ms_teams_account" name="ms_teams_account" class="content"/>
                        </div>

                        <h3>Weekly Availability</h3>

                                @php
                                    $days = ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday'];
                                @endphp

                                @foreach($days as $day)
                                    <div class="day-block">
                                        <label>
                                            <input type="checkbox" class="day-checkbox" name="availability[{{ $day }}][available]" value="1" onchange="toggleTimeInputs('{{ $day }}')">
                                            {{ $day }}
                                        </label>
                                        <div id="{{ $day }}-times" style="margin-left:20px; display:none;">

                                            <div class="time-range" id="{{ $day }}-time-0">
                                                Start: <input type="time" name="availability[{{ $day }}][times][0][start]">
                                                End: <input type="time" name="availability[{{ $day }}][times][0][end]">
                                                <button type="button" onclick="removeTimeRange('{{ $day }}', 0)">Remove</button>
                                            </div>

                                            <button type="button" onclick="addTimeRange('{{ $day }}')">Add More Time Range</button>
                                        </div>
                                    </div>
                                @endforeach

                    </div>

                    <input class="add-button" type="submit" value="CONFIRM" />
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
            timeCounters[day] = 1; // start from 1 because 0 already exists
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

    function previewImage(event) {
    const input = event.target;
    const preview = document.getElementById('image-preview');

    if (input.files && input.files[0]) {
        const reader = new FileReader();

        reader.onload = function(e) {
            preview.src = e.target.result;
            preview.style.display = 'block';
        }

        reader.readAsDataURL(input.files[0]);
    } else {
        preview.src = '#';
        preview.style.display = 'none';
    }
}



</script>


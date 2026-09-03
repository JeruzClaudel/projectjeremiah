<x-app-layout title="Edit Counselor">

<div class="top-bar">
    <a class="top-button back" href="{{ route('admin.counselor.details', $counselor->id) }}">&larr; Back</a>
    <h2 class="navigation-title">Edit Counselor</h2>
</div>
<div class="nav-line-separator"></div>

<form action="{{ route('admin.counselor.update', $counselor->id) }}"
      method="POST" enctype="multipart/form-data"
      style="display:flex;gap:22px;flex-wrap:wrap;align-items:flex-start;">
    @csrf @method('PUT')

    {{-- Left: image upload --}}
    <div style="width:210px;flex-shrink:0;">
        <div style="background:#fff;border:1.5px solid var(--border);border-radius:14px;
                    overflow:hidden;box-shadow:var(--shadow);text-align:center;padding:18px 14px;">
            <div style="font-size:.68rem;font-weight:800;color:var(--muted);
                         text-transform:uppercase;letter-spacing:.4px;margin-bottom:10px;">Photo</div>
            @if($counselor->image)
                <img id="img-preview" src="{{ asset('storage/'.$counselor->image) }}"
                     alt="{{ $counselor->name }}"
                     style="width:130px;height:130px;border-radius:50%;object-fit:cover;
                            border:3px solid var(--gold);display:block;margin:0 auto 14px;">
            @else
                <div id="img-initials"
                     style="width:130px;height:130px;border-radius:50%;
                            background:linear-gradient(135deg,var(--navy),var(--navy2));
                            display:flex;align-items:center;justify-content:center;
                            font-size:3rem;font-weight:800;color:var(--gold);
                            border:3px solid var(--gold);margin:0 auto 14px;">
                    {{ strtoupper(substr($counselor->name,0,1)) }}
                </div>
                <img id="img-preview" style="display:none;width:130px;height:130px;border-radius:50%;
                     object-fit:cover;border:3px solid var(--gold);margin:0 auto 14px;">
            @endif
            <label for="imageInput"
                   style="display:inline-flex;align-items:center;gap:6px;padding:8px 16px;
                          background:var(--navy);color:var(--gold);border-radius:8px;
                          font-size:.78rem;font-weight:700;cursor:pointer;">
                <i class="fas fa-upload"></i> Upload Photo
            </label>
            <input type="file" id="imageInput" name="image"
                   accept="image/*" style="display:none;">
            <div style="font-size:.68rem;color:var(--muted);margin-top:8px;">JPG, PNG, WEBP — max 2MB</div>
        </div>
    </div>

    {{-- Right: fields --}}
    <div style="flex:1;min-width:280px;">
        <div class="data-info-pane">

            <div class="information">
                <label class="type">NAME <span style="color:#ef4444;">*</span></label>
                <input type="text" name="name" class="content"
                       value="{{ old('name',$counselor->name) }}" required>
                @error('name')<span class="text-danger">{{ $message }}</span>@enderror
            </div>

            <div class="information">
                <label class="type">POSITION</label>
                <input type="text" name="position" class="content"
                       value="{{ old('position',$counselor->position) }}"
                       placeholder="e.g. Guidance Counselor">
            </div>

            <div class="information">
                <label class="type">COLLEGE / DEPARTMENT</label>
                <input type="text" name="college" class="content"
                       value="{{ old('college',$counselor->college) }}">
            </div>

            <div class="information">
                <label class="type">EMAIL</label>
                <input type="email" name="email" class="content"
                       value="{{ old('email',$counselor->email) }}">
            </div>

            <div class="information">
                <label class="type">MS TEAMS ACCOUNT</label>
                <input type="text" name="ms_teams_account" class="content"
                       value="{{ old('ms_teams_account',$counselor->ms_teams_account) }}">
            </div>

            {{-- Schedule --}}
            <div style="margin-top:6px;">
                <label class="type" style="display:block;margin-bottom:12px;">WEEKLY AVAILABILITY</label>
                @php $days = ['Monday','Tuesday','Wednesday','Thursday','Friday','Saturday']; @endphp
                @foreach($days as $day)
                @php $ds = $counselor->schedules->where('day_of_week',$day); @endphp
                <div style="background:var(--light);border:1.5px solid var(--border);border-radius:10px;
                            padding:12px 14px;margin-bottom:8px;">
                    <label style="display:flex;align-items:center;gap:8px;cursor:pointer;
                                  font-size:.84rem;font-weight:600;color:var(--navy);margin-bottom:0;">
                        <input type="checkbox"
                               class="day-checkbox"
                               name="availability[{{ $day }}][available]"
                               value="1"
                               {{ $ds->isNotEmpty() ? 'checked' : '' }}
                               onchange="toggleDay('{{ $day }}')"
                               style="width:16px;height:16px;accent-color:var(--navy);">
                        {{ $day }}
                    </label>

                    <div id="{{ $day }}-times"
                         style="{{ $ds->isEmpty() ? 'display:none;' : '' }} margin-top:10px;padding-left:24px;">
                        @foreach($ds as $idx => $sch)
                        <div class="time-range" id="{{ $day }}-time-{{ $idx }}"
                             style="display:flex;align-items:center;gap:8px;margin-bottom:6px;flex-wrap:wrap;">
                            <span style="font-size:.75rem;font-weight:600;color:var(--muted);min-width:36px;">Start</span>
                            <input type="time" name="availability[{{ $day }}][times][{{ $idx }}][start]"
                                   value="{{ $sch->start_time }}"
                                   style="padding:5px 9px;border:1.5px solid var(--border);border-radius:7px;font-size:.84rem;">
                            <span style="font-size:.75rem;font-weight:600;color:var(--muted);min-width:24px;">End</span>
                            <input type="time" name="availability[{{ $day }}][times][{{ $idx }}][end]"
                                   value="{{ $sch->end_time }}"
                                   style="padding:5px 9px;border:1.5px solid var(--border);border-radius:7px;font-size:.84rem;">
                            <button type="button" onclick="removeTimeRange('{{ $day }}',{{ $idx }})"
                                    style="padding:4px 10px;background:#fef2f2;color:#dc2626;
                                           border:1px solid #fecaca;border-radius:6px;font-size:.72rem;
                                           font-weight:700;cursor:pointer;">
                                <i class="fas fa-times"></i>
                            </button>
                        </div>
                        @endforeach
                        <button type="button" onclick="addTimeRange('{{ $day }}')"
                                style="display:inline-flex;align-items:center;gap:5px;
                                       padding:5px 12px;background:var(--navy);color:var(--gold);
                                       border:none;border-radius:7px;font-size:.72rem;font-weight:700;cursor:pointer;margin-top:4px;">
                            <i class="fas fa-plus"></i> Add Time
                        </button>
                    </div>
                </div>
                @endforeach
            </div>

        </div>
        <input class="add-button" type="submit" value="Save Changes">
    </div>
</form>

<script>
const timeCounters = {};
function toggleDay(day) {
    const cb = document.querySelector(`input[name="availability[${day}][available]"]`);
    document.getElementById(`${day}-times`).style.display = cb.checked ? 'block' : 'none';
}
function addTimeRange(day) {
    if (!timeCounters[day]) {
        timeCounters[day] = document.querySelectorAll(`#${day}-times .time-range`).length;
    } else { timeCounters[day]++; }
    const idx = timeCounters[day];
    const container = document.getElementById(`${day}-times`);
    const addBtn = container.querySelector('button[onclick^="addTimeRange"]');
    const div = document.createElement('div');
    div.className = 'time-range';
    div.id = `${day}-time-${idx}`;
    div.style = 'display:flex;align-items:center;gap:8px;margin-bottom:6px;flex-wrap:wrap;';
    div.innerHTML = `
        <span style="font-size:.75rem;font-weight:600;color:var(--muted);min-width:36px;">Start</span>
        <input type="time" name="availability[${day}][times][${idx}][start]"
               style="padding:5px 9px;border:1.5px solid var(--border);border-radius:7px;font-size:.84rem;">
        <span style="font-size:.75rem;font-weight:600;color:var(--muted);min-width:24px;">End</span>
        <input type="time" name="availability[${day}][times][${idx}][end]"
               style="padding:5px 9px;border:1.5px solid var(--border);border-radius:7px;font-size:.84rem;">
        <button type="button" onclick="removeTimeRange('${day}',${idx})"
                style="padding:4px 10px;background:#fef2f2;color:#dc2626;border:1px solid #fecaca;
                       border-radius:6px;font-size:.72rem;font-weight:700;cursor:pointer;">
            <i class="fas fa-times"></i>
        </button>`;
    container.insertBefore(div, addBtn);
}
function removeTimeRange(day, idx) {
    const el = document.getElementById(`${day}-time-${idx}`);
    if (el) el.remove();
}
document.getElementById('imageInput').addEventListener('change', function (e) {
    const file = e.target.files[0];
    if (!file) return;
    const reader = new FileReader();
    reader.onload = function (ev) {
        const preview = document.getElementById('img-preview');
        const initials = document.getElementById('img-initials');
        preview.src = ev.target.result;
        preview.style.display = 'block';
        if (initials) initials.style.display = 'none';
    };
    reader.readAsDataURL(file);
});
</script>

</x-app-layout>

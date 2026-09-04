<x-app-layout title="Edit Student">

<div class="top-bar">
    <a class="top-button back" href="{{ route('admin.students.index') }}">&larr; Back</a>
    <h2 class="navigation-title">Edit Student Account</h2>
</div>
<div class="nav-line-separator"></div>

<div style="max-width:580px;">

    {{-- Student card header --}}
    <div style="background:linear-gradient(135deg,var(--navy),var(--navy2));
                border-radius:14px 14px 0 0;padding:20px 24px;
                display:flex;align-items:center;gap:14px;">
        <div style="width:48px;height:48px;border-radius:50%;
                    background:linear-gradient(135deg,var(--gold2),var(--gold));
                    color:var(--navy);font-weight:800;font-size:1.1rem;
                    display:flex;align-items:center;justify-content:center;flex-shrink:0;">
            {{ strtoupper(substr($student->name, 0, 1)) }}
        </div>
        <div>
            <div style="font-size:.95rem;font-weight:700;color:#fff;">{{ $student->name }}</div>
            <div style="font-size:.72rem;color:rgba(255,255,255,.5);">
                Registered {{ $student->created_at->format('M d, Y') }}
                &nbsp;·&nbsp;
                <span style="color:{{ $student->is_active ? '#86efac' : '#fca5a5' }};">
                    {{ $student->is_active ? 'Active' : 'Deactivated' }}
                </span>
            </div>
        </div>
    </div>

    <div style="background:#fff;border:1.5px solid var(--border);border-top:none;
                border-radius:0 0 14px 14px;box-shadow:var(--shadow);padding:24px;">

        <form action="{{ route('admin.students.update', $student) }}" method="POST">
            @csrf @method('PUT')

            <div class="data-info-pane" style="box-shadow:none;border:none;padding:0;gap:18px;">

                <div class="information">
                    <label class="type">FULL NAME <span style="color:#ef4444;">*</span></label>
                    <input type="text" name="name" class="content"
                           value="{{ old('name', $student->name) }}" required>
                    @error('name')<span class="text-danger">{{ $message }}</span>@enderror
                </div>

                <div class="information">
                    <label class="type">EMAIL ADDRESS <span style="color:#ef4444;">*</span></label>
                    <input type="email" name="email" class="content"
                           value="{{ old('email', $student->email) }}" required>
                    <small style="font-size:.7rem;color:var(--muted);margin-top:4px;display:block;">
                        Only @students.nu-laguna.edu.ph and @shs.nu-laguna.edu.ph accepted.
                    </small>
                    @error('email')<span class="text-danger">{{ $message }}</span>@enderror
                </div>

                <div style="display:grid;grid-template-columns:1fr 1fr;gap:14px;">
                    <div class="information">
                        <label class="type">PROGRAM</label>
                        <select name="program" class="content" id="edit-program"
                                onchange="updateEditYearLevel(this.value)"
                                style="width:100%;padding:9px 12px;border:1.5px solid var(--border);border-radius:8px;">
                            <option value="">— Not set —</option>
                            <optgroup label="School of Arts and Sciences">
                                @foreach(['ABCOMM','BMMA','BSCRIM','BSESS','BSPsych'] as $p)
                                <option value="{{ $p }}" {{ old('program',$student->program)===$p?'selected':'' }}>{{ $p }}</option>
                                @endforeach
                            </optgroup>
                            <optgroup label="Accountancy, Business and Management">
                                @foreach(['BSA','BSAIS','BSTM','BSBA-DM'] as $p)
                                <option value="{{ $p }}" {{ old('program',$student->program)===$p?'selected':'' }}>{{ $p }}</option>
                                @endforeach
                            </optgroup>
                            <optgroup label="Engineering and Architecture">
                                @foreach(['BSArch','BSCE','BSCpE'] as $p)
                                <option value="{{ $p }}" {{ old('program',$student->program)===$p?'selected':'' }}>{{ $p }}</option>
                                @endforeach
                            </optgroup>
                            <optgroup label="Computer Studies">
                                @foreach(['BSIT','BSCS','BSIS'] as $p)
                                <option value="{{ $p }}" {{ old('program',$student->program)===$p?'selected':'' }}>{{ $p }}</option>
                                @endforeach
                            </optgroup>
                            <optgroup label="Senior High School">
                                <option value="GRADE-11" {{ old('program',$student->program)==='GRADE-11'?'selected':'' }}>Grade 11</option>
                                <option value="GRADE-12" {{ old('program',$student->program)==='GRADE-12'?'selected':'' }}>Grade 12</option>
                            </optgroup>
                        </select>
                        @error('program')<span class="text-danger">{{ $message }}</span>@enderror
                    </div>

                    <div class="information">
                        <label class="type">YEAR LEVEL</label>
                        <select name="year_level" id="edit-year-level" class="content"
                                style="width:100%;padding:9px 12px;border:1.5px solid var(--border);border-radius:8px;">
                            <option value="">— Not set —</option>
                        </select>
                        @error('year_level')<span class="text-danger">{{ $message }}</span>@enderror
                    </div>
                </div>

                {{-- Active status toggle --}}
                <div style="padding:14px 16px;background:var(--light);border:1.5px solid var(--border);
                            border-radius:10px;">
                    <label style="display:flex;align-items:center;gap:10px;cursor:pointer;margin:0;">
                        <input type="checkbox" name="is_active" value="1"
                               {{ old('is_active', $student->is_active) ? 'checked' : '' }}
                               style="width:17px;height:17px;accent-color:var(--navy);">
                        <div>
                            <div style="font-size:.84rem;font-weight:700;color:var(--navy);">Account Active</div>
                            <div style="font-size:.72rem;color:var(--muted);">
                                When unchecked, the student cannot post on e-Hayag.
                            </div>
                        </div>
                    </label>
                </div>

            </div>

            <div style="display:flex;gap:10px;margin-top:20px;padding-top:16px;border-top:1px solid var(--border);">
                <button type="submit"
                        style="flex:1;padding:11px;background:linear-gradient(135deg,var(--navy),var(--navy2));
                               color:var(--gold);border:none;border-radius:10px;font-size:.9rem;
                               font-weight:700;cursor:pointer;transition:opacity .18s;"
                        onmouseover="this.style.opacity='.88'"
                        onmouseout="this.style.opacity='1'">
                    <i class="fas fa-floppy-disk me-2"></i> Save Changes
                </button>
                <a href="{{ route('admin.students.index') }}"
                   style="padding:11px 20px;background:var(--light);color:var(--text);
                          border:1.5px solid var(--border);border-radius:10px;
                          font-size:.9rem;font-weight:600;text-decoration:none;
                          display:flex;align-items:center;">
                    Cancel
                </a>
            </div>
        </form>
    </div>
</div>

<script>
const editShs = ['GRADE-11','GRADE-12'];
const editShsOptions = [
    {value:'BUEN - Business and Entrepreneurship',label:'BUEN - Business and Entrepreneurship'},
    {value:'STEM - Science, Technology, Engineering, and Mathematics',label:'STEM - Science, Technology, Engineering, and Mathematics'},
    {value:'ASSH - Arts, Social Sciences, and Humanities',label:'ASSH - Arts, Social Sciences, and Humanities'},
];
const editCollegeOptions = [
    {value:'1st Year',label:'1st Year'},{value:'2nd Year',label:'2nd Year'},
    {value:'3rd Year',label:'3rd Year'},{value:'4th Year',label:'4th Year'},
];
const currentYear = '{{ old('year_level', $student->year_level ?? '') }}';

function updateEditYearLevel(program) {
    const sel  = document.getElementById('edit-year-level');
    const opts = editShs.includes(program) ? editShsOptions : (program ? editCollegeOptions : []);
    sel.innerHTML = '<option value="">— Not set —</option>';
    opts.forEach(function(o) {
        const el = document.createElement('option');
        el.value = o.value; el.textContent = o.label;
        if (o.value === currentYear) el.selected = true;
        sel.appendChild(el);
    });
}

document.addEventListener('DOMContentLoaded', function () {
    const prog = document.getElementById('edit-program');
    if (prog.value) updateEditYearLevel(prog.value);
});
</script>

</x-app-layout>

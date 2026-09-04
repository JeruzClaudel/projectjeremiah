<x-student-guest-layout>
@section('title', 'Register — Project Jeremiah')

<div class="guest-card-header">
    <div class="guest-icon">＋</div>
    <h1>Create your account</h1>
    <p>Register to use e-Hayag and guidance services</p>
</div>

@if($errors->any())
    <div class="guest-error">
        @foreach($errors->all() as $error)
            <div>{{ $error }}</div>
        @endforeach
    </div>
@endif

@if(session('status'))
    <div class="guest-status">{{ session('status') }}</div>
@endif

<form method="POST" action="{{ route('student.register.post') }}">
    @csrf

    <div class="form-grid" style="margin-bottom:0;">

        <div class="field full">
            <label for="name">Full name <span style="color:#dc2626;">*</span></label>
            <input type="text" id="name" name="name" value="{{ old('name') }}"
                   placeholder="e.g. Juan dela Cruz" required autofocus>
        </div>

        <div class="field full">
            <label for="email">Email address <span style="color:#dc2626;">*</span></label>
            <input type="email" id="email" name="email" value="{{ old('email') }}"
                   placeholder="yourname@students.nu-laguna.edu.ph" required>
            <span class="field-note">Only <strong>@students.nu-laguna.edu.ph</strong> and <strong>@shs.nu-laguna.edu.ph</strong> are accepted.</span>
        </div>

        <div class="field">
            <label for="reg-program">Program <span style="color:#dc2626;">*</span></label>
            <select id="reg-program" name="program" required onchange="updateRegYearLevel(this.value)">
                <option value="">Select your program</option>
                <optgroup label="School of Arts and Sciences">
                    <option value="ABCOMM"  {{ old('program')=='ABCOMM'  ?'selected':'' }}>ABCOMM — Bachelor of Arts in Communication</option>
                    <option value="BMMA"    {{ old('program')=='BMMA'    ?'selected':'' }}>BMMA — Bachelor of Multimedia Arts</option>
                    <option value="BSCRIM"  {{ old('program')=='BSCRIM'  ?'selected':'' }}>BSCRIM — BS Criminology</option>
                    <option value="BSESS"   {{ old('program')=='BSESS'   ?'selected':'' }}>BSESS — BS Exercise and Sports Sciences</option>
                    <option value="BSPsych" {{ old('program')=='BSPsych' ?'selected':'' }}>BSPsych — BS Psychology</option>
                </optgroup>
                <optgroup label="School of Accountancy, Business and Management">
                    <option value="BSA"     {{ old('program')=='BSA'     ?'selected':'' }}>BSA — BS Accountancy</option>
                    <option value="BSAIS"   {{ old('program')=='BSAIS'   ?'selected':'' }}>BSAIS — BS Accounting Information System</option>
                    <option value="BSTM"    {{ old('program')=='BSTM'    ?'selected':'' }}>BSTM — BS Tourism Management</option>
                    <option value="BSBA-DM" {{ old('program')=='BSBA-DM' ?'selected':'' }}>BSBA-DM — BSBA major in Digital Marketing</option>
                </optgroup>
                <optgroup label="School of Engineering and Architecture">
                    <option value="BSArch" {{ old('program')=='BSArch' ?'selected':'' }}>BSArch — BS Architecture</option>
                    <option value="BSCE"   {{ old('program')=='BSCE'   ?'selected':'' }}>BSCE — BS Civil Engineering</option>
                    <option value="BSCpE"  {{ old('program')=='BSCpE'  ?'selected':'' }}>BSCpE — BS Computer Engineering</option>
                </optgroup>
                <optgroup label="School of Computer Studies">
                    <option value="BSIT" {{ old('program')=='BSIT' ?'selected':'' }}>BSIT — BS Information Technology</option>
                    <option value="BSCS" {{ old('program')=='BSCS' ?'selected':'' }}>BSCS — BS Computer Science</option>
                    <option value="BSIS" {{ old('program')=='BSIS' ?'selected':'' }}>BSIS — BS Information Systems</option>
                </optgroup>
                <optgroup label="Senior High School">
                    <option value="GRADE-11" {{ old('program')=='GRADE-11' ?'selected':'' }}>Grade 11 — Senior High School</option>
                    <option value="GRADE-12" {{ old('program')=='GRADE-12' ?'selected':'' }}>Grade 12 — Senior High School</option>
                </optgroup>
            </select>
            @error('program')<span class="field-error">{{ $message }}</span>@enderror
        </div>

        <div class="field">
            <label for="reg-year-level">Year level <span style="color:#dc2626;">*</span></label>
            <select id="reg-year-level" name="year_level" required>
                <option value="">Select year level</option>
            </select>
            @error('year_level')<span class="field-error">{{ $message }}</span>@enderror
        </div>

        <div class="field">
            <label for="password">Password <span style="color:#dc2626;">*</span></label>
            <input type="password" id="password" name="password" placeholder="Min. 8 characters" required>
            @error('password')<span class="field-error">{{ $message }}</span>@enderror
        </div>

        <div class="field">
            <label for="password_confirmation">Confirm password <span style="color:#dc2626;">*</span></label>
            <input type="password" id="password_confirmation" name="password_confirmation" placeholder="Repeat your password" required>
        </div>

        {{-- Privacy consent --}}
        <div class="field full" style="margin-top:4px;">
            <div style="background:var(--sky);border:1px solid var(--gold);border-radius:12px;padding:14px 16px;">
                <label class="check-label">
                    <input type="checkbox" id="privacy_consent" name="privacy_consent" value="1"
                           {{ old('privacy_consent') ? 'checked' : '' }} required>
                    <span>I have read and agree to the
                        <button type="button" onclick="openPrivacyModal()"
                                style="background:none;border:none;padding:0;color:var(--navy);font-weight:700;font-size:inherit;text-decoration:underline;cursor:pointer;">
                            Privacy Notice
                        </button>.
                        I consent to my data being processed in accordance with <strong>RA 10173</strong>.
                        Data is retained for <strong>5 years</strong>. <span style="color:#dc2626;">*</span>
                    </span>
                </label>
                @error('privacy_consent')
                    <div class="field-error" style="margin-top:6px;">{{ $message }}</div>
                @enderror
            </div>
        </div>

    </div>

    <div class="form-actions" style="margin-top:22px;border-top:1px solid var(--sky);padding-top:20px;">
        <a href="{{ route('home') }}" class="btn btn-secondary">Back</a>
        <button type="submit" id="submit-btn" class="btn btn-primary"
                {{ old('privacy_consent') ? '' : 'disabled' }}
                style="{{ old('privacy_consent') ? '' : 'opacity:.5;cursor:not-allowed;' }}">
            Create account <span>↗</span>
        </button>
    </div>

    <p style="text-align:center;color:var(--muted);font-size:.78rem;margin-top:14px;">
        Already registered?
        <a href="{{ route('student.reactivate.request') }}" style="color:var(--navy);font-weight:700;text-decoration:underline;">Reactivate your account</a>
    </p>
</form>

{{-- Privacy Notice Modal --}}
@include('auth.privacy-notice')

<script>
const regShs = ['GRADE-11','GRADE-12'];
const regShsOptions = [
    {value:'BUEN - Business and Entrepreneurship',label:'BUEN - Business and Entrepreneurship'},
    {value:'STEM - Science, Technology, Engineering, and Mathematics',label:'STEM - Science, Technology, Engineering, and Mathematics'},
    {value:'ASSH - Arts, Social Sciences, and Humanities',label:'ASSH - Arts, Social Sciences, and Humanities'},
];
const regCollegeOptions = [
    {value:'1st Year',label:'1st Year'},{value:'2nd Year',label:'2nd Year'},
    {value:'3rd Year',label:'3rd Year'},{value:'4th Year',label:'4th Year'},
];
const serverOldProgram = '{{ old('program') }}';
const serverOldYear    = '{{ old('year_level') }}';
const LS_KEY = 'reg_draft_pj';

function saveDraft(){
    localStorage.setItem(LS_KEY, JSON.stringify({
        name:       document.querySelector('[name="name"]').value,
        email:      document.querySelector('[name="email"]').value,
        program:    document.getElementById('reg-program').value,
        year_level: document.getElementById('reg-year-level').value,
    }));
}
function clearDraft(){ localStorage.removeItem(LS_KEY); }

function updateRegYearLevel(program, restoreYear){
    const sel = document.getElementById('reg-year-level');
    const opts = regShs.includes(program) ? regShsOptions : (program ? regCollegeOptions : []);
    sel.innerHTML = '<option value="">Select year level</option>';
    opts.forEach(function(o){
        const el = document.createElement('option');
        el.value = o.value; el.textContent = o.label;
        if(restoreYear && o.value === restoreYear) el.selected = true;
        sel.appendChild(el);
    });
}

document.addEventListener('DOMContentLoaded', function(){
    const nameI = document.querySelector('[name="name"]');
    const emailI = document.querySelector('[name="email"]');
    const prog = document.getElementById('reg-program');
    const cb   = document.getElementById('privacy_consent');
    const btn  = document.getElementById('submit-btn');

    let rp = serverOldProgram || '';
    let ry = serverOldYear    || '';

    const d = localStorage.getItem(LS_KEY);
    if(d){ try{ const j=JSON.parse(d);
        if(!rp&&j.program) rp=j.program;
        if(!ry&&j.year_level) ry=j.year_level;
        if(!nameI.value&&j.name)  nameI.value=j.name;
        if(!emailI.value&&j.email) emailI.value=j.email;
    }catch(e){} }

    if(rp) prog.value = rp;
    if(prog.value) updateRegYearLevel(prog.value, ry);

    nameI.addEventListener('input', saveDraft);
    emailI.addEventListener('input', saveDraft);
    prog.addEventListener('change', function(){ updateRegYearLevel(this.value,''); saveDraft(); });
    document.getElementById('reg-year-level').addEventListener('change', saveDraft);

    function syncBtn(){
        btn.disabled          = !cb.checked;
        btn.style.opacity     = cb.checked ? '1' : '.5';
        btn.style.cursor      = cb.checked ? 'pointer' : 'not-allowed';
    }
    cb.addEventListener('change', syncBtn);
    syncBtn();

    document.querySelector('form').addEventListener('submit', clearDraft);
});
</script>

</x-student-guest-layout>

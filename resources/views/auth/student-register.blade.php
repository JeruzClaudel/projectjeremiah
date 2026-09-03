<x-student-guest-layout>
@section('title', 'Student Registration')

<div class="student-auth-card">

    <div class="student-auth-header">
        <div class="brand-icon"><i class="fas fa-user-plus"></i></div>
        <h1>Create Account</h1>
        <p>Register to use e-Hayag and guidance services</p>
    </div>

    @if($errors->any())
        <div class="error-banner">
            @foreach($errors->all() as $error)
                <div><i class="fas fa-circle-exclamation me-1"></i>{{ $error }}</div>
            @endforeach
        </div>
    @endif

    @if(session('status'))
        <div class="status-banner">
            <i class="fas fa-circle-check me-1"></i>{{ session('status') }}
        </div>
    @endif

    <form method="POST" action="{{ route('student.register.post') }}">
        @csrf

        {{-- Full Name --}}
        <div class="sf-group">
            <label>Full Name <span style="color:#ef4444;">*</span></label>
            <div class="input-wrap">
                <i class="fas fa-user"></i>
                <input type="text" name="name" value="{{ old('name') }}"
                       placeholder="e.g. Juan dela Cruz" required autofocus>
            </div>
        </div>

        {{-- Email --}}
        <div class="sf-group">
            <label>Email Address <span style="color:#ef4444;">*</span></label>
            <div class="input-wrap">
                <i class="fas fa-envelope"></i>
                <input type="email" name="email" value="{{ old('email') }}"
                       placeholder="yourname@students.nu-laguna.edu.ph" required>
            </div>
            <small style="font-size:.72rem;color:#9ca3af;">
                Must be your NU Laguna student email
                (<strong>@students.nu-laguna.edu.ph</strong> or <strong>@shs.nu-laguna.edu.ph</strong>)
            </small>
        </div>

        {{-- Program --}}
        <div class="sf-group">
            <label>Program <span style="color:#ef4444;">*</span></label>
            <div class="input-wrap" style="padding:0; position:relative;">
                <i class="fas fa-graduation-cap" style="position:absolute;left:14px;top:50%;transform:translateY(-50%);pointer-events:none;z-index:1;color:#9ca3af;font-size:.85rem;"></i>
                <select name="program" id="reg-program" required
                        onchange="updateRegYearLevel(this.value)"
                        style="width:100%;padding:12px 12px 12px 40px;border:none;background:transparent;
                               font-size:.92rem;color:#374151;cursor:pointer;appearance:none;outline:none;">
                    <option value="">Select your program</option>
                    <optgroup label="School of Arts and Sciences">
                        <option value="ABCOMM"  {{ old('program')=='ABCOMM'  ?'selected':'' }}>ABCOMM — Bachelor of Arts in Communication</option>
                        <option value="BMMA"    {{ old('program')=='BMMA'    ?'selected':'' }}>BMMA — Bachelor of Multimedia Arts</option>
                        <option value="BSCRIM"  {{ old('program')=='BSCRIM'  ?'selected':'' }}>BSCRIM — Bachelor of Science in Criminology</option>
                        <option value="BSESS"   {{ old('program')=='BSESS'   ?'selected':'' }}>BSESS — BS Exercise and Sports Sciences</option>
                        <option value="BSPsych" {{ old('program')=='BSPsych' ?'selected':'' }}>BSPsych — Bachelor of Science in Psychology</option>
                    </optgroup>
                    <optgroup label="School of Accountancy, Business and Management">
                        <option value="BSA"     {{ old('program')=='BSA'     ?'selected':'' }}>BSA — Bachelor of Science in Accountancy</option>
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
            </div>
            @error('program')<span class="text-danger">{{ $message }}</span>@enderror
        </div>

        {{-- Year Level --}}
        <div class="sf-group">
            <label>Year Level <span style="color:#ef4444;">*</span></label>
            <div class="input-wrap" style="padding:0; position:relative;">
                <i class="fas fa-layer-group" style="position:absolute;left:14px;top:50%;transform:translateY(-50%);pointer-events:none;z-index:1;color:#9ca3af;font-size:.85rem;"></i>
                <select name="year_level" id="reg-year-level" required
                        style="width:100%;padding:12px 12px 12px 40px;border:none;background:transparent;
                               font-size:.92rem;color:#374151;cursor:pointer;appearance:none;outline:none;">
                    <option value="">Select year level</option>
                </select>
            </div>
            @error('year_level')<span class="text-danger">{{ $message }}</span>@enderror
        </div>

        {{-- Password --}}
        <div class="sf-group">
            <label>Password <span style="color:#ef4444;">*</span></label>
            <div class="input-wrap">
                <i class="fas fa-lock"></i>
                <input type="password" name="password" placeholder="Min. 8 characters" required>
            </div>
        </div>

        {{-- Confirm Password --}}
        <div class="sf-group">
            <label>Confirm Password <span style="color:#ef4444;">*</span></label>
            <div class="input-wrap">
                <i class="fas fa-lock"></i>
                <input type="password" name="password_confirmation" placeholder="Repeat password" required>
            </div>
        </div>

        {{-- Privacy Consent --}}
        <div class="sf-group">
            <div style="background:#f0f9ff;border:1.5px solid #bae6fd;border-radius:11px;padding:14px 16px;">
                <div style="display:flex;align-items:flex-start;gap:10px;">
                    <input type="checkbox" id="privacy_consent" name="privacy_consent" value="1"
                           {{ old('privacy_consent') ? 'checked' : '' }} required
                           style="width:17px;height:17px;margin-top:2px;accent-color:#0a1931;flex-shrink:0;">
                    <label for="privacy_consent" style="font-size:.8rem;color:#374151;line-height:1.6;cursor:pointer;margin:0;">
                        I have read and agree to the
                        <button type="button" onclick="openPrivacyModal()"
                                style="background:none;border:none;padding:0;color:#0a1931;font-weight:700;
                                       font-size:.8rem;text-decoration:underline;cursor:pointer;">
                            Privacy Notice
                        </button>.
                        I consent to the collection of my data by the Guidance Services Office in accordance with
                        <strong>RA 10173</strong>. Data is retained for <strong>5 years</strong>.
                        <span style="color:#ef4444;">*</span>
                    </label>
                </div>
                @error('privacy_consent')
                    <div style="margin-top:8px;padding:7px 12px;background:#fef2f2;border:1px solid #fecaca;
                                border-radius:7px;color:#dc2626;font-size:.78rem;font-weight:600;">
                        <i class="fas fa-triangle-exclamation me-1"></i>{{ $message }}
                    </div>
                @enderror
            </div>
        </div>

        <div style="background:#fef9e7;border:1px solid rgba(201,162,39,.3);border-radius:9px;
                    padding:11px 14px;margin-bottom:18px;font-size:.78rem;color:#92400e;">
            <i class="fas fa-info-circle me-1"></i>
            Your program and year level are saved to your account — you won't need to re-enter them when submitting e-Hayag posts.
        </div>

        <button type="submit" class="btn-student-submit" id="submit-btn"
                {{ old('privacy_consent') ? '' : 'disabled' }}
                style="{{ old('privacy_consent') ? '' : 'opacity:.5;cursor:not-allowed;' }}">
            <i class="fas fa-check me-2"></i> Create Account
        </button>
    </form>

    <div style="text-align:center;margin-top:16px;padding-top:14px;border-top:1px solid #f3f4f6;">
        <a href="{{ route('home') }}" style="font-size:.78rem;color:#9ca3af;text-decoration:none;">
            <i class="fas fa-arrow-left me-1"></i> Back to Home
        </a>
        &nbsp;·&nbsp;
        <a href="{{ route('student.reactivate.request') }}" style="font-size:.78rem;color:#9ca3af;text-decoration:none;">
            Reactivate account
        </a>
    </div>
</div>

{{-- Privacy Notice Modal --}}
@include('auth.privacy-notice')

<script>
const regShs = ['GRADE-11','GRADE-12'];
const regShsOptions = [
    {value:'BUEN - Business and Entrepreneurship', label:'BUEN - Business and Entrepreneurship'},
    {value:'STEM - Science, Technology, Engineering, and Mathematics', label:'STEM - Science, Technology, Engineering, and Mathematics'},
    {value:'ASSH - Arts, Social Sciences, and Humanities', label:'ASSH - Arts, Social Sciences, and Humanities'},
];
const regCollegeOptions = [
    {value:'1st Year',label:'1st Year'},
    {value:'2nd Year',label:'2nd Year'},
    {value:'3rd Year',label:'3rd Year'},
    {value:'4th Year',label:'4th Year'},
];
const serverOldProgram   = '{{ old('program') }}';
const serverOldYearLevel = '{{ old('year_level') }}';
const LS_KEY = 'reg_draft';

function saveDraft(){
    localStorage.setItem(LS_KEY, JSON.stringify({
        name:       document.querySelector('[name="name"]').value,
        email:      document.querySelector('[name="email"]').value,
        program:    document.getElementById('reg-program').value,
        year_level: document.getElementById('reg-year-level').value,
    }));
}
function clearDraft(){ localStorage.removeItem(LS_KEY); }

function updateRegYearLevel(program, restoreYearLevel){
    const select  = document.getElementById('reg-year-level');
    const options = regShs.includes(program) ? regShsOptions : (program ? regCollegeOptions : []);
    select.innerHTML = '<option value="">Select year level</option>';
    options.forEach(function(opt){
        const el = document.createElement('option');
        el.value = opt.value; el.textContent = opt.label;
        if(restoreYearLevel && opt.value === restoreYearLevel) el.selected = true;
        select.appendChild(el);
    });
}

document.addEventListener('DOMContentLoaded', function(){
    const nameInput  = document.querySelector('[name="name"]');
    const emailInput = document.querySelector('[name="email"]');
    const progSelect = document.getElementById('reg-program');
    const yearSelect = document.getElementById('reg-year-level');
    const consentBox = document.getElementById('privacy_consent');
    const submitBtn  = document.getElementById('submit-btn');

    let restoreProgram = serverOldProgram || '';
    let restoreYear    = serverOldYearLevel || '';

    const draft = localStorage.getItem(LS_KEY);
    if(draft){
        try{
            const d = JSON.parse(draft);
            if(!restoreProgram && d.program)    restoreProgram = d.program;
            if(!restoreYear    && d.year_level) restoreYear    = d.year_level;
            if(!nameInput.value  && d.name)     nameInput.value  = d.name;
            if(!emailInput.value && d.email)    emailInput.value = d.email;
        }catch(e){}
    }

    if(restoreProgram) progSelect.value = restoreProgram;
    if(progSelect.value) updateRegYearLevel(progSelect.value, restoreYear);

    nameInput.addEventListener('input', saveDraft);
    emailInput.addEventListener('input', saveDraft);
    progSelect.addEventListener('change', function(){ updateRegYearLevel(this.value,''); saveDraft(); });
    yearSelect.addEventListener('change', saveDraft);

    function syncBtn(){
        submitBtn.disabled    = !consentBox.checked;
        submitBtn.style.opacity = consentBox.checked ? '1' : '.5';
        submitBtn.style.cursor  = consentBox.checked ? 'pointer' : 'not-allowed';
    }
    consentBox.addEventListener('change', syncBtn);
    syncBtn();

    document.querySelector('form').addEventListener('submit', clearDraft);
});
</script>
</x-student-guest-layout>

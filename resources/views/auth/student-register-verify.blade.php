<x-student-guest-layout>
@section('title', 'Verify Email — Project Jeremiah')

<div class="guest-card-header">
    <div class="guest-icon">✉</div>
    <h1>Verify your email</h1>
    <p>Enter the 6-digit code sent to<br><strong style="color:var(--navy);">{{ $email }}</strong></p>
</div>

@if($errors->any())
    <div class="guest-error">
        @foreach($errors->all() as $error)<div>{{ $error }}</div>@endforeach
    </div>
@endif

@if(session('status'))
    <div class="guest-status">{{ session('status') }}</div>
@endif

<form method="POST" action="{{ route('student.register.verify.post') }}" id="otp-form">
    @csrf
    <input type="hidden" name="otp" id="otp-hidden">

    <div class="otp-row" id="otp-boxes">
        @for($i = 0; $i < 6; $i++)
            <input type="text" maxlength="1" inputmode="numeric" pattern="[0-9]"
                   class="otp-digit" data-index="{{ $i }}" autocomplete="off">
        @endfor
    </div>

    <div class="form-actions" style="border-top:1px solid var(--sky);padding-top:18px;margin-top:4px;">
        <a href="{{ route('student.register') }}" class="btn btn-secondary btn-sm">Back</a>
        <button type="submit" id="verify-btn" class="btn btn-primary"
                disabled style="opacity:.5;cursor:not-allowed;">
            Verify &amp; create account <span>↗</span>
        </button>
    </div>
</form>

<p style="text-align:center;color:var(--muted);font-size:.78rem;margin-top:16px;">
    Didn't receive it? Code expires in <strong>5 minutes</strong>.<br>
    <form method="POST" action="{{ route('student.register.resend') }}" style="display:inline;margin:0;">
        @csrf
        <button type="submit"
                style="background:none;border:none;color:var(--navy);font-weight:700;font-size:.78rem;
                       text-decoration:underline;cursor:pointer;padding:0;margin-top:6px;">
            Resend code
        </button>
    </form>
</p>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const digits = document.querySelectorAll('.otp-digit');
    const hidden = document.getElementById('otp-hidden');
    const btn    = document.getElementById('verify-btn');

    digits.forEach(function (inp, idx) {
        inp.addEventListener('input', function () {
            this.value = this.value.replace(/[^0-9]/g,'').slice(0,1);
            if (this.value && idx < digits.length - 1) digits[idx + 1].focus();
            sync();
        });
        inp.addEventListener('keydown', function (e) {
            if (e.key === 'Backspace' && !this.value && idx > 0) {
                digits[idx - 1].focus(); digits[idx - 1].value = ''; sync();
            }
        });
        inp.addEventListener('paste', function (e) {
            e.preventDefault();
            const p = (e.clipboardData || window.clipboardData).getData('text').replace(/\D/g,'');
            p.split('').slice(0,6).forEach(function(c,i){ if(digits[i]) digits[i].value=c; });
            digits[Math.min(p.length,5)].focus(); sync();
        });
    });

    function sync() {
        const v = Array.from(digits).map(d => d.value).join('');
        hidden.value = v;
        const ok = v.length === 6;
        btn.disabled      = !ok;
        btn.style.opacity = ok ? '1' : '.5';
        btn.style.cursor  = ok ? 'pointer' : 'not-allowed';
    }

    digits[0].focus();
});
</script>

</x-student-guest-layout>

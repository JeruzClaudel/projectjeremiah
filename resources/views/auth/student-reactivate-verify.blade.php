<x-student-guest-layout>
@section('title', 'Enter Reactivation Code')

<div class="student-auth-card">

    <div class="student-auth-header">
        <div class="brand-icon"><i class="fas fa-key"></i></div>
        <h1>Enter Your Code</h1>
        <p>6-digit code sent to<br><strong style="color:#0a1931;">{{ $email }}</strong></p>
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

    <form method="POST" action="{{ route('student.reactivate.verify.post') }}" id="react-otp-form">
        @csrf
        <input type="hidden" name="email" value="{{ $email }}">
        <input type="hidden" name="otp" id="react-otp-hidden">

        <div class="otp-input-row" id="react-otp-boxes">
            @for($i = 0; $i < 6; $i++)
                <input type="text" maxlength="1" inputmode="numeric" pattern="[0-9]"
                       class="otp-digit react-digit" data-index="{{ $i }}"
                       autocomplete="off">
            @endfor
        </div>

        <button type="submit" class="btn-student-submit" id="react-verify-btn" disabled
                style="opacity:.5;cursor:not-allowed;">
            <i class="fas fa-rotate-right me-2"></i> Reactivate Account
        </button>
    </form>

    <div style="text-align:center;margin-top:20px;">
        <p style="font-size:.8rem;color:#6b7280;margin-bottom:10px;">
            Code expires in <strong>5 minutes</strong>. Max 3 attempts.
        </p>
        <form method="POST" action="{{ route('student.reactivate.resend') }}" style="display:inline;">
            @csrf
            <input type="hidden" name="email" value="{{ $email }}">
            <button type="submit"
                    style="background:none;border:none;color:#0a1931;font-size:.82rem;
                           font-weight:700;text-decoration:underline;cursor:pointer;padding:0;">
                Resend Code
            </button>
        </form>
    </div>

    <div style="text-align:center;margin-top:16px;padding-top:14px;border-top:1px solid #f3f4f6;">
        <a href="{{ route('student.reactivate.request') }}" style="font-size:.78rem;color:#9ca3af;text-decoration:none;">
            <i class="fas fa-arrow-left me-1"></i> Use a different email
        </a>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const digits = document.querySelectorAll('.react-digit');
    const hidden = document.getElementById('react-otp-hidden');
    const btn    = document.getElementById('react-verify-btn');

    digits.forEach(function (input, idx) {
        input.addEventListener('input', function () {
            this.value = this.value.replace(/[^0-9]/g,'').slice(0,1);
            if (this.value && idx < digits.length - 1) digits[idx + 1].focus();
            syncOtp();
        });
        input.addEventListener('keydown', function (e) {
            if (e.key === 'Backspace' && !this.value && idx > 0) {
                digits[idx - 1].focus();
                digits[idx - 1].value = '';
                syncOtp();
            }
        });
        input.addEventListener('paste', function (e) {
            e.preventDefault();
            const pasted = (e.clipboardData || window.clipboardData).getData('text').replace(/\D/g,'');
            pasted.split('').slice(0,6).forEach(function(ch,i){
                if(digits[i]) digits[i].value = ch;
            });
            const last = Math.min(pasted.length, 5);
            digits[last].focus();
            syncOtp();
        });
    });

    function syncOtp() {
        const val = Array.from(digits).map(d => d.value).join('');
        hidden.value = val;
        const full = val.length === 6;
        btn.disabled      = !full;
        btn.style.opacity = full ? '1' : '.5';
        btn.style.cursor  = full ? 'pointer' : 'not-allowed';
    }

    digits[0].focus();
});
</script>
</x-student-guest-layout>

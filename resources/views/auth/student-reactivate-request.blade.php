<x-student-guest-layout>
@section('title', 'Reactivate Account — Project Jeremiah')

<div class="guest-card-header">
    <div class="guest-icon">↺</div>
    <h1>Reactivate your account</h1>
    <p>Enter your registered email to receive a reactivation code</p>
</div>

@if($errors->any())
    <div class="guest-error">
        @foreach($errors->all() as $error)<div>{{ $error }}</div>@endforeach
    </div>
@endif

@if(session('status'))
    <div class="guest-status">{{ session('status') }}</div>
@endif

<form method="POST" action="{{ route('student.reactivate.send') }}">
    @csrf

    <div class="field" style="margin-bottom:18px;">
        <label for="email">Registered email address <span style="color:#dc2626;">*</span></label>
        <input type="email" id="email" name="email" value="{{ old('email') }}"
               placeholder="yourname@students.nu-laguna.edu.ph" required autofocus>
        <span class="field-note">Only @students.nu-laguna.edu.ph and @shs.nu-laguna.edu.ph are accepted.</span>
    </div>

    <div style="background:var(--sky);border:1px solid var(--gold);border-radius:12px;
                padding:13px 16px;margin-bottom:20px;font-size:.8rem;color:var(--navy);">
        A 6-digit code will be sent to your email. Enter it on the next page to reactivate your account.
    </div>

    <div class="form-actions" style="border-top:1px solid var(--sky);padding-top:18px;">
        <a href="{{ route('home') }}" class="btn btn-secondary btn-sm">Back to Home</a>
        <button type="submit" class="btn btn-primary">
            Send code <span>↗</span>
        </button>
    </div>

    <p style="text-align:center;color:var(--muted);font-size:.78rem;margin-top:14px;">
        Don't have an account?
        <a href="{{ route('student.register') }}" style="color:var(--navy);font-weight:700;text-decoration:underline;">Register here</a>
    </p>
</form>

</x-student-guest-layout>

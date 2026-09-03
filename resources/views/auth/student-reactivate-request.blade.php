<x-student-guest-layout>
@section('title', 'Reactivate Account')

<div class="student-auth-card">

    <div class="student-auth-header">
        <div class="brand-icon"><i class="fas fa-rotate-right"></i></div>
        <h1>Reactivate Account</h1>
        <p>Enter your registered email to receive a reactivation code</p>
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

    <form method="POST" action="{{ route('student.reactivate.send') }}">
        @csrf

        <div class="sf-group">
            <label>Registered Email Address <span style="color:#ef4444;">*</span></label>
            <div class="input-wrap">
                <i class="fas fa-envelope"></i>
                <input type="email" name="email" value="{{ old('email') }}"
                       placeholder="yourname@students.nu-laguna.edu.ph" required autofocus>
            </div>
            <small style="font-size:.72rem;color:#9ca3af;">
                Use your NU Laguna student email
                (<strong>@students.nu-laguna.edu.ph</strong> or <strong>@shs.nu-laguna.edu.ph</strong>)
            </small>
            </div>
        </div>

        <div style="background:#fef9e7;border:1px solid rgba(201,162,39,.3);border-radius:9px;
                    padding:11px 14px;margin-bottom:18px;font-size:.78rem;color:#92400e;">
            <i class="fas fa-info-circle me-1"></i>
            A 6-digit code will be sent to your email. Enter it on the next page to reactivate your account.
        </div>

        <button type="submit" class="btn-student-submit">
            <i class="fas fa-paper-plane me-2"></i> Send Reactivation Code
        </button>
    </form>

    <div style="text-align:center;margin-top:16px;padding-top:14px;border-top:1px solid #f3f4f6;">
        <a href="{{ route('home') }}" style="font-size:.78rem;color:#9ca3af;text-decoration:none;">
            <i class="fas fa-arrow-left me-1"></i> Back to Home
        </a>
        &nbsp;·&nbsp;
        <a href="{{ route('student.register') }}" style="font-size:.78rem;color:#9ca3af;text-decoration:none;">
            Register new account
        </a>
    </div>
</div>
</x-student-guest-layout>

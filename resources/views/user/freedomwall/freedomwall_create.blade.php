@extends('layouts.user')
@section('title', 'Share a Concern — e-Hayag')

@section('content')

<div class="page-hero">
    <div class="shell">
        <div class="breadcrumbs">e-Hayag / Share your concern</div>
        <h1>Share your concern</h1>
        <p>You can take your time. There is no need to make your experience sound a certain way — your honest words are enough.</p>
    </div>
</div>

<div class="write-layout">
    <div class="shell">
        <div class="form-card">

            <div class="notice notice-private">
                <span class="notice-icon">⌾</span>
                <div>
                    <strong>A private space to begin</strong>
                    <p>Your message is for authorized guidance counselors only. Only <strong>@students.nu-laguna.edu.ph</strong> and <strong>@shs.nu-laguna.edu.ph</strong> emails are accepted.</p>
                </div>
            </div>

            <form action="{{ route('freedomwall.store') }}" method="POST">
                @csrf

                <div class="form-grid">
                    {{-- Email --}}
                    <div class="field full">
                        <label for="postName">Your registered student email <span style="color:#dc2626;">*</span></label>
                        <input type="email" id="postName" name="postName"
                               value="{{ old('postName') }}"
                               placeholder="yourname@students.nu-laguna.edu.ph"
                               required>
                        @error('postName')
                            <span class="field-error">{{ $message }}</span>
                            @if(session('deactivated_email'))
                            <div class="field-deactivate-box" style="margin-top:8px;">
                                <p style="font-size:.82rem;color:var(--navy);margin-bottom:8px;font-weight:600;">
                                    Your account is currently deactivated.
                                </p>
                                <a href="{{ route('student.reactivate.request') }}" class="btn btn-primary btn-sm">
                                    Reactivate Account ↗
                                </a>
                            </div>
                            @endif
                        @enderror
                        <span class="field-note">
                            Not registered yet? <a href="{{ route('student.register') }}" style="color:var(--navy);font-weight:700;">Register here</a>
                        </span>
                    </div>

                    {{-- Post --}}
                    <div class="field full">
                        <label for="post">Your concern <span style="color:#dc2626;">*</span></label>
                        <textarea id="post" name="post" placeholder="Share what has been on your mind…" required>{{ old('post') }}</textarea>
                        @error('post')
                            <span class="field-error">{{ $message }}</span>
                        @enderror
                        <span class="field-note">You can write in English or Filipino. Your program and year level are pulled automatically from your account.</span>
                    </div>
                </div>

                <div class="notice notice-emergency" style="margin-bottom:0;">
                    <span class="notice-icon">!</span>
                    <div>
                        <strong>Please do not use e-Hayag for immediate emergencies.</strong>
                        <p>If you are in immediate danger or need urgent help, contact emergency services or visit our <a href="{{ route('user.hotline') }}" style="text-decoration:underline;font-weight:700;color:var(--navy);">Hotlines page</a>.</p>
                    </div>
                </div>

                <div class="form-actions">
                    <a class="btn btn-secondary" href="{{ route('user.freedomwall.add') }}">Back</a>
                    <button class="btn btn-primary" type="submit">Submit concern <span>↗</span></button>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection

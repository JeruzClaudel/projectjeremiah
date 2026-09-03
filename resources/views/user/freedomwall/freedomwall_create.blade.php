@extends('layouts.user')
@section('title', 'e-Hayag — Write a Post')

@section('content')

<div class="ehayag-hero fade-up">
    <div class="ej-icon"><i class="fas fa-pen-to-square"></i></div>
    <h1>Share Your Thoughts</h1>
    <p>Your post is confidential — seen only by guidance counselors who are here to support you.</p>
</div>

<div class="ehayag-form-card fade-up fade-up-d1">
    <form action="{{ route('freedomwall.store') }}" method="POST">
        @csrf

        {{-- Email --}}
        <div class="ef-group">
            <label for="postName">
                Email <span style="color:#ef4444;">*</span>
            </label>
            <input type="email" id="postName" name="postName"
                   class="ef-input"
                   placeholder="Enter your registered student email"
                   value="{{ old('postName') }}"
                   required>
            <span class="ef-helper">
                Only <strong>@students.nu-laguna.edu.ph</strong> and <strong>@shs.nu-laguna.edu.ph</strong> emails are accepted.
                Not registered? <a href="{{ route('student.register') }}">Register here</a>
            </span>
            @error('postName')
                <span class="field-error">{{ $message }}</span>
                @if(session('deactivated_email'))
                    <div class="deactivate-box" style="margin-top:10px;">
                        <p><i class="fas fa-lock me-1"></i>Your account is currently deactivated.</p>
                        <a href="{{ route('student.reactivate.request') }}"
                           style="display:inline-flex;align-items:center;gap:6px;
                                  padding:8px 18px;background:var(--gold);color:var(--navy);
                                  border-radius:8px;font-size:.82rem;font-weight:800;text-decoration:none;">
                            <i class="fas fa-rotate-right"></i> Reactivate My Account
                        </a>
                    </div>
                @endif
            @enderror
        </div>

        {{-- Post content --}}
        <div class="ef-group">
            <label for="post">Your Message <span style="color:#ef4444;">*</span></label>
            <textarea id="post" name="post"
                      class="ef-input ef-textarea"
                      placeholder="Express yourself freely — no filters needed. This is your safe space."
                      required>{{ old('post') }}</textarea>
            @error('post')
                <span class="field-error">{{ $message }}</span>
            @enderror
        </div>

        <div class="info-box" style="margin-bottom:18px;font-size:.8rem;">
            <i class="fas fa-shield-halved me-1"></i>
            Everything you write here is private. Only your guidance counselors will read it.
        </div>

        <button type="submit" class="ef-submit">
            <i class="fas fa-paper-plane me-2"></i> Submit
        </button>
    </form>
</div>

@endsection

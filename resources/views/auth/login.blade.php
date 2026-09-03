<x-guest-layout>

    {{-- Session status --}}
    @if (session('status'))
    <div class="lf-status">
        <i class="fas fa-circle-check" style="margin-right:5px;"></i>
        {{ session('status') }}
    </div>
    @endif

    {{-- Error banner --}}
    @if ($errors->any())
    <div class="lf-err-banner">
        <i class="fas fa-circle-exclamation" style="flex-shrink:0;margin-top:1px;"></i>
        <div>
            @foreach ($errors->all() as $error)
                <div>{{ $error }}</div>
            @endforeach
        </div>
    </div>
    @endif

    <form method="POST" action="{{ route('login') }}">
        @csrf

        {{-- Email --}}
        <div class="lf-group">
            <label for="email">Email Address</label>
            <div class="lf-input-wrap">
                <i class="fas fa-envelope"></i>
                <input type="email" id="email" name="email"
                       value="{{ old('email') }}"
                       placeholder="admin@example.com"
                       required autofocus autocomplete="username">
            </div>
        </div>

        {{-- Password --}}
        <div class="lf-group">
            <label for="password">Password</label>
            <div class="lf-input-wrap">
                <i class="fas fa-lock"></i>
                <input type="password" id="password" name="password"
                       placeholder="••••••••"
                       required autocomplete="current-password">
                <button type="button" class="pw-toggle" onclick="togglePassword()" id="pw-toggle-btn" title="Show/hide password">
                    <i class="fas fa-eye" id="pw-icon"></i>
                </button>
            </div>
        </div>

        {{-- Remember + Forgot --}}
        <div class="lf-row">
            <label class="lf-remember">
                <input type="checkbox" name="remember" id="remember_me">
                Remember me
            </label>
            @if (Route::has('password.request'))
            <a href="{{ route('password.request') }}" class="lf-forgot">
                Forgot password?
            </a>
            @endif
        </div>

        <button type="submit" class="btn-login">
            <i class="fas fa-arrow-right-to-bracket" style="margin-right:8px;"></i>
            Sign In
        </button>
    </form>

</x-guest-layout>

<script>
function togglePassword() {
    const input = document.getElementById('password');
    const icon  = document.getElementById('pw-icon');
    if (input.type === 'password') {
        input.type = 'text';
        icon.className = 'fas fa-eye-slash';
    } else {
        input.type = 'password';
        icon.className = 'fas fa-eye';
    }
}
</script>

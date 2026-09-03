<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Mail\RegistrationOtpMail;
use App\Models\OtpVerification;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Validation\Rules\Password;

class StudentAuthController extends Controller
{
    public function showRegister()
    {
        return view('auth.student-register');
    }

    public function register(Request $request)
    {
        $request->validate([
            'name'            => ['required', 'string', 'max:255'],
            'program'         => ['required', 'string', 'max:100'],
            'year_level'      => ['required', 'string', 'max:100'],
            'email'           => [
                'required', 'string', 'lowercase', 'email', 'max:255',
                'unique:users,email',
                function ($attribute, $value, $fail) {
                    $allowed = ['@students.nu-laguna.edu.ph', '@shs.nu-laguna.edu.ph'];
                    $v = strtolower($value);
                    $valid = false;
                    foreach ($allowed as $domain) {
                        if (str_ends_with($v, $domain)) { $valid = true; break; }
                    }
                    if (! $valid) {
                        $fail('Please use your NU Laguna student email (@students.nu-laguna.edu.ph or @shs.nu-laguna.edu.ph).');
                    }
                },
            ],
            'password'        => ['required', 'confirmed', Password::defaults()],
            'privacy_consent' => ['accepted'],
        ], [
            'privacy_consent.accepted' => 'You must read and accept the Privacy Notice to register.',
        ]);

        $email = strtolower(trim($request->email));

        OtpVerification::where('email', $email)->where('used', false)->update(['used' => true]);

        $otp = str_pad(random_int(0, 999999), 6, '0', STR_PAD_LEFT);

        OtpVerification::create([
            'email'      => $email,
            'otp'        => hash('sha256', $otp),
            'expires_at' => now()->addMinutes(5),
            'used'       => false,
            'attempts'   => 0,
            'sent_at'    => now(),
        ]);

        session([
            'pending_registration' => [
                'name'       => $request->name,
                'program'    => $request->program,
                'year_level' => $request->year_level,
                'email'      => $email,
                'password'   => Hash::make($request->password),
            ],
        ]);

        try {
            Mail::to($email)->send(new RegistrationOtpMail($otp, $request->name));
        } catch (\Exception $e) {
            Log::error('Registration OTP email failed: ' . $e->getMessage());
            return back()->withErrors(['email' => 'Failed to send verification email. Please try again.']);
        }

        return redirect()->route('student.register.verify')
            ->with('status', 'A verification code has been sent to your email.');
    }

    public function showRegisterVerify()
    {
        if (! session('pending_registration')) {
            return redirect()->route('student.register')
                ->withErrors(['email' => 'Session expired. Please fill in the registration form again.']);
        }

        return view('auth.student-register-verify', [
            'email' => session('pending_registration.email', ''),
        ]);
    }

    public function verifyRegisterOtp(Request $request)
    {
        $request->validate(['otp' => ['required', 'string', 'size:6']]);

        $pending = session('pending_registration');

        if (! $pending) {
            return redirect()->route('student.register')
                ->withErrors(['email' => 'Session expired. Please register again.']);
        }

        $email = $pending['email'];
        $otp   = trim($request->otp);

        $record = OtpVerification::where('email', $email)
            ->where('used', false)->latest()->first();

        if (! $record) {
            return back()->withErrors(['otp' => 'No active code found. Please request a new one.']);
        }

        if ($record->expires_at->isPast()) {
            $record->update(['used' => true]);
            return back()->withErrors(['otp' => 'Your code has expired. Please request a new one.']);
        }

        if ($record->attempts >= 3) {
            $record->update(['used' => true]);
            return back()->withErrors(['otp' => 'Too many incorrect attempts. Please request a new code.']);
        }

        if (! hash_equals($record->otp, hash('sha256', $otp))) {
            $record->increment('attempts');
            $remaining = 3 - $record->fresh()->attempts;
            return back()->withErrors(['otp' => "Incorrect code. {$remaining} attempt(s) remaining."]);
        }

        $record->update(['used' => true]);

        $user = User::create([
            'name'       => $pending['name'],
            'program'    => $pending['program'],
            'year_level' => $pending['year_level'],
            'email'      => $pending['email'],
            'password'   => $pending['password'],
            'roles'      => 'user',
            'is_active'  => true,
        ]);

        event(new Registered($user));
        session()->forget('pending_registration');

        return redirect()->route('home')
            ->with('status', 'Account created successfully! You can now use your email to submit e-Hayag posts.');
    }

    public function resendRegisterOtp(Request $request)
    {
        $pending = session('pending_registration');

        if (! $pending) {
            return redirect()->route('student.register')
                ->withErrors(['email' => 'Session expired. Please register again.']);
        }

        $email = $pending['email'];

        $existing = OtpVerification::where('email', $email)
            ->where('used', false)->latest()->first();

        if ($existing && $existing->sent_at && $existing->sent_at->diffInSeconds(now()) < 60) {
            $wait = 60 - $existing->sent_at->diffInSeconds(now());
            return back()->withErrors(['otp' => "Please wait {$wait} seconds before requesting a new code."]);
        }

        OtpVerification::where('email', $email)->where('used', false)->update(['used' => true]);

        $otp = str_pad(random_int(0, 999999), 6, '0', STR_PAD_LEFT);

        OtpVerification::create([
            'email'      => $email,
            'otp'        => hash('sha256', $otp),
            'expires_at' => now()->addMinutes(5),
            'used'       => false,
            'attempts'   => 0,
            'sent_at'    => now(),
        ]);

        try {
            Mail::to($email)->send(new RegistrationOtpMail($otp, $pending['name']));
        } catch (\Exception $e) {
            return back()->withErrors(['otp' => 'Failed to resend. Please try again.']);
        }

        return back()->with('status', 'A new code has been sent to your email.');
    }
}

<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Mail\StudentOtpMail;
use App\Models\OtpVerification;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class StudentReactivateController extends Controller
{
    public function showRequest()
    {
        return view('auth.student-reactivate-request');
    }

    public function sendOtp(Request $request)
    {
        $request->validate([
            'email' => [
                'required', 'email',
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
        ]);

        $email   = strtolower(trim($request->email));
        $student = User::where('email', $email)->where('roles', 'user')->first();

        if (! $student) {
            return back()->withErrors(['email' => 'If this email is registered, a code has been sent.']);
        }

        if ($student->is_active) {
            return back()->withErrors(['email' => 'Your account is already active.']);
        }

        $existing = OtpVerification::where('email', $email)
            ->where('used', false)->latest()->first();

        if ($existing && $existing->sent_at && $existing->sent_at->diffInSeconds(now()) < 60) {
            $wait = 60 - $existing->sent_at->diffInSeconds(now());
            return back()->withErrors(['email' => "Please wait {$wait} seconds before requesting a new code."]);
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
            Mail::to($email)->send(new StudentOtpMail($otp, $student->name));
        } catch (\Exception $e) {
            Log::error('Reactivation OTP email failed: ' . $e->getMessage());
            return back()->withErrors(['email' => 'Failed to send the code. Please try again.']);
        }

        session(['otp_email' => $email]);

        return redirect()->route('student.reactivate.verify')
            ->with('status', 'A 6-digit code has been sent to your email. It expires in 5 minutes.');
    }

    public function showVerify()
    {
        return view('auth.student-reactivate-verify', [
            'email' => session('otp_email', ''),
        ]);
    }

    public function verifyOtp(Request $request)
    {
        $request->validate([
            'email' => ['required', 'email'],
            'otp'   => ['required', 'string', 'size:6'],
        ]);

        $email  = strtolower(trim($request->email));
        $otp    = trim($request->otp);
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

        $student = User::where('email', $email)->where('roles', 'user')->first();
        if ($student) {
            $student->update(['is_active' => true]);
        }

        session()->forget('otp_email');

        return redirect()->route('home')
            ->with('status', 'Your account has been reactivated. You can now submit e-Hayag posts.');
    }

    public function resendOtp(Request $request)
    {
        return $this->sendOtp($request);
    }
}

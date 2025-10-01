<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Notification;
use App\Notifications\EmailVerification;

class ForgotPasswordController extends Controller
{
    // Step 1: Show forgot password form
    public function showForgotForm()
    {
        return view('auth.forgot-password');
    }

    // Step 2: Send OTP to email
    public function sendResetOtp(Request $request)
    {
        $request->validate([
            'email' => 'required|email|exists:users,email'
        ]);

        $user = User::where('email', $request->email)->first();

        $otp = rand(100000, 999999);

        session([
            'reset_password' => [
                'user_id' => $user->id,
                'otp' => $otp,
                'expires_at' => now()->addMinutes(10)
            ]
        ]);

        // OTP Email পাঠানো
        Notification::route('mail', $user->email)->notify(new EmailVerification($otp));

        return redirect()->route('forgot.otp.form')->with('success', 'We have sent an OTP to your email.');
    }

    // Step 3: Show OTP form
    public function showOtpForm()
    {
        return view('auth.forgot-password-otp');
    }

    // Step 4: Verify OTP
    public function verifyOtp(Request $request)
    {
        $request->validate([
            'otp' => 'required|numeric',
        ]);

        $user = User::where('email', session('reset_password_email'))->first();

        if (!$user || $user->otp !== $request->otp || now()->greaterThan($user->otp_expires_at)) {
            return back()->withErrors(['otp' => 'Invalid or expired OTP']);
        }

        // OTP valid হলে reset
        $user->otp = null;
        $user->otp_expires_at = null;
        $user->email_verified_at = now();
        $user->save();

        Auth::login($user);

        // 👉 Role check করে আলাদা dashboard এ পাঠানো
        if ($user->role === 'agent') {
            return redirect()->route('agent.dashboard')->with('success', 'Welcome Agent!');
        } else {
            return redirect()->route('user.dashboard')->with('success', 'Welcome User!');
        }
    }
}

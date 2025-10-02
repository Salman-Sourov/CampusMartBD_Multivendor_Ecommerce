<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Notification;
use App\Notifications\EmailVerification;
use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Mail;
use App\Mail\VerifyEmailMail;

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

        $verification_code = rand(100000, 999999);

        session([
            'temp_user' => [
                'user_id' => $user->id,
                'verification_code' => $verification_code,
                'name' => $user->name,
                'email' => $user->email,
                'role' => $user->role,
                'expires_at' => now()->addMinutes(10)
            ]
        ]);

        // Notification::route('mail', $user->email)->notify(new EmailVerification($otp));
        // return redirect()->route('forgot.otp.form')->with('success', 'We have sent an OTP to your email.');

         // Send OTP email using custom Mailable
        Mail::to($request->email)->send(new VerifyEmailMail($verification_code));
        return redirect()->route('verify.email')->with('success', 'We sent an OTP to your email. Please verify.');
    }
}

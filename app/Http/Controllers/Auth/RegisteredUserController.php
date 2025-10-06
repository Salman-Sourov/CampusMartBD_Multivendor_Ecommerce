<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Notification;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Mail;
use App\Mail\VerifyEmailMail;


class RegisteredUserController extends Controller
{
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email'],
            'phone' => [
                'required',
                'string',
                'max:14',
                'unique:users,phone',
                'regex:/^\+8801[3-9][0-9]{8}$/'
            ],
            'password' => ['required', 'string', 'min:6'],
        ], [
            'name.required' => 'Please enter your full name.',
            'email.required' => 'Please enter your email address.',
            'email.email' => 'Please enter a valid email address.',
            'email.unique' => 'This email address is already registered.',
            'phone.required' => 'Please enter a phone number.',
            'phone.regex' => 'Please enter a valid Bangladeshi phone number (e.g., +8801XXXXXXXXX).',
            'phone.unique' => 'This phone number is already registered.',
            'password.required' => 'Please enter a password.',
            'password.min' => 'The password must be at least 6 characters long.',
            // 'password.confirmed' => 'The password confirmation does not match.',
        ]);

        $verification_code = rand(100000, 999999);

        // Save user temporarily in session
        session([
            'temp_user' => [
                'name' => $request->name,
                'email' => $request->email,
                'phone' => $request->phone,
                'password' => Hash::make($request->password),
                'verification_code' => $verification_code,
                'role' => 'user',
                'status' => 'active',
                'expires_at' => now()->addMinutes(10),
            ]
        ]);

        // Send OTP email using custom Mailable
        // Mail::to($request->email)->send(new VerifyEmailMail($verification_code));
        // return redirect()->route('verify.email')->with('success', 'We sent an OTP to your email. Please verify.');

        /**
         * ✅ Instead of waiting for Mail::send (which blocks),
         * use dispatch() to send asynchronously.
         */
        Mail::to($request->email)
            ->queue(new VerifyEmailMail($verification_code));
        // dispatch(function () use ($email, $verification_code) {
        //     Mail::to($email)->send(new VerifyEmailMail($verification_code));
        // });

        /**
         * ✅ Instantly redirect to verify page
         * No waiting for mail server response → smooth UX
         */
        return redirect()
            ->route('verify.email')
            ->with('success', 'We sent an OTP to your email. Please verify.');
    }

    public function resendOtp(Request $request)
    {
        if (!session()->has('temp_user')) {
            return redirect()->route('register')->with('error', 'Please register first.');
        }

        $tempUser = session('temp_user');
        $verification_code = rand(100000, 999999);

        // Update session with new OTP
        $tempUser['verification_code'] = $verification_code;
        $tempUser['expires_at'] = now()->addMinutes(10);
        session(['temp_user' => $tempUser]);

        // Send mail again
        // \Notification::route('mail', $tempUser['email'])
        //     ->notify(new \App\Notifications\EmailVerification($verification_code));
        // return back()->with('success', 'A new OTP has been sent to your email.');

        // ✅ Reuse same async pattern
        Mail::to($tempUser['email'])
            ->queue(new VerifyEmailMail($verification_code));

        return back()->with('success', 'A new OTP has been sent to your email.');
    }
}

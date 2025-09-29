<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Http\RedirectResponse;

class VerifyEmailController extends Controller
{
    // Show OTP verification form
    public function showVerifyForm()
    {
        return view('auth.verify');
    }

    // Handle OTP submission
    public function verifyCode(Request $request): RedirectResponse
    {
        $request->validate([
            'verification_code' => 'required',
        ]);

        $temp_user = session('temp_user');
        $attempts = session('otp_attempts', 0);

        if (!$temp_user) {
            return redirect()->route('register')->with('error', 'Session expired. Please register again.');
        }

        if ($attempts >= 3) {
            session()->forget('temp_user');
            session()->forget('otp_attempts');
            return redirect()->route('register')->with('error', 'Maximum attempts reached. Please register again.');
        }

        if ($request->verification_code == $temp_user['verification_code']) {
            // OTP success → save user in DB
            User::create([
                'name' => $temp_user['name'],
                'email' => $temp_user['email'],
                'phone' => $temp_user['phone'],
                'password' => $temp_user['password'],
                'email_verified_at' => now(),
            ]);

            session()->forget('temp_user');
            session()->forget('otp_attempts');

            return redirect()->route('index')->with('success', 'Email verified successfully!');
        } else {
            session(['otp_attempts' => $attempts + 1]);
            return back()->with('error', 'Invalid OTP. Please try again.');
        }
    }
}

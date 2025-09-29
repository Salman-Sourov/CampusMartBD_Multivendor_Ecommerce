<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class VerifyEmailController extends Controller
{
    // OTP form দেখাবে
    public function showVerifyForm()
    {
        return view('auth.verify');
    }

    // OTP validate করবে
    public function verifyCode(Request $request)
    {
        $request->validate(['otp' => 'required|digits:6']);

        $temp_user = session('temp_user');
        $otp_attempts = session('otp_attempts', 0);

        if (!$temp_user) {
            return redirect()->route('register')->with('error', 'Session expired, please register again.');
        }

        if ($otp_attempts >= 3) {
            session()->forget(['temp_user', 'otp_attempts']);
            return redirect()->route('register')->with('error', 'Maximum attempts reached.');
        }

        if ($request->otp == $temp_user['verification_code']) {
            User::create([
                'name' => $temp_user['name'],
                'email' => $temp_user['email'],
                'phone' => $temp_user['phone'],
                'password' => $temp_user['password'],
                'role' => 'user',
            ]);
            session()->forget(['temp_user', 'otp_attempts']);
            return redirect('/')->with('success', 'Registration successful.');
        } else {
            session(['otp_attempts' => $otp_attempts + 1]);
            return back()->with('error', 'OTP is incorrect.');
        }
    }
}

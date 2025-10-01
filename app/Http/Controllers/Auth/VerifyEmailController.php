<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class VerifyEmailController extends Controller
{
    public function showVerifyForm()
    {
        return view('auth.verify');
    }

    // OTP validate kore DB te insert korbe
    public function verifyCode(Request $request)
    {
        $request->validate([
            'code' => 'required|string',
        ]);

        $tempUser = session('temp_user');

        if (!$tempUser) {
            return redirect()->route('register')->with('error', 'Session expired. Please register again.');
        }

        if ($request->code == $tempUser['verification_code']) {
            // User save on DB
            $user = User::create([
                'name' => $tempUser['name'],
                'email' => $tempUser['email'],
                'phone' => $tempUser['phone'],
                'password' => $tempUser['password'],
                'role' => $tempUser['role'],
                'status' => $tempUser['status'],
                'email_verified_at' => now(),
            ]);

            // Session clean
            session()->forget('temp_user');

            //User login
            Auth::login($user);

            return redirect('/')->with('success', 'Email verified successfully!');
        } else {
            return back()->withErrors(['code' => 'Invalid OTP code']);
        }
    }
}

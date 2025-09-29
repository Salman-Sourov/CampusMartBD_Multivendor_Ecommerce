<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use App\Notifications\EmailVerification;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Notification;

class RegisteredUserController extends Controller
{
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email'],
            'phone' => ['required', 'string', 'max:255', 'unique:users,phone'],
            'password' => ['required'],
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
            ],
            'otp_attempts' => 0
        ]);

        // Send OTP email
        $user_email = $request->email;
        Notification::route('mail', $user_email)->notify(new EmailVerification($verification_code));

        return redirect()->route('verify.email');
    }
}

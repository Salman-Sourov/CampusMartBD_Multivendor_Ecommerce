<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use App\Models\Brand;
use App\Models\Product_category;
use App\Models\Product;
use Illuminate\Support\Facades\Mail;
use App\Mail\EmailVerification;
use Illuminate\Support\Facades\Notification;
use Illuminate\Http\RedirectResponse;
use App\Mail\VerifyEmailMail;

class AgentController extends Controller
{
    public function AgentRegisterShow()
    {

        return view('frontend.agent_register');
    }

    public function AgentRegister(Request $request)
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
                'role' => 'agent',
                'status' => 'inactive',
                'expires_at' => now()->addMinutes(10),
            ]
        ]);

        // Send OTP email using custom Mailable
        Mail::to($request->email)->queue(new VerifyEmailMail($verification_code));

        return redirect()->route('verify.email')->with('success', 'We sent an OTP to your email. Please verify.');
    }

    public function AgentDashboard()
    {
        return view('agent.index');
    }

    public function AgentLogout(Request $request)
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        $notification = [
            'message' => 'Agent Successfully Logout',
            'alert-type' => 'success',
        ];

        return redirect('/')->with($notification);
    }
}

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
        $existingUser = User::where('email', $tempUser['email'])->first();

        if (!$tempUser) {
            return redirect()->route('register')->with('error', 'Session expired. Please register again.');
        }

        if ($request->code == $tempUser['verification_code']) {

            // User save on DB
            if ($existingUser) {
                $existingUser->email_verified_at = now();
                $existingUser->save();

                Auth::login($existingUser);

                if ($existingUser->role === 'agent') {
                    return redirect()->route('agent.change.password')->with('success', 'Welcome Agent!');
                } else {
                    return redirect()->route('user.dashboard')->with('success', 'Welcome User!');
                }
            } else {
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

                // Registration case → role wise redirect
                if ($user->role === 'agent') {
                    return redirect()->route('agent.dashboard')->with('success', 'Welcome Agent!');
                } else {
                    return redirect('/')->with('success', 'Welcome User!');
                }
            }
        } else {
            return back()->withErrors(['code' => 'Invalid OTP code']);
        }
    }
}

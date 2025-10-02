<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Providers\RouteServiceProvider;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use App\Models\Brand;
use App\Models\Product;
use App\Models\Product_category;
use App\Models\User;
use Hash;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     */
    public function create(): View
    {
        return view('auth.login');
    }

    /**
     * Handle an incoming authentication request.
     */
    public function store(LoginRequest $request): RedirectResponse
    {
        // Validate Input
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|string',
        ]);

        // Check if email exists
        $user = User::where('email', $request->email)->first();

        if (!$user) {
            return back()->withErrors(['email' => 'This email is not registered. Please create an account.'])->withInput();
        }

        // Check password
        if (!\Hash::check($request->password, $user->password)) {
            return back()->withErrors(['password' => 'Wrong password, please try again.'])->withInput();
        }

        // If everything is ok → login the user
        Auth::login($user);
        $request->session()->regenerate();

        $notification = '';

        // Redirect by role
        if ($user->role === 'admin') {
            return redirect()->intended('admin/dashboard')->with('success', 'Welcome Admin!');
        } elseif ($user->role === 'agent') {
            return redirect()->intended('agent/dashboard')->with('success', 'Welcome Agent!');
        } else {
            return redirect()->intended('/')->with('success', 'Welcome User!');
        }
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/');
    }
}

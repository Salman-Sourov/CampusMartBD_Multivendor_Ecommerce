<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;
use Illuminate\Validation\Rules\Password;
use App\Models\Brand;
use App\Models\Product;
use App\Models\Product_category;
use Illuminate\Support\Facades\Mail;
use App\Mail\EmailVerification;


class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        $categories = Product_category::with('translations')->where('status', 'active')->get();
        $brands = Brand::with('translations')->where('status', 'active')->get();
        $products = Product::with('translations', 'inventory_stocks')->where('status', 'active')->get();
        return view('auth.register', compact('categories', 'brands', 'products'));
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    // public function store(Request $request): RedirectResponse
    // {
    //     $request->validate([
    //         'name' => ['required', 'string', 'max:255'],
    //         'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email'], // Ensure 'email' uniqueness
    //         'phone' => ['required', 'string', 'max:255', 'unique:users,phone'], // Ensure 'phone' uniqueness
    //         'password' => ['required'],
    //     ]);

    //     $verification_code = rand(100000, 999999);

    //     $user = User::create([
    //         'name' => $request->name,
    //         'email' => $request->email,
    //         'phone' => $request->phone,
    //         'role' => 'user',
    //         'password' => Hash::make($request->password),
    //     ]);

    //     // Send code email
    //     Mail::to($user->email)->send(new \App\Mail\EmailVerification($verification_code));

    //     // Redirect to verify page
    //     return redirect()->route('verify.email')->with('user_id', $user->id);

    //     // event(new Registered($user));

    //     // Auth::login($user);

    //     // return redirect()->route('index');
    // }

    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email'],
            'phone' => ['required', 'string', 'max:255', 'unique:users,phone'],
            'password' => ['required'],
        ]);

        $verification_code = rand(100000, 999999);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'role' => 'user',
            'password' => Hash::make($request->password),
            'verification_code' => $verification_code, // <-- save code
        ]);

        // Send code email
        Mail::to($user->email)->send(new EmailVerification($verification_code));

        // Redirect to verify page
        return redirect()->route('verify.email')->with('user_id', $user->id);
    }
}

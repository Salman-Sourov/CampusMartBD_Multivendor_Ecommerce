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

class AgentController extends Controller
{
    public function AgentRegisterShow()
    {
        // $categories = Product_category::with('translations', 'hasChild')
        //     ->where('level', '1')
        //     ->where('status', 'active')
        //     ->get();
        // $brands = Brand::with('translations')->where('status', 'active')->get();
        // $products = Product::with('translations', 'inventory_stocks', 'brands', 'categories')
        //     ->where('status', 'active')
        //     ->where('is_featured', '0')
        //     ->inRandomOrder()
        //     ->latest()
        //     ->get();
        $carts = session()->get('cart');

        return view('frontend.agent_register', compact( 'carts'));
    }

    public function AgentRegister(Request $request)
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
            'password' => Hash::make($request->password),
            'role' => 'agent',
            'status' => 'inactive',
            'verification_code' => $verification_code,
        ]);

        // Send code via email
        Mail::to($user->email)->send(new EmailVerification($verification_code, $user));

        // Redirect to verify page with session
        return redirect()->route('verify.email')->with('user_id', $user->id);
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

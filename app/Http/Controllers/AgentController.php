<?php

namespace App\Http\Controllers;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Auth\Events\Registered;
use App\Providers\RouteServiceProvider;
use Illuminate\Http\Request;
use App\Models\Brand;
use App\Models\Product_category;
use App\Models\Product;

class AgentController extends Controller
{
    public function AgentRegisterShow(){
        $categories = Product_category::with('translations', 'hasChild')->where('level', '1')->where('status', 'active')->get();
        $brands = Brand::with('translations')->where('status', 'active')->get();
        $products = Product::with('translations', 'inventory_stocks', 'brands', 'categories')->where('status', 'active')->where('is_featured', '0')->inRandomOrder()->latest()->get();
        $carts = session()->get('cart'); // Default to an empty array if no cart exists
        // dd($products);
        return view('frontend.agent_register', compact('categories', 'brands', 'products', 'carts'));
    }

    public function AgentRegister(Request $request){

        $request->validate([
        'name' => ['required', 'string', 'max:255'],
        'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email'], // Ensure 'email' uniqueness
        'phone' => ['required', 'string', 'max:255', 'unique:users,phone'], // Ensure 'phone' uniqueness
        'password' => ['required'],
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'password' => Hash::make($request->password),
            'role' => 'agent',
            'status' => 'inactive',
        ]);

        event(new Registered($user));

        Auth::login($user);

        return redirect(RouteServiceProvider::AGENT);
    }

    public function AgentDashboard() {
        return view('agent.index');
    }

    public function AgentLogout(Request $request){
        Auth::guard('web')->logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        $notification = array(
            'message' => 'Agent Succesfully Logout',
            'alert-type' => 'success'
        );

        return redirect('/')->with($notification);
    }

}

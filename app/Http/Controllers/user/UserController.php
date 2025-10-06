<?php

namespace App\Http\Controllers\user;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Symfony\Component\HttpFoundation\RedirectResponse;
use App\Models\Product_category;
use App\Models\Brand;
use App\Models\Product;
use App\Models\Order;

class UserController extends Controller
{

    public function userDashboard()
    {
        $categories = Product_category::with('translations', 'hasChild')->where('level', '1')->where('status', 'active')->get();
        $brands = Brand::with('translations')->where('status', 'active')->get();
        $products = Product::with('translations', 'inventory_stocks', 'brands', 'categories')->where('status', 'active')->latest()->get();
        $auth = Auth::user();

        $orders = Order::with('product')->where('user_id',$auth->id)->orderBy('created_at', 'desc')->get();
        // dd($orders);

        return view('frontend.user_dashboard',compact('categories','brands','products','auth','orders'));
    }
    public function userLogout(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
}

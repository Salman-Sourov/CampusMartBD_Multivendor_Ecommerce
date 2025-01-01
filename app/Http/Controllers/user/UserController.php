<?php

namespace App\Http\Controllers\user;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Symfony\Component\HttpFoundation\RedirectResponse;
use App\Models\Product_category;
use App\Models\Brand;
use App\Models\product;

class UserController extends Controller
{
    public function home()
    {
        $categories = Product_category::with('translations')->where('status', 'active')->get();
        $brands = Brand::with('translations')->where('status', 'active')->get();
        $products = Product::with('translations', 'inventory_stocks')->where('status', 'active')->get();
        return view('frontend.index', compact('categories', 'brands', 'products'));
    }
    public function index()
    {
        $categories = Product_category::with('translations')->where('status', 'active')->get();
        $brands = Brand::with('translations')->where('status', 'active')->get();
        $products = Product::with('translations', 'inventory_stocks')->where('status', 'active')->get();
        return view('index', compact('categories', 'brands', 'products'));
    }

    public function userLogout(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
}

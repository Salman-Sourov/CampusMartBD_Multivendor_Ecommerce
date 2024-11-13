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

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     */
    public function create(): View
    {
        $categories = Product_category::with('translations')->where('status','active')->get();
        $brands = Brand::with('translations')->where('status','active')->get();
        $products = Product::with('translations','inventory_stocks')->where('status','active')->get();
        return view('auth.login',compact('categories','brands','products'));
    }

    /**
     * Handle an incoming authentication request.
     */
    public function store(LoginRequest $request): RedirectResponse
    {
        $request->authenticate();

        $request->session()->regenerate();

        // $notification = array(
        //     'message' => ''.$username.' Login Successfully',
        //     'alert-type' => 'success'
        // );

        $notification = '';

        $url = '';
        if($request->user()->role === 'admin'){
            $url = 'admin/dashboard';
        }
        elseif($request->user()->role === 'user'){
            $url = 'user';
        }
       
        return redirect()->intended($url)->with($notification);
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

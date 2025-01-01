<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class PreserveCart
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle($request, Closure $next)
    {
        // Save cart before login
        if ($request->routeIs('login')) {
            session(['temp_cart' => session('cart', [])]);
        }

        // After response (after login)
        $response = $next($request);

        if (Auth::check() && session()->has('temp_cart')) {
            session(['cart' => session('temp_cart')]);
            session()->forget('temp_cart');
        }

        return $response;
    }
}

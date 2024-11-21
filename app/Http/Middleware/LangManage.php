<?php

namespace App\Http\Middleware;
use App;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class LangManage
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if(session()->has('new_lang'))
        {
            App::setLocale(session()->get('new_lang'));
        }
         
        return $next($request);
    }
}

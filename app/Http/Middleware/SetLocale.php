<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class SetLocale
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (Auth::check()) {
            App::setLocale(Auth::user()->locale ?? config('app.locale'));
        } elseif ($request->hasSession() && $request->session()->has('locale')) {
            App::setLocale($request->session()->get('locale'));
        }

        return $next($request);
    }
}

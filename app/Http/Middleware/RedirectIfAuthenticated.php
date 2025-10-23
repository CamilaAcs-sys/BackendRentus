<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RedirectIfAuthenticated
{
    public function handle(Request $request, Closure $next, ...$guards)
    {
        foreach ($guards as $guard) {
            if (Auth::guard($guard)->check()) {
                // Como es una API, no redirigimos a ninguna vista
                return response()->json(['message' => 'Already authenticated'], 200);
            }
        }

        return $next($request);
    }
}

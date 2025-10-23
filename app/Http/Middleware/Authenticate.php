<?php

namespace App\Http\Middleware;

use Illuminate\Auth\Middleware\Authenticate as Middleware;

class Authenticate extends Middleware
{
    /**
     * Maneja el caso cuando el usuario no está autenticado.
     */
    protected function redirectTo($request)
{
    return $request->expectsJson() ? null : route('login'); // route('login') solo para web
}

}

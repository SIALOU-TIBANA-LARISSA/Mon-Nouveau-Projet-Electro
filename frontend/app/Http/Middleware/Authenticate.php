<?php

namespace App\Http\Middleware;

use Illuminate\Auth\Middleware\Authenticate as Middleware;

class Authenticate extends Middleware
{
    protected function redirectTo($request)
    {
        // Pour les API, ne jamais rediriger vers une route login inexistante
        if (! $request->expectsJson()) {
            return null;
        }
    }
}

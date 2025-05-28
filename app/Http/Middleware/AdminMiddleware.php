<?php

namespace App\Http\Middleware;

use Closure;

class AdminMiddleware
{
    public function handle($request, Closure $next)
    {
        if (!auth()->check() || auth()->user()->rol !== 1) {
            abort(403, 'Acceso no autorizado');
        }
        return $next($request);
    }
}

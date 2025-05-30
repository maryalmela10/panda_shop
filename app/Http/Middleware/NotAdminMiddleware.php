<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class NotAdminMiddleware
{
    public function handle($request, Closure $next)
    {
        if (Auth::check() && Auth::user()->rol == 1) {
            // Puedes redirigir a donde quieras, por ejemplo, al dashboard de admin
            return redirect()->route('home')->with('error', 'Solo los usuarios normales pueden acceder a esta sección');
        }
        return $next($request);
    }
}

<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;

class EnsureEmailIsVerifiedCustom
{
    public function handle(Request $request, Closure $next)
    {
        if (
            !$request->user() ||
            ($request->user() instanceof \Illuminate\Contracts\Auth\MustVerifyEmail &&
            !$request->user()->hasVerifiedEmail())
        ) {
            // Si la solicitud espera JSON, responde con error 403
            if ($request->expectsJson()) {
                return abort(403, 'Tu correo electrónico no está verificado.');
            }
            // Si no, vuelve atrás y muestra mensaje
            return Redirect::back()->with('error', 'Debes verificar tu correo electrónico para acceder.');
        }

        return $next($request);
    }
}

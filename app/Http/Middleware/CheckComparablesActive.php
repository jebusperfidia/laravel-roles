<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class CheckComparablesActive
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next)
    {
        $isActive = Session::get('comparables-active-session');
        $isOnAllowedRoute = $request->routeIs('form.comparables.index', 'logout');

        //  Si la sesión está activa, solo permitimos ciertas rutas
        if ($isActive) {
            if (! $isOnAllowedRoute) {
                return redirect()->route('form.comparables.index');
            }
            return $next($request);
        }

        // Si no está activa pero intenta entrar a la ruta protegida
        if (! $isActive && $request->routeIs('form.comparables.index')) {
            return redirect()->route('dashboard');
        }

        // Si no hay sesión activa y no es una ruta protegida, continúa
        return $next($request);
    }
}

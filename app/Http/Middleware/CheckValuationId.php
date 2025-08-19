<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Redirect;

class CheckValuationId
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Si no existe valuation_id en la sesión
        if (! $request->session()->has('valuation_id')) {
            // Elimina valuation-active-form si está presente
            $request->session()->forget('valuation-active-form');

            // Redirige al dashboard (o la ruta que necesites)
            return Redirect::route('dashboard');
        }

        return $next($request);
    }
}

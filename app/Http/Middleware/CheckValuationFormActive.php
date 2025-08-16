<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Session;

class CheckValuationFormActive
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        //  dd(session('valuation-active-form'));
        /*  dd('El middleware se está ejecutando'); */
        // 1. Verificamos si la sesión 'valuation-active-form' está activa.
        if (Session::get('valuation-active-form')) {

            // 2. Definimos las rutas a las que el usuario puede acceder, incluso con la sesión activa.
            // Estas son las excepciones a la regla de redirección.
            $allowedRoutes = ['form.index', 'logout'];

            // 3. Si el usuario está intentando acceder a una de las rutas permitidas, lo dejamos pasar.
            if ($request->routeIs($allowedRoutes)) {
                return $next($request);
            }

            // 4. Si la sesión está activa y la ruta NO es una de las permitidas,
            // lo redirigimos forzosamente a 'form.index'.
            return redirect()->route('form.index');
        }

        // 5. Si la sesión no está activa en absoluto, lo dejamos pasar a cualquier ruta.
        return $next($request);
    }
}

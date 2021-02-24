<?php

namespace App\Http\Middleware;

use Closure;

class AdministradorMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $trabajador = auth()->user()->Persona->Trabajador;
        if ($trabajador != null) {
            if ($trabajador->Cargo->descripcion == 'ADMINISTRADOR') {                
                return $next($request);
            }
        }
        return redirect('/');
    }
}

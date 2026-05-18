<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;

class EsAdmin
{
    public function handle(Request $request, Closure $next)
    {
        if (Auth::check() && Auth::user()->es_admin) {

            return $next($request);
        }

        return redirect('/')->with('error', 'Acceso denegado. No eres administrador.');
    }
}
<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OptionalAuth
{

    public function handle(Request $request, Closure $next)
    {
        // Tentez d'authentifier l'utilisateur, mais n'échouez pas si aucune authentification
        Auth::shouldUse('sanctum'); // Utilisez le guard approprié
        if ($request->bearerToken()) {
            Auth::authenticate(); // Valide le token uniquement s'il est présent
        }

        return $next($request);
    }
}

<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RoleMiddleware
{
    public function handle(Request $request, Closure $next, $role)
    {
        if (!Auth::check() || Auth::user()->role !== $role) {
            // Optionnel : rediriger vers une page d'erreur ou login
            abort(403, 'Accès non autorisé.');
        }

        return $next($request);
    }
}

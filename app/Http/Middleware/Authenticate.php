<?php

namespace App\Http\Middleware;

use Illuminate\Auth\Middleware\Authenticate as Middleware;

class Authenticate extends Middleware
{
    /**
     * Get the path the user should be redirected to when they are not authenticated.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return string|null
     */
    protected function redirectTo($request)
    {
        if (! $request->expectsJson()) {
            // Si l'utilisateur est connecté mais en attente d'approbation, on le redirige vers la page de statut
            if (auth()->check() && auth()->user()->role === 'entrepreneur_en_attente') {
                if (!$request->routeIs('auth.statut')) {
                    return route('auth.statut');
                }
            }
            return route('login');
        }
    }
}

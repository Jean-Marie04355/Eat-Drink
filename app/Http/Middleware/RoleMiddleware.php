<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RoleMiddleware
{
    public function handle(Request $request, Closure $next, ...$roles)
    {
        if (!Auth::check()) {
            if ($request->ajax() || $request->wantsJson()) {
                return response()->json(['success' => false, 'message' => 'Veuillez vous connecter.'], 401);
            }
            return redirect()->route('login');
        }

        $userRole = Auth::user()->role;

        if ($userRole === 'admin' || in_array($userRole, $roles)) {
            return $next($request);
        }

        if ($request->ajax() || $request->wantsJson()) {
            return response()->json(['success' => false, 'message' => 'Accès non autorisé pour votre profil.'], 403);
        }

        abort(403, 'Accès non autorisé.');
    }
}

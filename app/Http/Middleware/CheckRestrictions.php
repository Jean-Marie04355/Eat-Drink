<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Models\Restriction;
use Carbon\Carbon;

class CheckRestrictions
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        if (auth()->check()) {
            $user = auth()->user();
            
            // Vérifier si l'utilisateur est un entrepreneur
            if ($user->role === 'entrepreneur_approuve') {
                $activeRestriction = Restriction::where('entrepreneur_id', $user->id)
                    ->where('is_active', true)
                    ->where('end_date', '>', now())
                    ->first();

                if ($activeRestriction) {
                    // Calculer le temps restant
                    $daysLeft = now()->diffInDays($activeRestriction->end_date, false);
                    $hoursLeft = now()->diffInHours($activeRestriction->end_date, false);
                    
                    $timeMessage = '';
                    if ($daysLeft > 0) {
                        $timeMessage = "Votre compte sera réactivé dans {$daysLeft} jour(s).";
                    } elseif ($hoursLeft > 0) {
                        $timeMessage = "Votre compte sera réactivé dans {$hoursLeft} heure(s).";
                    } else {
                        $timeMessage = "Votre compte sera réactivé très prochainement.";
                    }

                    // Déconnecter l'utilisateur et rediriger vers la page de restriction
                    auth()->logout();
                    
                    // Préparer les données de la restriction pour la page
                    $restrictionData = [
                        'type' => $activeRestriction->type,
                        'motif' => $activeRestriction->motif,
                        'end_date' => $activeRestriction->end_date,
                        'start_date' => $activeRestriction->start_date,
                        'duration' => $activeRestriction->duration,
                        'admin_id' => $activeRestriction->admin_id,
                    ];
                    
                    return redirect()->route('auth.restriction')->with('restriction', $restrictionData);
                }
            }
        }

        return $next($request);
    }
} 
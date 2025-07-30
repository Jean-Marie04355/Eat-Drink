<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Restriction;
use Carbon\Carbon;

class RestrictionController extends Controller
{
    /**
     * Affiche la page de restriction
     */
    public function show(Request $request)
    {
        // Si une restriction est déjà en session, l'utiliser
        if (session('restriction')) {
            return view('auth.restriction-simple');
        }

        // Vérifier si l'utilisateur a une restriction active via l'email
        $email = $request->query('email');
        if ($email) {
            $user = \App\Models\User::where('email', $email)->first();
            if ($user) {
                $activeRestriction = Restriction::where('entrepreneur_id', $user->id)
                    ->where('is_active', true)
                    ->where('end_date', '>', now())
                    ->first();

                if ($activeRestriction) {
                    $restrictionData = [
                        'type' => $activeRestriction->type,
                        'motif' => $activeRestriction->motif,
                        'end_date' => $activeRestriction->end_date,
                        'start_date' => $activeRestriction->start_date,
                        'duration' => $activeRestriction->duration,
                        'admin_id' => $activeRestriction->admin_id,
                    ];

                    return view('auth.restriction-simple')->with('restriction', $restrictionData);
                }
            }
        }

        // Sinon, rediriger vers la page de connexion
        return redirect()->route('login');
    }

    /**
     * Vérifie si l'utilisateur a une restriction active
     */
    public function checkRestriction(Request $request)
    {
        $email = $request->input('email');
        
        if (!$email) {
            return response()->json(['error' => 'Email requis'], 400);
        }

        // Vérifier si l'utilisateur existe et a une restriction active
        $user = \App\Models\User::where('email', $email)->first();
        
        if (!$user) {
            return response()->json(['has_restriction' => false]);
        }

        $activeRestriction = Restriction::where('entrepreneur_id', $user->id)
            ->where('is_active', true)
            ->where('end_date', '>', now())
            ->first();

        if ($activeRestriction) {
            $restrictionData = [
                'type' => $activeRestriction->type,
                'motif' => $activeRestriction->motif,
                'end_date' => $activeRestriction->end_date,
                'start_date' => $activeRestriction->start_date,
                'duration' => $activeRestriction->duration,
                'admin_id' => $activeRestriction->admin_id,
            ];

            return response()->json([
                'has_restriction' => true,
                'restriction' => $restrictionData
            ]);
        }

        return response()->json(['has_restriction' => false]);
    }

    /**
     * Contacte l'administration pour contester une restriction
     */
    public function contactAdmin(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'message' => 'required|string|max:1000',
            'restriction_id' => 'required|exists:restrictions,id'
        ]);

        // Ici on pourrait envoyer un email à l'admin
        // ou créer un ticket de support

        return response()->json([
            'success' => true,
            'message' => 'Votre message a été envoyé à l\'administration. Nous vous répondrons dans les plus brefs délais.'
        ]);
    }
} 
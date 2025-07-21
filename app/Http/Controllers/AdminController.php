<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            if (auth()->user() && auth()->user()->role !== 'admin') {
                return redirect()->route('login')->withErrors(['email' => 'Accès refusé.']);
            }
            return $next($request);
        });
    }

    // Affiche la liste des demandes à approuver ou rejeter
    public function index()
    {
        $demandes = User::where('role', 'entrepreneur_en_attente')->get();

        return view('admin.dashboard', compact('demandes'));
    }

    // Approuver un utilisateur
    public function approuver($id)
    {
        $user = User::findOrFail($id);

        if ($user->role === 'entrepreneur_en_attente') {
            $user->role = 'entrepreneur_approuve';
            $user->motif_rejet = null; // Supprime motif si existait
            $user->save();

            return redirect()->route('admin.dashboard')->with('status', "L'utilisateur {$user->email} a été approuvé.");
        }

        return redirect()->route('admin.dashboard')->with('error', "Impossible d'approuver cet utilisateur.");
    }

    // Rejeter un utilisateur avec motif
    public function rejeter(Request $request, $id)
    {
        $request->validate([
            'motif_rejet' => 'required|string|max:500',
        ]);

        $user = User::findOrFail($id);

        if ($user->role === 'entrepreneur_en_attente') {
            $user->role = 'rejeté';
            $user->motif_rejet = $request->motif_rejet;
            $user->save();

            return redirect()->route('admin.dashboard')->with('status', "L'utilisateur {$user->email} a été rejeté.");
        }

        return redirect()->route('admin.dashboard')->with('error', "Impossible de rejeter cet utilisateur.");
    }
}

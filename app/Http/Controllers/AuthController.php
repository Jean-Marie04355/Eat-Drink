<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    // Inscription
    public function inscriptionPost(Request $request)
    {
        $request->validate([
            'nom_entreprise' => 'required|string|max:255',
            'email' => 'required|email|unique:users',
            'password' => 'required|confirmed|min:6',
        ]);

        User::create([
            'nom_entreprise' => $request->nom_entreprise,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        return redirect()->route('login')->with('status', 'Inscription réussie !');
    }

    // Connexion
  // Connexion
public function login(Request $request)
{
    $credentials = $request->validate([
        'email' => ['required', 'email'],
        'password' => ['required'],
    ]);

    if (Auth::attempt($credentials)) {
        $request->session()->regenerate();

        $user = Auth::user();
        if ($user->role === 'admin') {
           return redirect()->route('admin.dashboard')->with('status', 'Bienvenue administrateur !');

        } elseif ($user->role === 'entrepreneur_approuve') {
            return redirect()->route('entrepreneur.dashboard')->with('status', 'Bienvenue sur votre tableau de bord !');
        } else {
            Auth::logout();
            return redirect()->route('login')->withErrors(['email' => 'Votre compte n\'est pas encore approuvé.']);
        }
    }

    return back()->withErrors([
        'email' => 'Identifiants invalides.',
    ])->onlyInput('email');
}


    // Déconnexion
    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login')->with('status', 'Déconnecté avec succès.');
    }
}

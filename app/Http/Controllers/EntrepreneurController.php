<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Commande;
use Illuminate\Support\Facades\Auth;

class EntrepreneurController extends Controller
{
     public function dashboard()
    {
        // Récupérer tous les produits de l'entrepreneur connecté
        $produits = Auth::user()->produits;
        // Récupérer toutes les commandes qui contiennent au moins un de ses produits
        $commandes = Commande::whereHas('produits', function($query) use ($produits) {
            $query->whereIn('produit_id', $produits->pluck('id'));
        })->with(['produits' => function($q) use ($produits) {
            $q->whereIn('produit_id', $produits->pluck('id'));
        }])->latest()->get();
        return view('entrepreneur.dashboard', compact('commandes'));
    }
}

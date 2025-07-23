<?php
namespace App\Http\Controllers;

use App\Models\Commande;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CommandeController extends Controller
{
    public function passer()
    {
        $panier = session()->get('panier', []);
        if(empty($panier)) {
            return redirect()->route('panier.index')->with('error', 'Votre panier est vide.');
        }

        // Création de la commande
        $commande = Commande::create([
            'user_id' => auth()->id(), // si authentification
            // autres champs si besoin
        ]);

        // Associer les produits à la commande
        foreach($panier as $id => $details) {
            $commande->produits()->attach($id, ['quantite' => $details['quantite']]);
        }

        // Vider le panier
        session()->forget('panier');

        return redirect()->route('accueil')->with('success', 'Commande passée avec succès !');
    }

    public function store()
    {
        $panier = session()->get('panier', []);
        if(empty($panier)) {
            return redirect()->route('panier.index')->with('error', 'Votre panier est vide.');
        }

        // Création de la commande sans user_id
        $commande = Commande::create([]);

        // Associer les produits à la commande
        foreach($panier as $id => $details) {
            $commande->produits()->attach($id, ['quantite' => $details['quantite']]);
        }

        // Vider le panier
        session()->forget('panier');

        return redirect()->route('commandes.index')->with('success', 'Commande passée avec succès !');
    }

    public function index()
    {
        // Récupérer toutes les commandes de l'utilisateur connecté (ou toutes si admin)
        $commandes = Commande::where('user_id', auth()->id())->get();
        return view('commandes.index', compact('commandes'));
    }
}
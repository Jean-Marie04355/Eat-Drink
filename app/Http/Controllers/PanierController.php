<?php

namespace App\Http\Controllers;
use App\Models\Produit;
use Illuminate\Http\Request;
use App\Models\Exposant;

class PanierController extends Controller
{
    public function panierExposants()
    {
        $panierExposants = session()->get('panier_exposants', []);
        return view('panier.index_exposants', compact('panierExposants'));
    }

    public function ajouterExposant($id)
    {
        $exposant = Exposant::findOrFail($id);
        $panierExposants = session()->get('panier_exposants', []);

        if (!isset($panierExposants[$id])) {
            $panierExposants[$id] = [
                "nom" => $exposant->nom,
                "stand" => $exposant->stand ?? '',
            ];
            session()->put('panier_exposants', $panierExposants);
        }

        return redirect()->back()->with('success', 'Exposant ajouté au panier !');
    }

    public function retirerExposant($id)
    {
        $panierExposants = session()->get('panier_exposants', []);
        if (isset($panierExposants[$id])) {
            unset($panierExposants[$id]);
            session()->put('panier_exposants', $panierExposants);
        }
        return redirect()->route('panier.exposants')->with('success', 'Exposant retiré du panier !');
    }

    public function ajouter($id)
    {
        $produit = Produit::findOrFail($id);
        $panier = session()->get('panier', []);

        if(isset($panier[$id])) {
            $panier[$id]['quantite']++;
        } else {
            $panier[$id] = [
                "nom" => $produit->nom,
                "prix" => $produit->prix,
                "quantite" => 1
            ];
        }

        session()->put('panier', $panier);
        return redirect()->route('panier.index')->with('success', 'Produit ajouté au panier !');
    }

    public function index()
    {
        $panier = session()->get('panier', []);
        return view('panier.index', compact('panier'));
    }
}
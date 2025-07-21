<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;  // <-- Ajoute cette ligne
use App\Models\Produit;


class ExposantController extends Controller
{
    public function index()
    {
        $exposants = User::where('role', 'entrepreneur_approuve')->get();

        return view('exposants.index', compact('exposants'));
    }


    public function produits($id)
{
    $exposant = User::findOrFail($id);
    $produits = $exposant->produits; // grâce à la relation

    return view('exposants.produits', compact('exposant', 'produits'));
}

  public function show($id)
    {
        $exposant = User::findOrFail($id);
        $produits = Produit::where('user_id', $id)->get();

        return view('exposants.show', compact('exposant', 'produits'));
    }
}

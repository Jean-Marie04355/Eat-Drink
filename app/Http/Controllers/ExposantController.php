<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Exposant; // le modèle


class ExposantController extends Controller
{
    public function index()
    {
        // Création de la variable $exposants
        $exposants = Exposant::where('statut', 'approuvé')->get(); // ou ->all() si tu veux tout

        // Envoi de la variable à la vue exposants.blade.php
        return view('exposants', compact('exposants'));
    }
}

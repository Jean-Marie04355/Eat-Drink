<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ExposantController;


// Page d'accueil
Route::view('/', 'accueil')->name('accueil');
Route::view('/accueil', 'accueil')->name('accueil'); // si besoin en doublon

// Authentification
Route::view('/login', 'auth.login')->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.process');

Route::view('/inscription', 'auth.inscription')->name('auth.inscription');
Route::post('/inscription', [AuthController::class, 'inscriptionPost'])->name('auth.inscriptionPost');

Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Statut (protégé plus tard avec middleware si besoin)
Route::view('/statut', 'auth.statut')->name('auth.statut');

// Exposants
Route::get('/exposants', [ExposantController::class, 'index'])->name('exposants.index');
Route::get('/exposants/{id}', function ($id) {
    return view('exposants.show', ['stand_id' => $id]);
})->name('exposants.show');

// Panier
Route::view('/panier', 'panier')->name('panier');
Route::post('/panier/{id}', function ($id) {
    return redirect()->route('panier')->with('status', "Produit $id ajouté au panier 🛒");
})->name('panier.ajouter');

// Commande
Route::post('/commande', function () {
    return redirect()->route('commande.confirmation')->with('status', 'Commande enregistrée avec succès ✨');
})->name('commande.store');

Route::view('/confirmation', 'confirmation')->name('commande.confirmation');

// Test simple
Route::view('/test', 'test');

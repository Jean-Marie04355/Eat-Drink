<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ExposantController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\EntrepreneurController;
use App\Http\Controllers\ProduitController;
use App\Http\Controllers\PanierController;
use App\Http\Controllers\CommandeController;





/*
|--------------------------------------------------------------------------
| Routes Web
|--------------------------------------------------------------------------
*/

// Page d'accueil (accessible sans authentification)
Route::view('/', 'accueil')->name('accueil');
Route::view('/accueil', 'accueil'); // doublon optionnel

// Authentification (login/inscription)
Route::view('/login', 'auth.login')->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.process');

Route::view('/inscription', 'auth.inscription')->name('auth.inscription');
Route::post('/inscription', [AuthController::class, 'inscriptionPost'])->name('auth.inscriptionPost');

Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Statut de l'inscription (ex: entrepreneur en attente)
Route::view('/statut', 'auth.statut')->name('auth.statut');

// Routes protégées par authentification
Route::middleware(['auth'])->group(function () {

    // Tableau de bord admin — accessible uniquement à l'admin (middleware à ajouter dans AdminController)
    Route::get('/dashboard', [AdminController::class, 'index'])->name('admin.dashboard');

    // Espace exposants — accessible aux utilisateurs connectés (tu peux filtrer les rôles dans le controller)
   

});

// Panier (si accessible sans login, sinon mettre dans middleware auth)
Route::view('/panier', 'panier')->name('panier');
Route::post('/panier/{id}', function ($id) {
    return redirect()->route('panier')->with('status', "Produit $id ajouté au panier 🛒");
})->name('panier.ajouter');

// Commande
Route::post('/commande', function () {
    return redirect()->route('commande.confirmation')->with('status', 'Commande enregistrée avec succès ✨');
})->name('commande.store');

Route::view('/confirmation', 'confirmation')->name('commande.confirmation');

Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', [AdminController::class, 'index'])->name('admin.dashboard');
    Route::post('/dashboard/approuver/{id}', [AdminController::class, 'approuver'])->name('admin.approuver');
    Route::post('/dashboard/rejeter/{id}', [AdminController::class, 'rejeter'])->name('admin.rejeter');
});

Route::middleware(['auth', 'role:entrepreneur_approuve'])->group(function () {
    Route::get('/entrepreneur/dashboard', [EntrepreneurController::class, 'dashboard'])->name('entrepreneur.dashboard');
});

 Route::get('/exposants', [ExposantController::class, 'index'])->name('exposants.index');
    Route::get('/exposants/{id}', function ($id) {
       return view('exposants.produits', ['stand_id' => $id]);
})->name('exposants.show');


  Route::middleware(['auth', 'role:entrepreneur_approuve'])->prefix('entrepreneur')->name('entrepreneur.')->group(function () {
    Route::get('/produits', [ProduitController::class, 'index'])->name('produits.index');
    Route::get('/produits/create', [ProduitController::class, 'create'])->name('produits.create');
    Route::post('/produits', [ProduitController::class, 'store'])->name('produits.store');
    Route::get('/produits/{produit}/edit', [ProduitController::class, 'edit'])->name('produits.edit');
    Route::put('/produits/{produit}', [ProduitController::class, 'update'])->name('produits.update');
    Route::delete('/produits/{produit}', [ProduitController::class, 'destroy'])->name('produits.destroy');
      Route::resource('produits', ProduitController::class);
});
Route::get('/exposants/{id}/produits', [ExposantController::class, 'produits'])->name('exposants.produits');
Route::get('/exposants/{id}', [ExposantController::class, 'show'])->name('exposants.show');



Route::get('/panier', [PanierController::class, 'index'])->name('panier.index');
Route::post('/panier/ajouter/{id}', [PanierController::class, 'ajouter'])->name('panier.ajouter');
Route::post('/panier/retirer/{id}', [PanierController::class, 'retirer'])->name('panier.retirer');

// Commande
Route::post('/commande/passer', [CommandeController::class, 'passer'])->name('commande.passer');

// Panier d’exposants
Route::get('/panier-exposants', [\App\Http\Controllers\PanierController::class, 'panierExposants'])->name('panier.exposants');
Route::post('/panier-exposants/ajouter/{id}', [\App\Http\Controllers\PanierController::class, 'ajouterExposant'])->name('panier.ajouterExposant');
Route::post('/panier-exposants/retirer/{id}', [\App\Http\Controllers\PanierController::class, 'retirerExposant'])->name('panier.retirerExposant');

Route::get('/commandes', [\App\Http\Controllers\CommandeController::class, 'index'])->name('commandes.index');
Route::post('/commandes', [\App\Http\Controllers\CommandeController::class, 'store'])->name('commandes.store');
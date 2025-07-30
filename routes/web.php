<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\EntrepreneurController;
use App\Http\Controllers\ExposantController;
use App\Http\Controllers\ProduitController;
use App\Http\Controllers\PanierController;
use App\Http\Controllers\CommandeController;

// Page d'accueil
Route::view('/', 'welcome')->name('welcome');
Route::view('/accueil', 'accueil')->name('accueil');

// Authentification (login/inscription)
Route::view('/login', 'auth.login')->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.process');

Route::view('/inscription', 'auth.inscription')->name('auth.inscription');
Route::post('/inscription', [AuthController::class, 'inscriptionPost'])->name('auth.inscriptionPost');

Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Statut de l'inscription (ex: entrepreneur en attente)
Route::view('/statut', 'auth.statut')->name('auth.statut');

// Page de restriction de compte
Route::get('/restriction', [App\Http\Controllers\RestrictionController::class, 'show'])->name('auth.restriction');
Route::post('/restriction/check', [App\Http\Controllers\RestrictionController::class, 'checkRestriction'])->name('auth.restriction.check');
Route::post('/restriction/contact', [App\Http\Controllers\RestrictionController::class, 'contactAdmin'])->name('auth.restriction.contact');

// Page de test pour les restrictions (admin seulement)
Route::get('/dashboard/test-restriction', function() {
    return view('admin.test-restriction-simple');
})->name('admin.test-restriction');

// Routes publiques (sans authentification)
Route::get('/exposants', [ExposantController::class, 'index'])->name('exposants.index');
Route::get('/exposants/{id}', [ExposantController::class, 'show'])->name('exposants.show');
Route::get('/exposants/{id}/produits', [ExposantController::class, 'produits'])->name('exposants.produits');

// Routes panier publiques
Route::view('/panier', 'panier')->name('panier');
Route::post('/panier/{id}', function ($id) {
    return redirect()->route('panier')->with('status', "Produit $id ajouté au panier 🛒");
})->name('panier.ajouter');

// Commande
Route::post('/commande', function () {
    return redirect()->route('commande.confirmation')->with('status', 'Commande enregistrée avec succès ✨');
})->name('commande.store');

Route::view('/confirmation', 'confirmation')->name('commande.confirmation');

// Routes protégées par authentification avec vérification des restrictions
Route::middleware(['auth', 'check.restrictions'])->group(function () {
    // Routes admin
    Route::get('/dashboard', [AdminController::class, 'index'])->name('admin.dashboard');
    Route::get('/dashboard/commandes-entrepreneurs', [AdminController::class, 'commandesEntrepreneurs'])->name('admin.commandes-entrepreneurs');
    Route::get('/dashboard/statistiques', [AdminController::class, 'statistiques'])->name('admin.statistiques');
    Route::get('/dashboard/tendances', [AdminController::class, 'tendances'])->name('admin.tendances');
    Route::get('/dashboard/restrictions', [AdminController::class, 'restrictions'])->name('admin.restrictions');
    Route::post('/dashboard/restrictions', [AdminController::class, 'storeRestriction'])->name('admin.restrictions.store');
    Route::post('/dashboard/restrictions/{id}/activate', [AdminController::class, 'activateAccount'])->name('admin.restrictions.activate');
    Route::post('/dashboard/restrictions/{id}/extend', [AdminController::class, 'extendRestriction'])->name('admin.restrictions.extend');
    Route::delete('/dashboard/restrictions/{id}', [AdminController::class, 'deleteRestriction'])->name('admin.restrictions.delete');
    Route::post('/dashboard/approuver/{id}', [AdminController::class, 'approuver'])->name('admin.approuver');
    Route::post('/dashboard/rejeter/{id}', [AdminController::class, 'rejeter'])->name('admin.rejeter');
    
    // Routes entrepreneur
    Route::get('/entrepreneur/dashboard', [EntrepreneurController::class, 'dashboard'])->name('entrepreneur.dashboard');
    
    // Routes entrepreneur avec rôle spécifique
    Route::middleware(['role:entrepreneur_approuve'])->prefix('entrepreneur')->name('entrepreneur.')->group(function () {
        Route::get('/produits', [ProduitController::class, 'index'])->name('produits.index');
        Route::get('/produits/create', [ProduitController::class, 'create'])->name('produits.create');
        Route::post('/produits', [ProduitController::class, 'store'])->name('produits.store');
        Route::get('/produits/{produit}/edit', [ProduitController::class, 'edit'])->name('produits.edit');
        Route::put('/produits/{produit}', [ProduitController::class, 'update'])->name('produits.update');
        Route::delete('/produits/{produit}', [ProduitController::class, 'destroy'])->name('produits.destroy');
        Route::resource('produits', ProduitController::class);
    });
    
    // Routes panier et commandes
    Route::get('/panier', [PanierController::class, 'index'])->name('panier.index');
    Route::post('/panier/ajouter/{id}', [PanierController::class, 'ajouter'])->name('panier.ajouter');
    Route::post('/panier/retirer/{id}', [PanierController::class, 'retirer'])->name('panier.retirer');
    Route::post('/commande/passer', [CommandeController::class, 'passer'])->name('commande.passer');
    Route::get('/panier-exposants', [\App\Http\Controllers\PanierController::class, 'panierExposants'])->name('panier.exposants');
    Route::post('/panier-exposants/ajouter/{id}', [\App\Http\Controllers\PanierController::class, 'ajouterExposant'])->name('panier.ajouterExposant');
    Route::post('/panier-exposants/retirer/{id}', [\App\Http\Controllers\PanierController::class, 'retirerExposant'])->name('panier.retirerExposant');
    Route::get('/commandes', [\App\Http\Controllers\CommandeController::class, 'index'])->name('commandes.index');
    Route::post('/commandes', [\App\Http\Controllers\CommandeController::class, 'store'])->name('commandes.store');
});
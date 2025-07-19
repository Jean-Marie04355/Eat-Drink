<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\InscriptionController;
use App\Http\Controllers\StatutController;
use App\Http\Controllers\LoginController;
use Illuminate\Support\Facades\Auth;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Route::get('/', function () {
//     return view('accueil');
// });

 Route::get('/accueil', function () {
    return view('accueil');
});

// // Formulaire d'inscription
// Route::get('/inscription', [InscriptionController::class, 'index'])->name("inscription.index");
// Route::post('/inscription', [InscriptionController::class, 'store'])->name("inscription.store");

// // Formulaire de connexion
// Route::get('/login', [LoginController::class, 'index'])->name("login.index");
// Route::post('/login', [LoginController::class, 'connexion'])->name("login.connexion");

// // Page “statut en attente”
// // Route::get('/statut', [StatutController::class, 'attente'])->name("statut.attente");
// // Route::post('/statut', [StatutController::class, 'auth'])->name("statut.auth");

// Route::middleware(['auth', 'role:entrepreneur_en_attente'])->group(function () {
//     Route::get('/statut', [StatutController::class, 'attente'])->name('statut.attente');
// });



// // Déconnexion
// Route::post('/logout', function () {
//     Auth::logout();
//     return redirect('/login')->with('status', 'Vous avez été déconnecté.');
// })->name('logout');


// Route::get('/exposants', [StandController::class, 'index'])->name('exposants.index');
// Route::get('/exposants/{id}', [StandController::class, 'show'])->name('exposants.show');

// Route::post('/panier/{produit}', [PanierController::class, 'ajouter'])->name('panier.ajouter');
// Route::get('/panier', [PanierController::class, 'index'])->name('panier');

// Route::post('/commande', [CommandeController::class, 'store'])->name('commande.store');
// Route::get('/confirmation', fn() => view('confirmation'))->name('commande.confirmation');



// Page d'accueil
Route::view('/', 'accueil')->name('accueil');

// Page de login
Route::view('/login', 'auth.login')->name('login');

// Page d'inscription / demande de stand
Route::view('/inscription', 'auth.inscription')->name('auth.inscription');

// Page de statut pour entrepreneurs en attente
Route::view('/statut', 'auth.statut')->name('auth.statut');

// Test ou redirection simple
Route::view('/test', 'test');

// Optionnel : logout en front-only (redirection ou message)
Route::post('/logout', function () {
    // Tu peux rediriger vers l'accueil par exemple
    return redirect()->route('accueil');
})->name('logout');

Route::post('/login', function () {
    // Traitement simplifié pour le front uniquement
    return redirect()->route('accueil')->with('status', 'Connexion simulée 😄');
})->name('login.process');

Route::view('/exposants', 'exposants')->name('exposants.index');

// Page des exposants approuvés
Route::view('/exposants', 'exposants')->name('exposants.index');

// Page d’un stand spécifique : à adapter dynamiquement si besoin
Route::get('/exposants/{id}', function ($id) {
    // ⚠️ Simule l’affichage du stand avec des données fictives
    return view('exposants.show', ['stand_id' => $id]);
})->name('exposants.show');

// Affichage du panier
Route::view('/panier', 'panier')->name('panier');

// Ajout au panier (simulation, sans base de données)
Route::post('/panier/{id}', function ($id) {
    // ici tu pourrais ajouter à une session ou juste rediriger
    return redirect()->route('panier')->with('status', "Produit $id ajouté au panier 🛒");
})->name('panier.ajouter');

// Traitement simplifié de la commande
Route::post('/commande', function () {
    return redirect()->route('commande.confirmation')->with('status', 'Commande enregistrée avec succès ✨');
})->name('commande.store');

// Page de confirmation après commande
Route::view('/confirmation', 'confirmation')->name('commande.confirmation');

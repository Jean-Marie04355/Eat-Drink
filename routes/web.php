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

Route::get('/', function () {
    return view('accueil');
});

Route::get('/accueil', function () {
    return view('accueil');
});

// Formulaire d'inscription
Route::get('/inscription', [InscriptionController::class, 'index'])->name("inscription.index");
Route::post('/inscription', [InscriptionController::class, 'store'])->name("inscription.store");

// Formulaire de connexion
Route::get('/login', [LoginController::class, 'index'])->name("login.index");
Route::post('/login', [LoginController::class, 'connexion'])->name("login.connexion");

// Page “statut en attente”
// Route::get('/statut', [StatutController::class, 'attente'])->name("statut.attente");
// Route::post('/statut', [StatutController::class, 'auth'])->name("statut.auth");

Route::middleware(['auth', 'role:entrepreneur_en_attente'])->group(function () {
    Route::get('/statut', [StatutController::class, 'attente'])->name('statut.attente');
});



// Déconnexion
Route::post('/logout', function () {
    Auth::logout();
    return redirect('/login')->with('status', 'Vous avez été déconnecté.');
})->name('logout');


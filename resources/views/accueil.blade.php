@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <div class="text-center">
        <h1 class="display-4">Bienvenue sur Eat&Drink 🍽️</h1>
        <p class="lead">La plateforme de gestion des stands pour l’événement culinaire de l’année à Cotonou.</p>
        <a href="/inscription" class="btn btn-primary btn-lg mt-3">Demander un stand</a>
    </div>

    <hr class="my-5">

    <div class="row text-center">
        <div class="col-md-4">
            <h3>👨‍🍳 Entrepreneurs</h3>
            <p>Inscrivez-vous pour exposer vos produits et gérer votre stand.</p>
        </div>
        <div class="col-md-4">
            <h3>👥 Visiteurs</h3>
            <p>Découvrez les exposants et leurs créations culinaires.</p>
        </div>
        <div class="col-md-4">
            <h3>🛒 Commandes</h3>
            <p>Ajoutez vos produits préférés au panier et passez commande.</p>
        </div>
    </div>
</div>
@endsection



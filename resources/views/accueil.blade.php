@extends('layouts.app')

@section('content')
    <div class="container mt-5">
        <div class="text-center">
            <h1 class="display-4">Bienvenue sur Eat&Drink 🍽️</h1>
            <p class="lead">La plateforme de gestion des stands pour l’événement culinaire de l’année à Cotonou.</p>
            <a href="/exposants" class="btn btn-lg mt-3" style="background-color: #7b1e3d; color: white; border: none;">
                Voir nos exposants
            </a>
        </div>

        <hr class="my-5">

        <div class="row text-center">
            <div class="col-md-4">
                <a href="/inscription" style="text-decoration: none;color: #7b1e3d;">
                    <h3>👨‍🍳 Entrepreneurs</h3>
                </a>
                <p>Inscrivez-vous pour exposer vos produits et gérer votre stand.</p>
            </div>

            <div class="col-md-4">
                <a href="/exposants" style="text-decoration: none;color: #7b1e3d;">
                    <h3>👥 Visiteurs</h3>
                </a>
                <p>Découvrez les exposants et leurs créations culinaires.</p>
            </div>


            <div class="col-md-4">
                <a href="/exposants" style="text-decoration: none;color: #7b1e3d;">
                    <h3>🛒 Commandes</h3>
                </a>
                <p>Ajoutez vos produits préférés au panier et passez commande.</p>
            </div>


        </div>
    </div>
@endsection
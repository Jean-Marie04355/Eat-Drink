@extends('layouts.app')

@section('content')
<div class="container py-5">
    <div class="row align-items-center mb-5">
        <div class="col-md-7 text-center text-md-start">
            <h1 class="display-2 fw-bold text-success mb-3">Bienvenue sur Eat&Drink <span class="fs-1">🍽️</span></h1>
            <p class="lead fs-4 text-muted mb-4">La plateforme incontournable pour découvrir, commander et savourer les meilleures créations culinaires de Cotonou !</p>
            <a href="{{ route('exposants.index') }}" class="btn btn-primary btn-lg px-5 shadow-sm me-3 mb-2">Découvrir les exposants</a>
            <a href="{{ route('panier.index') }}" class="btn btn-outline-success btn-lg px-5 mb-2">Voir mon panier</a>
        </div>
        <div class="col-md-5 text-center d-none d-md-block">
            <img src="https://images.unsplash.com/photo-1504674900247-0877df9cc836?auto=format&fit=crop&w=600&q=80" alt="Eat&Drink" class="img-fluid rounded-4 shadow-lg" style="max-height: 320px; object-fit: cover;">
        </div>
    </div>

    <hr class="my-5">

    <div class="row text-center gy-4">
        <div class="col-md-4">
            <a href="{{ route('auth.inscription') }}" class="text-decoration-none text-dark">
                <div class="p-4 border rounded-4 shadow-sm h-100 d-flex flex-column justify-content-center bg-white">
                    <div class="mb-3 fs-1">👨‍🍳</div>
                    <h3 class="fw-semibold mb-3">Entrepreneurs</h3>
                    <p class="text-muted">Inscrivez-vous pour exposer vos produits et gérer votre stand.</p>
                </div>
            </a>
        </div>
        <div class="col-md-4">
            <a href="{{ route('exposants.index') }}" class="text-decoration-none text-dark">
                <div class="p-4 border rounded-4 shadow-sm h-100 d-flex flex-column justify-content-center bg-white">
                    <div class="mb-3 fs-1">👥</div>
                    <h3 class="fw-semibold mb-3">Visiteurs</h3>
                    <p class="text-muted">Découvrez les exposants et leurs créations culinaires.</p>
                </div>
            </a>
        </div>
        <div class="col-md-4">
            <a href="{{ route('exposants.index') }}" class="text-decoration-none text-dark">
                <div class="p-4 border rounded-4 shadow-sm h-100 d-flex flex-column justify-content-center bg-white">
                    <div class="mb-3 fs-1">🛒</div>
                    <h3 class="fw-semibold mb-3">Commandes</h3>
                    <p class="text-muted">Ajoutez vos produits préférés au panier et passez commande en quelques clics.</p>
                </div>
            </a>
        </div>
    </div>

    <div class="row mt-5">
        <div class="col-12 text-center">
            <h4 class="fw-bold mb-3">Pourquoi choisir Eat&Drink ?</h4>
            <p class="text-muted mb-1">• Un large choix d’exposants et de produits locaux</p>
            <p class="text-muted mb-1">• Commande simple et rapide, sans inscription obligatoire</p>
            <p class="text-muted mb-1">• Plateforme 100% gratuite pour les visiteurs</p>
        </div>
    </div>
</div>
@endsection

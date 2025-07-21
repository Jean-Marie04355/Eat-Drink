@extends('layouts.app')

@section('content')
<div class="container py-5">
    <div class="text-center mb-5">
        <h1 class="display-3 fw-bold text-success">Bienvenue sur Eat&Drink 🍽️</h1>
        <p class="lead fs-4 text-muted">La plateforme de gestion des stands pour l’événement culinaire de l’année à Cotonou.</p>
        <a href="{{ route('exposants.index') }}" class="btn btn-primary btn-lg mt-3 px-5 shadow-sm">
            Nos Exposants
        </a>
    </div>

    <hr class="my-5">

    <div class="row text-center gy-4">
        <div class="col-md-4">
            <a href="{{ route('auth.inscription') }}" class="text-decoration-none text-dark">
                <div class="p-4 border rounded shadow-sm h-100 d-flex flex-column justify-content-center">
                    <div class="mb-3 fs-1">👨‍🍳</div>
                    <h3 class="fw-semibold mb-3">Entrepreneurs</h3>
                    <p class="text-muted">Inscrivez-vous pour exposer vos produits et gérer votre stand.</p>
                </div>
            </a>
        </div>

        <div class="col-md-4">
            <a href="{{ route('exposants.index') }}" class="text-decoration-none text-dark">
                <div class="p-4 border rounded shadow-sm h-100 d-flex flex-column justify-content-center">
                    <div class="mb-3 fs-1">👥</div>
                    <h3 class="fw-semibold mb-3">Visiteurs</h3>
                    <p class="text-muted">Découvrez les exposants et leurs créations culinaires.</p>
                </div>
            </a>
        </div>

        <div class="col-md-4">
            <div class="p-4 border rounded shadow-sm h-100 d-flex flex-column justify-content-center">
                <div class="mb-3 fs-1">🛒</div>
                <h3 class="fw-semibold mb-3">Commandes</h3>
                <p class="text-muted">Ajoutez vos produits préférés au panier et passez commande.</p>
            </div>
        </div>
    </div>
</div>
@endsection

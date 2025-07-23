<!-- page pour les entrepreneurs approuvés -->
@extends('layouts.app')

@section('content')
    <div class="container mt-5" style="max-width: 800px;">
        <div class="text-center mb-5">
            <h2 class="fw-bold" style="color: #7b1e3d;">Tableau de Bord Exposant</h2>
            <p class="fs-5">Bienvenue <strong>{{ Auth::user()->nom_entreprise ?? 'Cher exposant' }}</strong> !</p>
            <p class="text-muted">Gérez votre stand, vos produits et vos commandes depuis cet espace dédié.</p>
        </div>


        <div class="card shadow-sm mb-4 border-0">
            <div class="card-header text-white" style="background-color: #7b1e3d;">
                <h5 class="mb-0">
                    🧾 Informations du compte
                </h5>
            </div>
            <div class="card-body bg-light">
                <dl class="row mb-0">
                    <dt class="col-sm-3 fw-bold text-muted">Entreprise :</dt>
                    <dd class="col-sm-9">{{ Auth::user()->nom_entreprise }}</dd>

                    <dt class="col-sm-3 fw-bold text-muted">Email :</dt>
                    <dd class="col-sm-9">{{ Auth::user()->email }}</dd>

                    <dt class="col-sm-3 fw-bold text-muted">Statut :</dt>
                    <dd class="col-sm-9 text-capitalize">
                        @if(Auth::user()->role === 'entrepreneur_approuve')
                            <span class="badge"
                                style="background-color: #fff8f0; border: 1px solid #5d4037; color: #5d4037; padding: 0.45em 0.8em;">
                                Approuvé
                            </span>
                        @elseif(Auth::user()->role === 'entrepreneur_en_attente')
                            <span class="badge bg-warning text-dark">En attente</span>
                        @else
                            {{ Auth::user()->role }}
                        @endif
                    </dd>
                </dl>
            </div>
        </div>


        <div class="row">
            <!-- Gestion des produits -->
            <div class="col-md-4 mb-4">
                <div class="card shadow-sm h-100 text-center">
                    <div class="card-body">
                        <h5 class="fw-bold mb-3">🛍️ Mes Produits</h5>
                        <p>Ajoutez, modifiez ou supprimez vos offres.</p>
                        <a href="{{ route('entrepreneur.produits.index') }}" class="btn btn-sm"
                            style="background-color: #7b1e3d; color: white;">Gérer</a>
                    </div>
                </div>
            </div>

            <!-- Commandes reçues -->
            <div class="col-md-4 mb-4">
                <div class="card shadow-sm h-100 text-center">
                    <div class="card-body">
                        <h5 class="fw-bold mb-3">📦 Mes Commandes</h5>
                        <p>Consultez les commandes passées par les visiteurs.</p>
                        <a href="#" class="btn btn-sm" style="background-color: #7b1e3d; color: white;">Consulter</a>
                    </div>
                </div>
            </div>

            <!-- Vitrine publique -->
            <div class="col-md-4 mb-4">
                <div class="card shadow-sm h-100 text-center">
                    <div class="card-body">
                        <h5 class="fw-bold mb-3">👨‍🍳 Mon Stand</h5>
                        <p>Vérifiez la présentation publique de votre espace.</p>
                        <a href="/exposants/{{ Auth::user()->id }}" class="btn btn-sm"
                            style="background-color: #7b1e3d; color: white;">Voir</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
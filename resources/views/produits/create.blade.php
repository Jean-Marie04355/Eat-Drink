<!-- Formulaire d'ajout de produits -->
@extends('layouts.app')

@section('content')
    <div class="container mt-5" style="max-width: 650px;">
        <h2 class="fw-bold text-center mb-4" style="color: #7b1e3d;"> Ajouter un Produit </h2>

        @if(request()->filled('nom'))
            <div class="alert alert-success text-center">
                <strong>Produit ajouté :</strong><br>
                Nom : {{ request('nom') }}<br>
                Description : {{ request('description') }}<br>
                Prix : {{ request('prix') }} FCFA
            </div>
        @endif

        <div class="mb-4 text-start">
            <a href="{{ route('dashboard') }}" class="btn btn-outline-dark">
                ← Retour au Tableau de Bord
            </a>
        </div>

        <form method="GET" action="{{ route('produits.demo') }}">
            <!-- Nom -->
            <div class="mb-3">
                <label for="nom" class="form-label">Nom du produit</label>
                <input type="text" name="nom" id="nom" class="form-control" placeholder="Ex: Jus de bissap" style=" 
                                        border-color: #f9f6f7ff;
                                        box-shadow: 0 0 0 0.15rem rgba(190, 186, 187, 0.25);
                                        outline: none;
                                    " required>
            </div>

            <!-- Description -->
            <div class="mb-3">
                <label for="description" class="form-label">Description</label>
                <textarea name="description" id="description" rows="3" class="form-control" style=" 
                                        border-color: #f9f6f7ff;
                                        box-shadow: 0 0 0 0.15rem rgba(190, 186, 187, 0.25);
                                        outline: none;
                                    " placeholder="Frais, naturel, fait maison" required></textarea>
            </div>

            <!-- Prix -->
            <div class="mb-4">
                <label for="prix" class="form-label">Prix (FCFA)</label>
                <input type="number" name="prix" id="prix" class="form-control" placeholder="Ex: 1500" style=" 
                                        border-color: #f9f6f7ff;
                                        box-shadow: 0 0 0 0.15rem rgba(190, 186, 187, 0.25);
                                        outline: none;
                                    " required>
            </div>

            <div class="d-grid">
                <button type="submit" class="btn btn-lg" style="background-color: #7b1e3d; color: white;">
                    Ajouter
                </button>
            </div>
        </form>
    </div>
@endsection
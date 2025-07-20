<!-- Affiche tous les produits de l’entrepreneur connecté  -->
@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <h2 class="mb-4 fw-bold text-center" style="color: #7b1e3d;">Mes Produits</h2>

    <!-- Lien vers création -->
    <div class="text-end mb-4">
        <a href="{{ route('produits.create') }}" class="btn btn-sm" style="background-color: #7b1e3d; color: white;">
             Ajouter un nouveau produit
        </a>
    </div>

    @if($produits->isEmpty())
        <p class="text-muted text-center">Vous n'avez encore ajouté aucun produit.</p>
    @else
        <table class="table table-bordered table-hover">
            <thead class="table-light">
                <tr class="text-center">
                    <th>Nom</th>
                    <th>Description</th>
                    <th>Prix (FCFA)</th>
                    <th>Image</th>
                    <th>Actions</th>
                </tr>
            </thead>
          <!-- Ajout dans le tableau -->
        </table>
    @endif
</div>
@endsection

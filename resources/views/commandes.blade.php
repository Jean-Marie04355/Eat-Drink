@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <h2 class="mb-4 fw-bold text-center" style="color: #7b1e3d;">📦 Commandes Reçues</h2>

    @if($commandes->isEmpty())
        <p class="text-muted text-center">Aucune commande reçue pour le moment.</p>
    @else
        <table class="table table-bordered table-hover">
            <thead class="table-light">
                <tr class="text-center">
                    <th>Commande #</th>
                    <th>Produits</th>
                    <th>Date</th>
                    <th>Statut</th>
                </tr>
            </thead>
           <!-- l’affichage dynamique de toutes les commandes reçues par un exposant, à l’intérieur d’un tableau HTML -->
        </table>
    @endif
</div>
@endsection

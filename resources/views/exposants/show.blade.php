@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Produits de {{ $exposant->nom_entreprise }}</h2>

    <div class="row">
        @foreach($produits as $produit)
            <div class="col-md-4 mb-4">
                <div class="card h-100">
                    @if($produit->photo)
                        <img src="{{ asset('storage/' . $produit->photo) }}" class="card-img-top" alt="Image de {{ $produit->nom }}" style="height: 200px; object-fit: cover;">
                    @else
                        <img src="{{ asset('images/default.jpg') }}" class="card-img-top" alt="Pas d'image" style="height: 200px; object-fit: cover;">
                    @endif
                    <div class="card-body">
                        <h5 class="card-title">{{ $produit->nom }}</h5>
                        <p class="card-text">{{ $produit->description }}</p>
                        <p class="card-text"><strong>{{ number_format($produit->prix, 0, ',', ' ') }} FCFA</strong></p>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</div>
@endsection

@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <h2 class="text-center  mb-4" style="color: #7b1e3d;">
         Produits de {{ $exposant->nom_entreprise }}
    </h2>

    <div class="row">
        @foreach($produits as $produit)
            <div class="col-md-4 mb-4">
                <div class="card h-100 shadow-sm border-0" style="background-color: #fff8f0;">
                    @if($produit->photo)
                        <img src="{{ asset('storage/' . $produit->photo) }}" class="card-img-top rounded-top"
                             alt="Image de {{ $produit->nom }}" style="height: 200px; object-fit: cover;">
                    @else
                        <img src="{{ asset('images/default.jpg') }}" class="card-img-top rounded-top"
                             alt="Pas d'image" style="height: 200px; object-fit: cover;">
                    @endif

                    <div class="card-body text-center">
                        <h5 class="fw-bold" style="color: #7b1e3d;">{{ $produit->nom }}</h5>
                        <p class="text-muted small">{{ $produit->description }}</p>
                        <p class="fw-bold" style="color: #c2185b;">
                            {{ number_format($produit->prix, 0, ',', ' ') }} FCFA
                        </p>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</div>
@endsection

<!-- Affiche tous les produits de l’entrepreneur connecté  -->
@extends('layouts.app')

@section('content')
    <div class="container mt-5">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <!-- Lien vers création -->
            <h2 class="fw-bold" style="color: #7b1e3d;">Mes Produits</h2>
            <a href="{{ route('entrepreneur.produits.create') }}" class="btn btn-sm"
                style="background-color: #7b1e3d; color: white;">
                Ajouter un produit
            </a>
        </div>

        @if(session('success'))
            <div class="alert text-dark" style="background-color: #fff8f0; border: 1px solid #5d4037;">{{ session('success') }}</div>
        @endif

        @if($produits->isEmpty())
            <div class="alert text-dark" style="background-color: #fff8f0; border: 1px solid #5d4037;">
                Aucun produit trouvé pour le moment.
        </div> @else
            <div class="row row-cols-1 row-cols-md-3 g-4">
                @foreach($produits as $produit)
                    <div class="col">
                        <div class="card h-100 shadow-sm">
                            @if($produit->photo)
                                <img src="{{ asset('storage/' . $produit->photo) }}" class="card-img-top"
                                    style="height: 200px; object-fit: cover;" alt="Image du produit">
                            @else
                                <img src="https://via.placeholder.com/300x200?text=Pas+de+photo" class="card-img-top"
                                    alt="Pas de photo">
                            @endif
                            <div class="card-body d-flex flex-column">
                                <h5 class="card-title">{{ $produit->nom }}</h5>
                                <p class="card-text text-muted small">
                                    {{ \Illuminate\Support\Str::limit($produit->description, 80) }}
                                </p>
                                <p class="fw-bold mt-auto text-primary">
                                    {{ number_format($produit->prix, 0, ',', ' ') }} FCFA
                                </p>
                            </div>
                            <div class="card-footer d-flex justify-content-between">
                                <a href="{{ route('entrepreneur.produits.edit', $produit) }}"
                                    class="btn btn-sm btn-outline-primary">✏️ Modifier</a>
                                <form action="{{ route('entrepreneur.produits.destroy', $produit) }}" method="POST"
                                    onsubmit="return confirm('Supprimer ce produit ?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-outline-danger">🗑️ Supprimer</button>
                                </form>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </div>
@endsection
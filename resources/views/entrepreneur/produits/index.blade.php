@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <div class="row align-items-center mb-4">
        <div class="col-md-8 text-center text-md-start">
            <h2 class="fw-bold display-5 text-success mb-2">🛍️ Mes Produits</h2>
            <p class="text-muted mb-0">Gérez facilement vos produits, ajoutez-en de nouveaux et mettez-les en valeur auprès des visiteurs.</p>
        </div>
        <div class="col-md-4 text-center text-md-end mt-3 mt-md-0">
            <a href="{{ route('entrepreneur.produits.create') }}" class="btn btn-success btn-lg">
                ➕ Ajouter un produit
            </a>
        </div>
    </div>

    {{-- Statistiques rapides --}}
    <div class="row mb-4">
        <div class="col-md-4 mb-2">
            <div class="card border-0 shadow-sm text-center">
                <div class="card-body">
                    <div class="fs-2 fw-bold text-success">{{ $produits->count() }}</div>
                    <div class="text-muted">Produit{{ $produits->count() > 1 ? 's' : '' }} au total</div>
                </div>
            </div>
        </div>
        <div class="col-md-4 mb-2">
            <div class="card border-0 shadow-sm text-center">
                <div class="card-body">
                    <div class="fs-2 fw-bold text-primary">
                        {{ number_format($produits->sum('prix'), 0, ',', ' ') }} FCFA
                    </div>
                    <div class="text-muted">Valeur totale du stock</div>
                </div>
            </div>
        </div>
        <div class="col-md-4 mb-2">
            <div class="card border-0 shadow-sm text-center">
                <div class="card-body">
                    <div class="fs-2 fw-bold text-info">
                        {{ $produits->where('prix', '>', 0)->count() }}
                    </div>
                    <div class="text-muted">Produits en vente</div>
                </div>
            </div>
        </div>
    </div>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @if($produits->isEmpty())
        <div class="alert alert-info p-4 text-center">
            <h4 class="mb-3">Aucun produit trouvé pour le moment.</h4>
            <p>Ajoutez votre premier produit pour attirer les visiteurs sur votre stand !</p>
            <a href="{{ route('entrepreneur.produits.create') }}" class="btn btn-primary btn-lg mt-2">Ajouter un produit</a>
        </div>
    @else
        <div class="row row-cols-1 row-cols-md-3 g-4">
            @foreach($produits as $produit)
                <div class="col">
                    <div class="card h-100 shadow-sm border-0 rounded-4 position-relative">
                        @if($produit->photo)
                            <img src="{{ asset('storage/' . $produit->photo) }}" class="card-img-top rounded-top-4" style="height: 200px; object-fit: cover;" alt="Image du produit">
                        @else
                            <img src="https://via.placeholder.com/300x200?text=Pas+de+photo" class="card-img-top rounded-top-4" alt="Pas de photo">
                        @endif
                        {{-- Badge prix --}}
                        <span class="badge bg-success position-absolute top-0 end-0 m-2 fs-6">{{ number_format($produit->prix, 0, ',', ' ') }} FCFA</span>
                        <div class="card-body d-flex flex-column">
                            <h5 class="card-title fw-bold text-primary">{{ $produit->nom }}</h5>
                            <p class="card-text text-muted small mb-2">
                                <span tabindex="0" data-bs-toggle="popover" data-bs-trigger="focus" title="Description" data-bs-content="{{ $produit->description }}">
                                    {{ \Illuminate\Support\Str::limit($produit->description, 80) }}
                                    @if(strlen($produit->description) > 80)
                                        <span class="text-primary" style="cursor:pointer;">[+]</span>
                                    @endif
                                </span>
                            </p>
                        </div>
                        <div class="card-footer d-flex justify-content-between bg-white border-0">
                            <a href="{{ route('entrepreneur.produits.edit', $produit) }}" class="btn btn-sm btn-outline-primary">✏️ Modifier</a>
                            <form action="{{ route('entrepreneur.produits.destroy', $produit) }}" method="POST" onsubmit="return confirm('Supprimer ce produit ?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-outline-danger">🗑️ Supprimer</button>
                            </form>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
        <script>
            var popoverTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="popover"]'));
            var popoverList = popoverTriggerList.map(function (popoverTriggerEl) {
                return new bootstrap.Popover(popoverTriggerEl);
            });
        </script>
    @endif
</div>
@endsection

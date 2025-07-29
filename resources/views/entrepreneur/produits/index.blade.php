@extends('layouts.app')

@section('content')
<div class="container-fluid px-0 mb-5">
    <div class="position-relative" style="height: 180px; background: linear-gradient(120deg, #198754 60%, #e9f7ef 100%);">
        <img src="https://images.unsplash.com/photo-1506744038136-46273834b3fb?auto=format&fit=crop&w=1200&q=80" alt="Produits" class="w-100 h-100 object-fit-cover position-absolute top-0 start-0" style="opacity: 0.18; object-fit: cover;">
        <div class="position-absolute top-50 start-50 translate-middle w-100 text-center">
            <h2 class="fw-bold display-5 mb-2" style="color: #198754; text-shadow: 0 2px 8px #fff; letter-spacing: 1px; font-family: 'Segoe UI', 'Arial', sans-serif;">🛍️ Mes Produits</h2>
            <a href="{{ route('entrepreneur.produits.create') }}" class="btn btn-success btn-lg mt-2 px-4 shadow-sm rounded-pill">➕ Ajouter un produit</a>
        </div>
    </div>
</div>
<div class="container py-4">
    <div class="row mb-4 g-3">
        <div class="col-md-4">
            <div class="card border-0 shadow-sm text-center h-100 rounded-5">
                <div class="card-body">
                    <div class="fs-1 mb-2"><i class="bi bi-box-seam text-success"></i></div>
                    <div class="fs-2 fw-bold text-success" style="font-family: 'Segoe UI', 'Arial', sans-serif;">{{ $produits->count() }}</div>
                    <div class="text-muted">Produit{{ $produits->count() > 1 ? 's' : '' }} au total</div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card border-0 shadow-sm text-center h-100 rounded-5">
                <div class="card-body">
                    <div class="fs-1 mb-2"><i class="bi bi-cash-coin text-primary"></i></div>
                    <div class="fs-2 fw-bold text-primary" style="font-family: 'Segoe UI', 'Arial', sans-serif;">{{ number_format($produits->sum('prix'), 0, ',', ' ') }} FCFA</div>
                    <div class="text-muted">Valeur totale du stock</div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card border-0 shadow-sm text-center h-100 rounded-5">
                <div class="card-body">
                    <div class="fs-1 mb-2"><i class="bi bi-bag-check text-info"></i></div>
                    <div class="fs-2 fw-bold text-info" style="font-family: 'Segoe UI', 'Arial', sans-serif;">{{ $produits->where('prix', '>', 0)->count() }}</div>
                    <div class="text-muted">Produits en vente</div>
                </div>
            </div>
        </div>
    </div>
    @if(session('success'))
        <div class="alert alert-success text-center">{{ session('success') }}</div>
    @endif
    @if($produits->isEmpty())
        <div class="text-center py-5">
            <img src="https://img.icons8.com/color/96/empty-box.png" alt="Aucun produit" class="mb-3" style="opacity:0.7;">
            <h4 class="mb-3">Aucun produit trouvé pour le moment.</h4>
            <p>Ajoutez votre premier produit pour attirer les visiteurs sur votre stand !</p>
            <a href="{{ route('entrepreneur.produits.create') }}" class="btn btn-success btn-lg mt-2 px-4 rounded-pill">Ajouter un produit</a>
        </div>
    @else
        <div class="row row-cols-1 row-cols-md-3 g-4">
            @foreach($produits as $produit)
                @php
                    $isNew = \Carbon\Carbon::parse($produit->created_at ?? now())->gt(now()->subDays(7));
                @endphp
                <div class="col">
                    <div class="card h-100 shadow-sm border-0 rounded-5 position-relative produit-hover bg-white" style="transition: box-shadow 0.3s, transform 0.3s;">
                        @if($produit->photo)
                            <img src="{{ asset('storage/' . $produit->photo) }}" class="card-img-top rounded-top-5 produit-img" style="height: 210px; object-fit: cover; transition: transform 0.4s;">
                        @else
                            <img src="https://img.icons8.com/color/192/meal.png" class="card-img-top rounded-top-5 produit-img" style="height: 210px; object-fit: cover; background: #f8f9fa; transition: transform 0.4s;">
                        @endif
                        @if($isNew)
                            <span class="badge bg-success position-absolute top-0 start-0 m-2 rounded-pill px-3 py-2 shadow">Nouveau</span>
                        @endif
                        <span class="badge bg-success position-absolute top-0 end-0 m-2 fs-6 rounded-pill px-3 py-2 shadow">{{ number_format($produit->prix, 0, ',', ' ') }} FCFA</span>
                        <div class="card-body d-flex flex-column p-4">
                            <h5 class="card-title fw-bold text-success mb-2" style="font-family: 'Segoe UI', 'Arial', sans-serif; letter-spacing: 0.5px;">{{ $produit->nom }}</h5>
                            <p class="card-text text-muted small mb-2" style="min-height: 38px;">
                                <span tabindex="0" data-bs-toggle="popover" data-bs-trigger="focus" title="Description" data-bs-content="{{ $produit->description }}">
                                    {{ \Illuminate\Support\Str::limit($produit->description, 80) }}
                                    @if(strlen($produit->description) > 80)
                                        <span class="text-success" style="cursor:pointer;">[+]</span>
                                    @endif
                                </span>
                            </p>
                        </div>
                        <div class="card-footer d-flex justify-content-between bg-white border-0 rounded-bottom-5 p-3">
                            <a href="{{ route('entrepreneur.produits.edit', $produit) }}" class="btn btn-outline-primary btn-sm rounded-pill px-3">✏️ Modifier</a>
                            <form action="{{ route('entrepreneur.produits.destroy', $produit) }}" method="POST" onsubmit="return confirm('Supprimer ce produit ?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-outline-danger btn-sm rounded-pill px-3">🗑️ Supprimer</button>
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
            // Effet de zoom sur l'image au survol
            document.querySelectorAll('.produit-hover').forEach(function(card) {
                card.addEventListener('mouseenter', function() {
                    card.querySelector('.produit-img').style.transform = 'scale(1.06)';
                    card.classList.add('shadow-lg');
                    card.style.transform = 'translateY(-4px) scale(1.01)';
                });
                card.addEventListener('mouseleave', function() {
                    card.querySelector('.produit-img').style.transform = 'scale(1)';
                    card.classList.remove('shadow-lg');
                    card.style.transform = 'none';
                });
            });
        </script>
    @endif
</div>
@endsection

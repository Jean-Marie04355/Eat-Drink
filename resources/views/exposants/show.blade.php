@extends('layouts.app')

@section('content')
<div class="container-fluid px-0 mb-5">
    <div class="position-relative" style="height: 260px; background: linear-gradient(120deg, #198754 60%, #e9f7ef 100%);">
        <img src="https://images.unsplash.com/photo-1504674900247-0877df9cc836?auto=format&fit=crop&w=1200&q=80" alt="Stand" class="w-100 h-100 object-fit-cover position-absolute top-0 start-0" style="opacity: 0.18; object-fit: cover;">
        <div class="position-absolute top-50 start-50 translate-middle w-100" style="z-index:2;">
            <div class="d-flex flex-column flex-md-row align-items-center justify-content-center gap-4">
                <div class="bg-white rounded-circle shadow d-flex align-items-center justify-content-center" style="width: 110px; height: 110px; border: 4px solid #198754;">
                    <img src="https://img.icons8.com/color/96/chef-hat.png" alt="Logo stand" class="img-fluid" style="max-width: 70px;">
                </div>
                <div class="text-center text-md-start">
                    <h2 class="fw-bold mb-1" style="color: #198754; text-shadow: 0 2px 8px #fff;">{{ $exposant->nom_entreprise }}</h2>
                    @if(!empty($exposant->secteur))
                        <span class="badge bg-info text-dark fs-6 mb-2">{{ $exposant->secteur }}</span>
                    @endif
                    @if(!empty($exposant->description))
                        <p class="text-muted small mb-1 mt-2">{{ \Illuminate\Support\Str::limit($exposant->description, 80) }}</p>
                    @endif
                    <a href="mailto:{{ $exposant->email }}" class="btn btn-success btn-sm px-3 rounded-pill mt-2"><i class="bi bi-envelope me-1"></i>Contacter</a>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="container py-4">
    <div class="d-flex flex-column flex-md-row align-items-center justify-content-between mb-4 gap-3">
        <h3 class="fw-bold mb-0" style="color: #198754;">Produits du stand</h3>
        <!-- Filtres UI (non fonctionnels, pour look pro) -->
        <div class="d-flex gap-2">
            <select class="form-select form-select-sm shadow-sm" style="max-width: 160px;">
                <option selected>Tous</option>
                <option>Snacks</option>
                <option>Boissons</option>
                <option>Plats chauds</option>
            </select>
            <select class="form-select form-select-sm shadow-sm" style="max-width: 160px;">
                <option selected>Tri : Nouveaux</option>
                <option>Prix croissant</option>
                <option>Prix décroissant</option>
            </select>
        </div>
    </div>
    <div class="row g-4">
        @forelse($produits as $produit)
            @php
                $isNew = \Carbon\Carbon::parse($produit->created_at ?? now())->gt(now()->subDays(7));
            @endphp
            <div class="col-12 col-sm-6 col-lg-4 col-xl-3">
                <div class="card h-100 shadow-sm border-0 rounded-4 produit-hover overflow-hidden position-relative transition-all" style="transition: box-shadow 0.3s;">
                    @if($isNew)
                        <span class="badge bg-success position-absolute top-0 end-0 m-2">Nouveau</span>
                    @endif
                    <div class="overflow-hidden" style="border-top-left-radius: 1rem; border-top-right-radius: 1rem;">
                        @if($produit->photo)
                            <img src="{{ asset('storage/' . $produit->photo) }}" class="card-img-top produit-img w-100" alt="Image de {{ $produit->nom }}" style="height: 180px; object-fit: cover; transition: transform 0.4s;">
                        @else
                            <img src="https://img.icons8.com/color/192/meal.png" class="card-img-top produit-img w-100" alt="Pas d'image" style="height: 180px; object-fit: cover; background: #f8f9fa; transition: transform 0.4s;">
                        @endif
                    </div>
                    <div class="card-body d-flex flex-column">
                        <h5 class="card-title fw-bold mb-2 text-center" style="color: #198754;">{{ $produit->nom }}</h5>
                        <p class="card-text text-muted small mb-2 text-center">
                            <span tabindex="0" data-bs-toggle="popover" data-bs-trigger="focus" title="Description" data-bs-content="{{ $produit->description }}">
                                {{ \Illuminate\Support\Str::limit($produit->description, 70) }}
                                @if(strlen($produit->description) > 70)
                                    <span class="text-success" style="cursor:pointer;">[+]</span>
                                @endif
                            </span>
                        </p>
                        <p class="card-text fw-bold fs-5 mb-3 text-center" style="color: #198754;">{{ number_format($produit->prix, 0, ',', ' ') }} FCFA</p>
                        <form action="{{ route('panier.ajouter', $produit->id) }}" method="POST" class="mt-auto">
                            @csrf
                            <button type="submit" class="btn btn-success w-100 transition-all" style="transition: background 0.2s, box-shadow 0.2s;">
                                <i class="bi bi-cart-plus"></i> Ajouter au panier
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-12">
                <div class="text-center py-5">
                    <img src="https://img.icons8.com/color/96/empty-box.png" alt="Aucun produit" class="mb-3" style="opacity:0.7;">
                    <h5 class="text-muted">Aucun produit disponible pour ce stand.</h5>
                </div>
            </div>
        @endforelse
    </div>
</div>
<script>
    // Effet de zoom sur l'image au survol + bouton animé
    document.querySelectorAll('.produit-hover').forEach(function(card) {
        card.addEventListener('mouseenter', function() {
            card.querySelector('.produit-img').style.transform = 'scale(1.08)';
            card.classList.add('shadow-lg');
            card.querySelector('button[type="submit"]').classList.add('shadow-sm');
        });
        card.addEventListener('mouseleave', function() {
            card.querySelector('.produit-img').style.transform = 'scale(1)';
            card.classList.remove('shadow-lg');
            card.querySelector('button[type="submit"]').classList.remove('shadow-sm');
        });
    });
    // Popover Bootstrap
    var popoverTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="popover"]'));
    var popoverList = popoverTriggerList.map(function (popoverTriggerEl) {
        return new bootstrap.Popover(popoverTriggerEl);
    });
</script>
@endsection

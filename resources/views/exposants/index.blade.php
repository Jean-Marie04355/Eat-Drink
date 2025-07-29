@extends('layouts.app')

@section('content')
<div class="container-fluid px-0 mb-5">
    <div class="position-relative" style="height: 260px; background: linear-gradient(120deg, #198754 60%, #e9f7ef 100%);">
        <img src="https://images.unsplash.com/photo-1506744038136-46273834b3fb?auto=format&fit=crop&w=1200&q=80" alt="Exposants" class="w-100 h-100 object-fit-cover position-absolute top-0 start-0" style="opacity: 0.25; object-fit: cover;">
        <div class="position-absolute top-50 start-50 translate-middle text-center w-100">
            <h1 class="fw-bold display-4 mb-2" style="color: #198754; text-shadow: 0 2px 8px #fff;">Nos Exposants</h1>
            <p class="lead text-dark mb-0">Découvrez les talents culinaires de Cotonou et contactez-les en un clic !</p>
        </div>
    </div>
</div>
<div class="container py-4">
    <div class="row align-items-center mb-4">
        <div class="col-md-8 text-center text-md-start">
            <h2 class="fw-bold display-6 mb-2" style="color: #198754;"> Exposants Approuvés</h2>
            <p class="text-muted mb-0">Utilisez les filtres pour explorer par secteur ou contactez-les directement.</p>
        </div>
        <div class="col-md-4 text-center text-md-end mt-3 mt-md-0">
            <span class="badge bg-success fs-5 p-3">{{ $exposants->count() }} exposant{{ $exposants->count() > 1 ? 's' : '' }}</span>
        </div>
    </div>
    {{-- Statistiques et filtres --}}
    <div class="row mb-4">
        <div class="col-md-6 mb-2">
            <div class="card border-0 shadow-sm text-center">
                <div class="card-body">
                    <div class="fs-5 fw-bold mb-1" style="color: #198754;">Secteurs représentés :</div>
                    <div>
                        @php $secteurs = $exposants->pluck('secteur')->unique()->filter(); @endphp
                        @forelse($secteurs as $secteur)
                            <span class="badge bg-info text-dark me-1 mb-1">{{ $secteur }}</span>
                        @empty
                            <span class="text-muted">Aucun secteur renseigné</span>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-6 mb-2">
            <div class="card border-0 shadow-sm text-center">
                <div class="card-body">
                    <div class="fs-5 fw-bold mb-1" style="color: #198754;">Contact rapide :</div>
                    <div class="text-muted">Cliquez sur l'email ou le téléphone d'un exposant pour le contacter directement.</div>
                </div>
            </div>
        </div>
    </div>
    @if($exposants->isEmpty())
        <div class="alert alert-warning text-center fs-5">
            Aucun exposant n’est disponible pour le moment.
        </div>
    @else
        <div class="row g-4">
            @foreach($exposants as $exposant)
                @php
                    $isNew = \Carbon\Carbon::parse($exposant->created_at ?? now())->gt(now()->subDays(7));
                    $secteur = $exposant->secteur ?? 'Divers';
                @endphp
                <div class="col-sm-6 col-md-4 col-lg-3">
                    <div class="card h-100 shadow-sm border-0 rounded-4 exposant-card p-0 hover-shadow position-relative overflow-hidden exposant-hover">
                        {{-- Badge secteur --}}
                        <span class="badge bg-info text-dark position-absolute top-0 start-0 m-2">{{ $secteur }}</span>
                        @if($isNew)
                            <span class="badge bg-success position-absolute top-0 end-0 m-2">Nouveau</span>
                        @endif
                        <div class="overflow-hidden" style="border-top-left-radius: 1rem; border-top-right-radius: 1rem;">
                            <img src="https://img.icons8.com/color/192/restaurant-table.png" alt="Stand exposant" class="card-img-top exposant-img w-100" style="height: 140px; object-fit: cover; background: #f8f9fa; transition: transform 0.4s;">
                        </div>
                        <div class="card-body d-flex flex-column">
                            {{-- Nom entreprise --}}
                            <h5 class="card-title fw-bold text-center mb-2" style="color: #198754;">
                                {{ $exposant->nom_entreprise }}
                            </h5>
                            {{-- Email --}}
                            <p class="small mb-1 text-center">
                                <a href="mailto:{{ $exposant->email }}" class="btn btn-sm btn-success px-3 py-1 rounded-pill"><i class="bi bi-envelope me-1"></i>Contacter</a>
                            </p>
                            {{-- Téléphone --}}
                            @if($exposant->telephone)
                            <p class="small mb-2 text-center">
                                <i class="bi bi-telephone text-success me-1"></i>
                                <a href="tel:{{ $exposant->telephone }}" class="text-decoration-none text-dark">
                                    {{ $exposant->telephone }}
                                </a>
                            </p>
                            @endif
                            {{-- Description en popover (si disponible) --}}
                            @if(!empty($exposant->description))
                                <p class="small text-muted mb-2 text-center">
                                    <span tabindex="0" data-bs-toggle="popover" data-bs-trigger="focus" title="Description" data-bs-content="{{ $exposant->description }}">
                                        {{ \Illuminate\Support\Str::limit($exposant->description, 120) }}
                                        @if(strlen($exposant->description) > 120)
                                            <span class="text-success" style="cursor:pointer;">[+]</span>
                                        @endif
                                    </span>
                                </p>
                            @endif
                            {{-- Bouton détails --}}
                            <a href="{{ route('exposants.show', $exposant->id) }}" 
                               class="btn btn-outline-success mt-auto mb-2 w-100">
                                <i class="bi bi-eye"></i> Voir détails
                            </a>
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
            document.querySelectorAll('.exposant-hover').forEach(function(card) {
                card.addEventListener('mouseenter', function() {
                    card.querySelector('.exposant-img').style.transform = 'scale(1.08)';
                    card.classList.add('shadow-lg');
                });
                card.addEventListener('mouseleave', function() {
                    card.querySelector('.exposant-img').style.transform = 'scale(1)';
                    card.classList.remove('shadow-lg');
                });
            });
        </script>
    @endif
</div>
@endsection

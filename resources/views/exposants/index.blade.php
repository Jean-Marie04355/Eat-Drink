@extends('layouts.app')

@section('content')
<div class="container py-5">
    <div class="row align-items-center mb-5">
        <div class="col-md-8 text-center text-md-start">
            <h2 class="fw-bold display-5 text-primary mb-2">🎉 Exposants Approuvés</h2>
            <p class="text-muted mb-0">Découvrez les exposants et leurs spécialités culinaires. Utilisez les filtres pour explorer par secteur ou contactez-les directement.</p>
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
                    <div class="fs-5 fw-bold text-primary mb-1">Secteurs représentés :</div>
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
                    <div class="fs-5 fw-bold text-primary mb-1">Contact rapide :</div>
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
                <div class="col-sm-6 col-md-4 col-lg-3">
                    <div class="card h-100 shadow-sm border-0 rounded-4 exposant-card p-3 hover-shadow position-relative">
                        {{-- Badge secteur --}}
                        @if(!empty($exposant->secteur))
                            <span class="badge bg-info text-dark position-absolute top-0 start-0 m-2">{{ $exposant->secteur }}</span>
                        @endif
                        <div class="card-body d-flex flex-column">
                            {{-- Nom entreprise --}}
                            <h5 class="card-title fw-bold text-center text-primary mb-3">
                                {{ $exposant->nom_entreprise }}
                            </h5>

                            {{-- Email --}}
                            <p class="small mb-1">
                                <i class="bi bi-envelope text-primary me-1"></i>
                                <a href="mailto:{{ $exposant->email }}" class="text-decoration-none text-dark">
                                    {{ $exposant->email }}
                                </a>
                            </p>

                            {{-- Téléphone --}}
                            @if($exposant->telephone)
                            <p class="small mb-2">
                                <i class="bi bi-telephone text-success me-1"></i>
                                <a href="tel:{{ $exposant->telephone }}" class="text-decoration-none text-dark">
                                    {{ $exposant->telephone }}
                                </a>
                            </p>
                            @endif

                            {{-- Description en popover (si disponible) --}}
                            @if(!empty($exposant->description))
                                <p class="small text-muted mb-2">
                                    <span tabindex="0" data-bs-toggle="popover" data-bs-trigger="focus" title="Description" data-bs-content="{{ $exposant->description }}">
                                        {{ \Illuminate\Support\Str::limit($exposant->description, 60) }}
                                        @if(strlen($exposant->description) > 60)
                                            <span class="text-primary" style="cursor:pointer;">[+]</span>
                                        @endif
                                    </span>
                                </p>
                            @endif

                            {{-- Bouton détails --}}
                            <a href="{{ route('exposants.show', $exposant->id) }}" 
                               class="btn btn-outline-primary mt-auto mb-2">
                                <i class="bi bi-eye"></i> Voir détails
                            </a>

                            {{-- Bouton Ajouter au panier d'exposants --}}
                            <form action="{{ route('panier.ajouterExposant', $exposant->id) }}" method="POST">
                                @csrf
                                <button type="submit" class="btn btn-success w-100">
                                    <i class="bi bi-cart-plus"></i> Ajouter au panier
                                </button>
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

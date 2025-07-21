@extends('layouts.app')

@section('content')
<div class="container py-5">
    <h2 class="mb-5 text-center fw-bold text-primary display-5">🎉 Exposants Approuvés</h2>

    @if($exposants->isEmpty())
        <div class="alert alert-warning text-center fs-5">
            Aucun exposant n’est disponible pour le moment.
        </div>
    @else
        <div class="row g-4">
            @foreach($exposants as $exposant)
                <div class="col-sm-6 col-md-4 col-lg-3">
                    <div class="card h-100 shadow-sm border-0 rounded-4 exposant-card p-3 hover-shadow">
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
                                {{ $exposant->telephone }}
                            </p>
                            @endif

                            {{-- Secteur en badge --}}
                            @if(!empty($exposant->secteur))
                                <span class="badge bg-info text-dark w-fit mb-3">
                                    {{ $exposant->secteur }}
                                </span>
                            @endif

                            {{-- Bouton détails --}}
                            <a href="{{ route('exposants.show', $exposant->id) }}" 
                               class="btn btn-outline-primary mt-auto">
                                <i class="bi bi-eye"></i> Voir détails
                            </a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @endif
</div>
@endsection

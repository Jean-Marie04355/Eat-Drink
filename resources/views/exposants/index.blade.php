@extends('layouts.app')
@section('content')
    <div class="container mt-5">
        <h2 class="text-center fw-bold mb-4" style="color: #7b1e3d;">Nos Exposants Approuvés 👨‍🍳</h2>

        @if($exposants->isEmpty())
            <div class="alert text-dark text-center fs-5" style="background-color: #fff8f0; border: 1px solid #5d4037;">
                Aucun exposant n’est disponible pour le moment.
            </div>
        @else
            <div class="row">
                @foreach($exposants as $exposant)
                    <div class="col-md-4 mb-4">
                        <div class="card h-100 shadow-sm">
                            <div class="card-body text-center">
                                <!-- Nom entreprise -->
                                <h5 class="card-title fw-semibold">
                                    {{ $exposant->nom_entreprise }}
                                </h5>
                                <!-- Catégorie du stand -->
                                <p class="text-muted">
                                    {{ $exposant->categorie ?? 'Catégorie non définie' }}
                                </p>
                                <a href="{{ route('exposants.show', $exposant->id) }}" class="btn btn-sm"
                                   style="background-color: #7b1e3d; color: white;">
                                   Voir le stand
                                </a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </div>
@endsection

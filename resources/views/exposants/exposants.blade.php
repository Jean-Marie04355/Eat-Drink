<!-- page publique "Nos Exposants" -->
@extends('layouts.app')
@section('content')
    <div class="container mt-5">
        <h2 class="text-center fw-bold mb-4" style="color: #7b1e3d;">Nos Exposants Approuvés 👨‍🍳</h2>
        <div class="row">
            @foreach($exposants as $stand)
                <div class="col-md-4 mb-4">
                    <div class="card h-100 shadow-sm">
                        <div class="card-body text-center">
                            <h5 class="card-title fw-semibold">{{ $stand['nom'] }}</h5>
                            <p class="text-muted">{{ $stand['categorie'] }}</p>
                            <a href="{{ route('exposants.show', $stand->id) }}" class="btn btn-sm"
                                style="background-color: #7b1e3d; color: white;">Voir le stand</a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
@endsection
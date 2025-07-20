<!-- page publique "Nos Exposants" -->
@extends('layouts.app')
@section('content')
<div class="container">
    <h2>Nos Exposants Approuvés 👨‍🍳</h2>
    <div class="row">
        @foreach($exposants as $stand)
            <div class="col-md-4 mb-3">
                <div class="card h-100">
                    <div class="card-body text-center">
                        <h5>{{ $stand->nom }}</h5>
                        <p>{{ $stand->categorie }}</p>
                        <a href="{{ route('exposants.show', $stand->id) }}" class="btn btn-primary">Voir le stand</a>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</div>
@endsection

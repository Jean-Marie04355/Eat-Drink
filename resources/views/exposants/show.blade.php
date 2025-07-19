<!-- page d’un stand approuvé -->
 @extends('layouts.app')
@section('content')
<div class="container">
    <h2>{{ $stand->nom }}</h2>
    <p><strong>Géré par :</strong> {{ $stand->entrepreneur->nom }}</p>

    <div class="row mt-4">
        @foreach($stand->produits as $produit)
            <div class="col-md-4">
                <div class="card">
                    <div class="card-body text-center">
                        <h5>{{ $produit->nom }}</h5>
                        <p>{{ $produit->description }}</p>
                        <form method="POST" action="{{ route('panier.ajouter', $produit->id) }}">
                            @csrf
                            <button type="submit" class="btn btn-success">Ajouter au panier</button>
                        </form>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</div>
@endsection

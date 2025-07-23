<!--  panier du visiteur -->
 @extends('layouts.app')
@section('content')
<div class="container">
    <h2>Votre panier</h2>
    <ul class="list-group">
        @foreach($panier as $produit)
            <li class="list-group-item d-flex justify-content-between align-items-center">
                {{ $produit->nom }}
                <span class="badge bg-primary rounded-pill">{{ $produit->quantite }}</span>
            </li>
        @endforeach
    </ul>

    <form method="POST" action="{{ route('commande.store') }}" class="mt-4">
        @csrf
        <button class="btn btn-success btn-lg">Passer commande</button>
    </form>
</div>
@endsection

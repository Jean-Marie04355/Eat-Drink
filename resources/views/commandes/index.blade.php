@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Mes commandes</h1>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @forelse($commandes as $commande)
        <div class="card my-3">
            <div class="card-header">
                Commande #{{ $commande->id }} - {{ $commande->created_at->format('d/m/Y H:i') }}
            </div>
            <div class="card-body">
                <ul>
                    @foreach($commande->produits as $produit)
                        <li>
                            {{ $produit->nom }} - Quantité : {{ $produit->pivot->quantite }}
                        </li>
                    @endforeach
                </ul>
            </div>
        </div>
    @empty
        <p>Aucune commande passée.</p>
    @endforelse
</div>
@endsection

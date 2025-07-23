{{-- resources/views/entrepreneur/dashboard.blade.php --}}
@extends('layouts.app')

@section('content')
<div class="container py-5">
    <div class="row align-items-center mb-5">
        <div class="col-md-8 text-center text-md-start">
            <h1 class="display-4 fw-bold text-success mb-2">Bienvenue, {{ Auth::user()->nom_entreprise }} !</h1>
            <p class="lead text-muted mb-3">Gérez vos produits, suivez vos commandes et développez votre activité sur Eat&Drink.</p>
            <div class="mb-3">
                <a href="{{ route('entrepreneur.produits.index') }}" class="btn btn-success btn-lg me-2 mb-2">📦 Gérer mes produits</a>
                <a href="{{ route('exposants.index') }}" class="btn btn-outline-primary btn-lg mb-2">Voir tous les exposants</a>
            </div>
        </div>
        <div class="col-md-4 text-center d-none d-md-block">
            <img src="https://images.unsplash.com/photo-1506744038136-46273834b3fb?auto=format&fit=crop&w=400&q=80" alt="Entrepreneur" class="img-fluid rounded-4 shadow-lg" style="max-height: 180px; object-fit: cover;">
        </div>
    </div>

    <div class="row mb-4">
        <div class="col-md-6">
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-header bg-success text-white">
                    <h5 class="mb-0">Informations du compte</h5>
                </div>
                <div class="card-body">
                    <dl class="row mb-0">
                        <dt class="col-sm-4">Email :</dt>
                        <dd class="col-sm-8">{{ Auth::user()->email }}</dd>
                        <dt class="col-sm-4">Entreprise :</dt>
                        <dd class="col-sm-8">{{ Auth::user()->nom_entreprise }}</dd>
                        <dt class="col-sm-4">Statut :</dt>
                        <dd class="col-sm-8 text-capitalize">
                            @if(Auth::user()->role === 'entrepreneur_approuve')
                                <span class="badge bg-success">Approuvé</span>
                            @elseif(Auth::user()->role === 'entrepreneur_en_attente')
                                <span class="badge bg-warning text-dark">En attente</span>
                            @else
                                <span class="badge bg-secondary">{{ Auth::user()->role }}</span>
                            @endif
                        </dd>
                    </dl>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card border-0 shadow-sm mb-4 h-100">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0">Conseils pour réussir</h5>
                </div>
                <div class="card-body">
                    <ul class="mb-0">
                        <li>Ajoutez régulièrement de nouveaux produits attractifs.</li>
                        <li>Soignez vos descriptions et vos photos.</li>
                        <li>Consultez vos commandes pour suivre vos ventes.</li>
                        <li>Répondez rapidement aux demandes des clients.</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

    {{-- Section commandes du stand --}}
    <div class="card shadow-sm mt-5">
        <div class="card-header bg-primary text-white">
            <h5 class="mb-0">Commandes passées sur votre stand</h5>
        </div>
        <div class="card-body">
            @if($commandes->isEmpty())
                <div class="alert alert-info">Aucune commande n'a encore été passée sur vos produits.</div>
            @else
                <div class="table-responsive">
                    <table class="table table-bordered align-middle">
                        <thead class="table-light">
                            <tr>
                                <th>#</th>
                                <th>Date</th>
                                <th>Produits commandés</th>
                                <th>Total</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($commandes as $commande)
                                <tr>
                                    <td>{{ $commande->id }}</td>
                                    <td>{{ $commande->created_at->format('d/m/Y H:i') }}</td>
                                    <td>
                                        <ul class="mb-0">
                                            @php $total = 0; @endphp
                                            @foreach($commande->produits as $produit)
                                                <li>
                                                    {{ $produit->nom }} - Quantité : {{ $produit->pivot->quantite }}
                                                    @php $total += $produit->prix * $produit->pivot->quantite; @endphp
                                                </li>
                                            @endforeach
                                        </ul>
                                    </td>
                                    <td><strong>{{ number_format($total, 0, ',', ' ') }} FCFA</strong></td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection

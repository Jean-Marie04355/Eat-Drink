@extends('layouts.admin')

@section('content')
<div class="container-fluid px-0 mb-5">
    <div class="position-relative" style="height: 150px; background: linear-gradient(120deg, #198754 60%, #e9f7ef 100%);">
        <div class="position-absolute top-50 start-50 translate-middle w-100 text-center">
            <h2 class="fw-bold display-6 mb-2" style="color: #198754; text-shadow: 0 2px 8px #fff; letter-spacing: 1px; font-family: 'Segoe UI', 'Arial', sans-serif;">
                <i class="bi bi-box-seam me-2"></i>Commandes par entrepreneur
            </h2>
            <span class="badge bg-success fs-6 shadow-sm">{{ $entrepreneurs->count() }} entrepreneurs approuvés</span>
        </div>
    </div>
</div>

<div class="container my-4">
    @if(session('status'))
        <div class="alert alert-success text-center">{{ session('status') }}</div>
    @endif
    
    <div class="mb-4">
        <h4 class="mb-0 text-success">📊 Vue d'ensemble des commandes</h4>
    </div>

    @forelse($entrepreneurs as $entrepreneur)
        <div class="card mb-4 shadow-sm border-0 rounded-5">
            <div class="card-header bg-success text-white rounded-top-5 d-flex justify-content-between align-items-center">
                <div>
                    <h5 class="mb-0 fw-bold">{{ $entrepreneur->nom_entreprise }}</h5>
                    <small class="text-light">{{ $entrepreneur->email }}</small>
                </div>
                <div class="text-end">
                    <span class="badge bg-light text-success fs-6">{{ $entrepreneur->produits->count() }} produits</span>
                </div>
            </div>
            <div class="card-body bg-light rounded-bottom-5">
                @php
                    $commandes = collect();
                    foreach($entrepreneur->produits as $produit) {
                        foreach($produit->commandes as $commande) {
                            $commandes->push($commande);
                        }
                    }
                    $commandes = $commandes->unique('id');
                @endphp
                
                @if($commandes->isEmpty())
                    <div class="alert alert-info rounded-4">
                        <i class="bi bi-info-circle me-2"></i>
                        Aucune commande pour cet entrepreneur.
                    </div>
                @else
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <div class="card bg-success text-white">
                                <div class="card-body text-center">
                                    <h6 class="card-title">Total des commandes</h6>
                                    <h3 class="mb-0">{{ $commandes->count() }}</h3>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="card bg-info text-white">
                                <div class="card-body text-center">
                                    <h6 class="card-title">Produits vendus</h6>
                                    <h3 class="mb-0">{{ $entrepreneur->produits->sum(function($produit) { return $produit->commandes->sum('pivot.quantite'); }) }}</h3>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="table-responsive">
                        <table class="table table-bordered align-middle bg-white rounded-4 overflow-hidden">
                            <thead class="table-success">
                                <tr>
                                    <th># Commande</th>
                                    <th>Date</th>
                                    <th>Produits commandés</th>
                                    <th>Total</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($commandes as $commande)
                                    <tr>
                                        <td class="fw-bold">{{ $commande->id }}</td>
                                        <td>{{ $commande->created_at->format('d/m/Y H:i') }}</td>
                                        <td>
                                            <ul class="mb-0">
                                                @foreach($commande->produits as $produit)
                                                    @if($produit->user_id == $entrepreneur->id)
                                                        <li>
                                                            <strong>{{ $produit->nom }}</strong> 
                                                            - Quantité : {{ $produit->pivot->quantite ?? 'N/A' }}
                                                            @if($produit->prix)
                                                                <span class="text-muted">({{ number_format($produit->prix, 0) }} FCFA)</span>
                                                            @endif
                                                        </li>
                                                    @endif
                                                @endforeach
                                            </ul>
                                        </td>
                                        <td class="fw-bold text-success">
                                            @php
                                                $total = 0;
                                                foreach($commande->produits as $produit) {
                                                    if($produit->user_id == $entrepreneur->id && $produit->prix && $produit->pivot && $produit->pivot->quantite) {
                                                        $total += $produit->prix * $produit->pivot->quantite;
                                                    }
                                                }
                                            @endphp
                                            {{ number_format($total, 0) }} FCFA
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @endif
            </div>
        </div>
    @empty
        <div class="text-center py-5">
            <img src="https://img.icons8.com/color/96/manager.png" alt="Aucun entrepreneur" class="mb-3" style="opacity:0.7;">
            <h5 class="text-muted">Aucun entrepreneur approuvé.</h5>
            <p class="text-muted">Les entrepreneurs approuvés apparaîtront ici avec leurs commandes.</p>
        </div>
    @endforelse
</div>

<style>
    .card.rounded-5, .rounded-5 { border-radius: 1.5rem !important; }
    .table.rounded-4 { border-radius: 1.2rem !important; overflow: hidden; }
    .card-header.rounded-top-5 { border-top-left-radius: 1.5rem !important; border-top-right-radius: 1.5rem !important; }
    .card-body.rounded-bottom-5 { border-bottom-left-radius: 1.5rem !important; border-bottom-right-radius: 1.5rem !important; }
</style>
@endsection 
@extends('layouts.app')

@section('content')
<div class="container py-4">
    <h1 class="mb-4 fw-bold text-center" style="color: #7b1e3d;">🧾 Mes commandes</h1>

    @if(session('success'))
        <div class="alert alert-success text-center">{{ session('success') }}</div>
    @endif

    @forelse($commandes as $commande)
        <div class="card shadow-sm mb-4 border-0 rounded-4">
            <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                <span>Commande <strong>#{{ $commande->id }}</strong></span>
                <span class="fw-light">{{ $commande->created_at->format('d/m/Y H:i') }}</span>
            </div>
            <div class="card-body bg-light">
                <div class="table-responsive">
                    <table class="table align-middle table-bordered table-hover bg-white mb-0">
                        <thead class="table-secondary">
                            <tr class="text-center">
                                <th>Image</th>
                                <th>Produit</th>
                                <th>Description</th>
                                <th>Prix unitaire</th>
                                <th>Quantité</th>
                                <th>Total</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php $totalCommande = 0; @endphp
                            @foreach($commande->produits as $produit)
                                @php $sousTotal = $produit->prix * $produit->pivot->quantite; $totalCommande += $sousTotal; @endphp
                                <tr class="text-center">
                                    <td style="width: 90px;">
                                        @if($produit->photo)
                                            <img src="{{ asset('storage/' . $produit->photo) }}" alt="Image de {{ $produit->nom }}" class="img-fluid rounded" style="height: 60px; width: 80px; object-fit: cover;">
                                        @else
                                            <img src="https://via.placeholder.com/80x60?text=Pas+de+photo" class="img-fluid rounded" alt="Pas d'image">
                                        @endif
                                    </td>
                                    <td class="fw-semibold">{{ $produit->nom }}</td>
                                    <td class="text-muted small">{{ \Illuminate\Support\Str::limit($produit->description, 60) }}</td>
                                    <td>{{ number_format($produit->prix, 0, ',', ' ') }} FCFA</td>
                                    <td>{{ $produit->pivot->quantite }}</td>
                                    <td class="fw-bold">{{ number_format($sousTotal, 0, ',', ' ') }} FCFA</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="d-flex justify-content-end align-items-center mt-3">
                    <span class="fs-5 fw-bold">Total de la commande : <span class="text-success">{{ number_format($totalCommande, 0, ',', ' ') }} FCFA</span></span>
                </div>
            </div>
        </div>
    @empty
        <div class="alert alert-info text-center mt-5">Aucune commande passée.</div>
    @endforelse
</div>
@endsection

@extends('layouts.app')

@section('content')
<div class="container-fluid px-0 mb-5">
    <div class="position-relative" style="height: 180px; background: linear-gradient(120deg, #198754 60%, #e9f7ef 100%);">
        <img src="https://images.unsplash.com/photo-1504674900247-0877df9cc836?auto=format&fit=crop&w=1200&q=80" alt="Panier" class="w-100 h-100 object-fit-cover position-absolute top-0 start-0" style="opacity: 0.18; object-fit: cover;">
        <div class="position-absolute top-50 start-50 translate-middle text-center w-100">
            <h2 class="fw-bold display-6 mb-2" style="color: #198754; text-shadow: 0 2px 8px #fff;">
                <i class="bi bi-cart4 me-2"></i>Votre panier
            </h2>
            <p class="text-dark mb-0">{{ count($panier) }} article{{ count($panier) > 1 ? 's' : '' }} dans votre sélection</p>
        </div>
    </div>
</div>
<div class="container py-4">
    @if(session('success'))
        <div class="alert alert-success text-center">{{ session('success') }}</div>
    @endif
    @if(count($panier) > 0)
        <div class="table-responsive">
            <table class="table align-middle table-hover bg-white shadow-sm rounded-4 overflow-hidden">
                <thead class="table-success">
                    <tr class="text-center align-middle">
                        <th style="width: 90px;">Image</th>
                        <th>Produit</th>
                        <th>Prix</th>
                        <th>Quantité</th>
                        <th>Total</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @php $total = 0; @endphp
                    @foreach($panier as $id => $item)
                        <tr class="align-middle text-center panier-row">
                            <td>
                                @if(!empty($item['photo']))
                                    <img src="{{ asset('storage/' . $item['photo']) }}" alt="{{ $item['nom'] }}" class="img-fluid rounded" style="height: 60px; width: 80px; object-fit: cover;">
                                @else
                                    <img src="https://img.icons8.com/color/96/meal.png" alt="Pas d'image" class="img-fluid rounded" style="height: 60px; width: 80px; object-fit: cover; background: #f8f9fa;">
                                @endif
                            </td>
                            <td class="fw-semibold">{{ $item['nom'] }}</td>
                            <td>{{ number_format($item['prix'], 0, ',', ' ') }} FCFA</td>
                            <td>
                                <div class="d-flex align-items-center justify-content-center gap-2">
                                    <form action="{{ route('panier.ajouter', $id) }}" method="POST" style="display:inline;">
                                        @csrf
                                        <button type="submit" class="btn btn-sm btn-outline-success rounded-circle px-2 py-1">+</button>
                                    </form>
                                    <span class="mx-2">{{ $item['quantite'] }}</span>
                                    <form action="{{ route('panier.retirer', $id) }}" method="POST" style="display:inline;">
                                        @csrf
                                        <button type="submit" class="btn btn-sm btn-outline-danger rounded-circle px-2 py-1">-</button>
                                    </form>
                                </div>
                            </td>
                            <td class="fw-bold">{{ number_format($item['prix'] * $item['quantite'], 0, ',', ' ') }} FCFA</td>
                            <td>
                                <form action="{{ route('panier.retirer', $id) }}" method="POST" style="display:inline;">
                                    @csrf
                                    <button type="submit" class="btn btn-sm btn-danger rounded-pill">Supprimer</button>
                                </form>
                            </td>
                        </tr>
                        @php $total += $item['prix'] * $item['quantite']; @endphp
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="d-flex flex-column flex-md-row justify-content-between align-items-center mt-4 p-4 bg-light rounded-4 shadow-sm gap-3">
            <h4 class="mb-0">Total : <span class="text-success">{{ number_format($total, 0, ',', ' ') }} FCFA</span></h4>
            <form action="{{ route('commandes.store') }}" method="POST" class="mb-0">
                @csrf
                <button type="submit" class="btn btn-lg btn-success px-5 py-2 shadow-sm transition-all" style="font-size: 1.2rem; transition: background 0.2s, box-shadow 0.2s;">
                    <i class="bi bi-bag-check me-2"></i>Passer la commande
                </button>
            </form>
        </div>
    @else
        <div class="text-center py-5">
            <img src="https://img.icons8.com/color/96/empty-box.png" alt="Panier vide" class="mb-3" style="opacity:0.7;">
            <h5 class="text-muted">Votre panier est vide.</h5>
        </div>
    @endif
</div>
<script>
    // Effet de survol pro sur la ligne
    document.querySelectorAll('.panier-row').forEach(function(row) {
        row.addEventListener('mouseenter', function() {
            row.classList.add('table-success');
        });
        row.addEventListener('mouseleave', function() {
            row.classList.remove('table-success');
        });
    });
</script>
@endsection

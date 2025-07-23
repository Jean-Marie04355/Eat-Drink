@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Mon panier</h2>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @if(count($panier) > 0)
        <div class="table-responsive">
            <table class="table align-middle table-bordered table-hover bg-white shadow-sm">
                <thead class="table-primary">
                    <tr>
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
                        <tr>
                            <td class="fw-semibold">{{ $item['nom'] }}</td>
                            <td>{{ number_format($item['prix'], 0, ',', ' ') }} FCFA</td>
                            <td>
                                <div class="d-flex align-items-center gap-2">
                                    <form action="{{ route('panier.ajouter', $id) }}" method="POST" style="display:inline;">
                                        @csrf
                                        <button type="submit" class="btn btn-sm btn-outline-success">+</button>
                                    </form>
                                    <span class="mx-2">{{ $item['quantite'] }}</span>
                                    <form action="{{ route('panier.retirer', $id) }}" method="POST" style="display:inline;">
                                        @csrf
                                        <button type="submit" class="btn btn-sm btn-outline-danger">-</button>
                                    </form>
                                </div>
                            </td>
                            <td>{{ number_format($item['prix'] * $item['quantite'], 0, ',', ' ') }} FCFA</td>
                            <td>
                                <form action="{{ route('panier.retirer', $id) }}" method="POST" style="display:inline;">
                                    @csrf
                                    <button type="submit" class="btn btn-sm btn-danger">Supprimer</button>
                                </form>
                            </td>
                        </tr>
                        @php $total += $item['prix'] * $item['quantite']; @endphp
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="d-flex justify-content-between align-items-center mt-4 p-3 bg-light rounded shadow-sm">
            <h4 class="mb-0">Total : <span class="text-success">{{ number_format($total, 0, ',', ' ') }} FCFA</span></h4>
            <form action="{{ route('commandes.store') }}" method="POST" class="mb-0">
                @csrf
                <button type="submit" class="btn btn-lg btn-success px-4">Passer la commande</button>
            </form>
        </div>
    @else
        <div class="alert alert-info mt-4">Votre panier est vide.</div>
    @endif
</div>
@endsection

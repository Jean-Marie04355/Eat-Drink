@extends('layouts.app')

@section('content')
<div class="container-fluid px-0 mb-5">
    <div class="position-relative" style="height: 150px; background: linear-gradient(120deg, #198754 60%, #e9f7ef 100%);">
        <div class="position-absolute top-50 start-50 translate-middle w-100 text-center">
            <h2 class="fw-bold display-6 mb-2" style="color: #198754; text-shadow: 0 2px 8px #fff; letter-spacing: 1px; font-family: 'Segoe UI', 'Arial', sans-serif;">
                <i class="bi bi-person-check me-2"></i>Demandes en attente d'approbation
            </h2>
            <span class="badge bg-success fs-6 shadow-sm">{{ $demandes->count() }} en attente</span>
        </div>
    </div>
</div>
<div class="container my-4">
    @if(session('status'))
        <div class="alert alert-success text-center">{{ session('status') }}</div>
    @endif
    @if($demandes->isEmpty())
        <div class="text-center py-5">
            <img src="https://img.icons8.com/color/96/approval.png" alt="Aucune demande" class="mb-3" style="opacity:0.7;">
            <h5 class="text-muted">Aucune demande en attente.</h5>
        </div>
    @else
        <div class="table-responsive">
            <table class="table table-hover align-middle text-center shadow-sm rounded-4 overflow-hidden" style="background: #fff;">
                <thead class="table-success">
                    <tr>
                        <th scope="col">📧 Email</th>
                        <th scope="col">🏢 Entreprise</th>
                        <th scope="col">⚙️ Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($demandes as $user)
                        <tr class="admin-row">
                            <td><span class="badge bg-secondary rounded-pill px-3 py-2">{{ $user->email }}</span></td>
                            <td class="fw-bold" style="color:#198754;">{{ $user->nom_entreprise }}</td>
                            <td>
                                <form method="POST" action="{{ route('admin.approuver', $user->id) }}" class="d-inline">
                                    @csrf
                                    <button type="submit" class="btn btn-success btn-sm rounded-pill px-3 shadow-sm">
                                        ✔️ Approuver
                                    </button>
                                </form>
                                <button type="button" class="btn btn-danger btn-sm rounded-pill px-3 shadow-sm ms-2" onclick="toggleRejectForm({{ $user->id }})">
                                    ❌ Rejeter
                                </button>
                                <div id="reject-form-{{ $user->id }}" class="mt-2 d-none">
                                    <form method="POST" action="{{ route('admin.rejeter', $user->id) }}">
                                        @csrf
                                        <textarea name="motif_rejet" class="form-control my-2 rounded-4" rows="2" placeholder="Motif du rejet..." required></textarea>
                                        <button type="submit" class="btn btn-outline-danger btn-sm rounded-pill px-3">Confirmer rejet</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @endif
</div>
<div class="container my-5">
    <h2 class="mb-4 text-center" style="color:#198754; font-family: 'Segoe UI', 'Arial', sans-serif;">📦 Commandes par entrepreneur</h2>
    @forelse($entrepreneurs as $entrepreneur)
        <div class="card mb-4 shadow-sm border-0 rounded-5">
            <div class="card-header bg-success text-white rounded-top-5 d-flex justify-content-between align-items-center">
                <h5 class="mb-0 fw-bold">{{ $entrepreneur->nom_entreprise }}</h5>
                <span class="badge bg-light text-success fs-6">{{ $entrepreneur->email }}</span>
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
                    <div class="alert alert-info rounded-4">Aucune commande pour cet entrepreneur.</div>
                @else
                    <div class="table-responsive">
                        <table class="table table-bordered align-middle bg-white rounded-4 overflow-hidden">
                            <thead class="table-success">
                                <tr>
                                    <th>#</th>
                                    <th>Date</th>
                                    <th>Produits commandés</th>
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
                                                        <li>{{ $produit->nom }} - Quantité : {{ $produit->pivot->quantite }}</li>
                                                    @endif
                                                @endforeach
                                            </ul>
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
        </div>
    @endforelse
</div>
<style>
    .admin-row { transition: background 0.2s; }
    .admin-row:hover { background: #e9f7ef !important; }
    .card.rounded-5, .rounded-5 { border-radius: 1.5rem !important; }
    .table.rounded-4, .table.rounded-5 { border-radius: 1.2rem !important; overflow: hidden; }
</style>
<script>
    function toggleRejectForm(userId) {
        const form = document.getElementById('reject-form-' + userId);
        form.classList.toggle('d-none');
    }
</script>
@endsection

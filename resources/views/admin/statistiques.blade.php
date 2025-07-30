@extends('layouts.admin')

@section('content')
<div class="container-fluid px-4 py-4">
    <div class="row mb-4">
        <div class="col-12">
            <h1 class="h3 mb-0 text-success">
                <i class="bi bi-graph-up me-2"></i>Tableau de bord - Statistiques
            </h1>
            <p class="text-muted">Vue d'ensemble de l'activité de la plateforme</p>
        </div>
    </div>

    <!-- Statistiques générales -->
    <div class="row mb-4">
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-success shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                Entrepreneurs approuvés
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $stats['entrepreneurs_approuves'] }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="bi bi-person-check fa-2x text-success"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-primary shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                Demandes en attente
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $stats['demandes_attente'] }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="bi bi-clock-history fa-2x text-primary"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-info shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-info text-uppercase mb-1">
                                Total des commandes
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $stats['total_commandes'] }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="bi bi-box-seam fa-2x text-info"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-warning shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                                Produits disponibles
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $stats['total_produits'] }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="bi bi-bag fa-2x text-warning"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Graphiques et détails -->
    <div class="row">
        <!-- Top entrepreneurs -->
        <div class="col-xl-6 col-lg-7">
            <div class="card shadow mb-4">
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                    <h6 class="m-0 font-weight-bold text-success">Top 5 des entrepreneurs</h6>
                </div>
                <div class="card-body">
                    @if($top_entrepreneurs->isEmpty())
                        <div class="text-center py-4">
                            <i class="bi bi-graph-down text-muted" style="font-size: 3rem;"></i>
                            <p class="text-muted mt-2">Aucun entrepreneur avec des commandes</p>
                        </div>
                    @else
                        @foreach($top_entrepreneurs as $index => $entrepreneur)
                            <div class="d-flex justify-content-between align-items-center mb-3 p-3 rounded" style="background: {{ $index % 2 == 0 ? '#f8f9fa' : 'white' }}">
                                <div class="d-flex align-items-center">
                                    <div class="bg-success text-white rounded-circle d-flex align-items-center justify-content-center me-3" style="width: 40px; height: 40px;">
                                        <span class="fw-bold">{{ $index + 1 }}</span>
                                    </div>
                                    <div>
                                        <h6 class="mb-0 fw-bold">{{ $entrepreneur->nom_entreprise }}</h6>
                                        <small class="text-muted">{{ $entrepreneur->email }}</small>
                                    </div>
                                </div>
                                <div class="text-end">
                                    <div class="fw-bold text-success">{{ $entrepreneur->total_commandes }} commandes</div>
                                    <small class="text-muted">{{ number_format($entrepreneur->total_ventes, 0) }} FCFA</small>
                                </div>
                            </div>
                        @endforeach
                    @endif
                </div>
            </div>
        </div>

        <!-- Statistiques récentes -->
        <div class="col-xl-6 col-lg-5">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-success">Activité récente</h6>
                </div>
                <div class="card-body">
                    <div class="mb-4">
                        <h6 class="text-success mb-3">
                            <i class="bi bi-calendar-event me-2"></i>Cette semaine
                        </h6>
                        <div class="row text-center">
                            <div class="col-6">
                                <div class="border rounded p-3">
                                    <div class="h4 text-success mb-0">{{ $stats['commandes_semaine'] }}</div>
                                    <small class="text-muted">Nouvelles commandes</small>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="border rounded p-3">
                                    <div class="h4 text-primary mb-0">{{ $stats['nouveaux_entrepreneurs'] }}</div>
                                    <small class="text-muted">Nouveaux entrepreneurs</small>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="mb-4">
                        <h6 class="text-success mb-3">
                            <i class="bi bi-calendar-month me-2"></i>Ce mois
                        </h6>
                        <div class="row text-center">
                            <div class="col-6">
                                <div class="border rounded p-3">
                                    <div class="h4 text-info mb-0">{{ $stats['commandes_mois'] }}</div>
                                    <small class="text-muted">Commandes totales</small>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="border rounded p-3">
                                    <div class="h4 text-warning mb-0">{{ number_format($stats['chiffre_affaires_mois'], 0) }}</div>
                                    <small class="text-muted">FCFA générés</small>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Tableau des dernières activités -->
    <div class="row">
        <div class="col-12">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-success">Dernières activités</h6>
                </div>
                <div class="card-body">
                    @if($activites_recentes->isEmpty())
                        <div class="text-center py-4">
                            <i class="bi bi-activity text-muted" style="font-size: 3rem;"></i>
                            <p class="text-muted mt-2">Aucune activité récente</p>
                        </div>
                    @else
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead class="table-success">
                                    <tr>
                                        <th>Date</th>
                                        <th>Entrepreneur</th>
                                        <th>Action</th>
                                        <th>Détails</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($activites_recentes as $activite)
                                        <tr>
                                            <td>{{ $activite->created_at->format('d/m/Y H:i') }}</td>
                                            <td class="fw-bold">{{ $activite->nom_entreprise }}</td>
                                            <td>
                                                @if($activite->type === 'commande')
                                                    <span class="badge bg-info">Nouvelle commande</span>
                                                @elseif($activite->type === 'approbation')
                                                    <span class="badge bg-success">Entrepreneur approuvé</span>
                                                @elseif($activite->type === 'produit')
                                                    <span class="badge bg-warning">Nouveau produit</span>
                                                @endif
                                            </td>
                                            <td>{{ $activite->details }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

@push('styles')
<style>
    .border-left-success {
        border-left: 0.25rem solid #198754 !important;
    }
    .border-left-primary {
        border-left: 0.25rem solid #0d6efd !important;
    }
    .border-left-info {
        border-left: 0.25rem solid #0dcaf0 !important;
    }
    .border-left-warning {
        border-left: 0.25rem solid #ffc107 !important;
    }
    .text-gray-800 {
        color: #5a5c69 !important;
    }
    .text-xs {
        font-size: 0.7rem;
    }
</style>
@endpush
@endsection 
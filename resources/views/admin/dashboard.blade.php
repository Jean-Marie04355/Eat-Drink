@extends('layouts.admin')

@section('content')
<div class="container-fluid px-4 py-4">
    <!-- En-tête avec statistiques -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <div>
                    <h1 class="h3 mb-0 text-success">
                        <i class="bi bi-person-check me-2"></i>Gestion des demandes d'approbation
                    </h1>
                    <p class="text-muted mb-0">Surveillez et gérez les demandes des entrepreneurs</p>
                </div>
                <div class="d-flex gap-2">
                    <button class="btn btn-outline-success" onclick="refreshData()">
                        <i class="bi bi-arrow-clockwise me-2"></i>Actualiser
                    </button>
                    <button class="btn btn-outline-info" onclick="exportData()">
                        <i class="bi bi-download me-2"></i>Exporter
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Statistiques rapides -->
    <div class="row mb-4">
        <div class="col-xl-3 col-md-6 mb-3">
            <div class="card border-left-primary shadow h-100">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                Demandes en attente
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $demandes->count() }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="bi bi-clock-history fa-2x text-primary"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6 mb-3">
            <div class="card border-left-success shadow h-100">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                Approuvés aujourd'hui
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800" id="approvedToday">0</div>
                        </div>
                        <div class="col-auto">
                            <i class="bi bi-check-circle fa-2x text-success"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6 mb-3">
            <div class="card border-left-danger shadow h-100">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-danger text-uppercase mb-1">
                                Rejetés aujourd'hui
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800" id="rejectedToday">0</div>
                        </div>
                        <div class="col-auto">
                            <i class="bi bi-x-circle fa-2x text-danger"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6 mb-3">
            <div class="card border-left-info shadow h-100">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-info text-uppercase mb-1">
                                Temps moyen d'attente
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800" id="avgWaitTime">2.5h</div>
                        </div>
                        <div class="col-auto">
                            <i class="bi bi-stopwatch fa-2x text-info"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Messages de statut -->
    @if(session('status'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="bi bi-check-circle me-2"></i>{{ session('status') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <i class="bi bi-exclamation-triangle me-2"></i>{{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <!-- Filtres et recherche -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card shadow">
                <div class="card-header bg-light">
                    <h6 class="mb-0"><i class="bi bi-funnel me-2"></i>Filtres et recherche</h6>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-4 mb-3">
                            <label class="form-label">Rechercher</label>
                            <input type="text" id="searchInput" class="form-control" placeholder="Email ou nom d'entreprise...">
                        </div>
                        <div class="col-md-3 mb-3">
                            <label class="form-label">Trier par</label>
                            <select id="sortSelect" class="form-select">
                                <option value="date_desc">Date (récent)</option>
                                <option value="date_asc">Date (ancien)</option>
                                <option value="email_asc">Email A-Z</option>
                                <option value="email_desc">Email Z-A</option>
                                <option value="entreprise_asc">Entreprise A-Z</option>
                            </select>
                        </div>
                        <div class="col-md-3 mb-3">
                            <label class="form-label">Statut</label>
                            <select id="statusFilter" class="form-select">
                                <option value="all">Tous</option>
                                <option value="new">Nouvelles demandes</option>
                                <option value="old">Anciennes demandes</option>
                            </select>
                        </div>
                        <div class="col-md-2 mb-3">
                            <label class="form-label">&nbsp;</label>
                            <button class="btn btn-primary w-100" onclick="applyFilters()">
                                <i class="bi bi-search me-2"></i>Filtrer
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Liste des demandes -->
    <div class="row">
        <div class="col-12">
            <div class="card shadow">
                <div class="card-header bg-success text-white d-flex justify-content-between align-items-center">
                    <h6 class="mb-0"><i class="bi bi-list-ul me-2"></i>Demandes en attente</h6>
                    <span class="badge bg-light text-success fs-6">{{ $demandes->count() }} demandes</span>
                </div>
                <div class="card-body p-0">
                    @if($demandes->isEmpty())
                        <div class="text-center py-5">
                            <div class="mb-3">
                                <i class="bi bi-check-circle text-success" style="font-size: 4rem; opacity: 0.7;"></i>
                            </div>
                            <h5 class="text-muted mb-2">Aucune demande en attente</h5>
                            <p class="text-muted">Toutes les demandes ont été traitées !</p>
                        </div>
                    @else
                        <div class="table-responsive">
                            <table class="table table-hover mb-0" id="demandesTable">
                                <thead class="table-success">
                                    <tr>
                                        <th scope="col" class="text-center">
                                            <input type="checkbox" id="selectAll" class="form-check-input">
                                        </th>
                                        <th scope="col">📧 Email</th>
                                        <th scope="col">🏢 Entreprise</th>
                                        <th scope="col">📅 Date de demande</th>
                                        <th scope="col">⏱️ Temps d'attente</th>
                                        <th scope="col">⚙️ Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($demandes as $user)
                                        <tr class="demande-row" data-id="{{ $user->id }}">
                                            <td class="text-center">
                                                <input type="checkbox" class="form-check-input demande-checkbox" value="{{ $user->id }}">
                                            </td>
                                            <td>
                                                <div class="d-flex align-items-center">
                                                    <div class="avatar-sm me-3">
                                                        <div class="bg-primary rounded-circle d-flex align-items-center justify-content-center" style="width: 40px; height: 40px;">
                                                            <span class="text-white fw-bold">{{ strtoupper(substr($user->email, 0, 1)) }}</span>
                                                        </div>
                                                    </div>
                                                    <div>
                                                        <div class="fw-bold">{{ $user->email }}</div>
                                                        <small class="text-muted">Demande #{{ $user->id }}</small>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="fw-bold text-success">{{ $user->nom_entreprise }}</div>
                                                <small class="text-muted">Entrepreneur</small>
                                            </td>
                                            <td>
                                                <div>{{ $user->created_at->format('d/m/Y') }}</div>
                                                <small class="text-muted">{{ $user->created_at->format('H:i') }}</small>
                                            </td>
                                            <td>
                                                @php
                                                    $waitTime = $user->created_at->diff(now());
                                                    $waitHours = $waitTime->h + ($waitTime->days * 24);
                                                @endphp
                                                <div class="d-flex align-items-center">
                                                    <span class="badge bg-{{ $waitHours > 24 ? 'danger' : ($waitHours > 12 ? 'warning' : 'success') }} me-2">
                                                        {{ $waitHours }}h
                                                    </span>
                                                    <small class="text-muted">{{ $waitTime->format('%d jours, %h heures') }}</small>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="btn-group" role="group">
                                                                                                         <button type="button" class="btn btn-success btn-sm" onclick="approveUser('{{ $user->id }}')">
                                                         <i class="bi bi-check-lg me-1"></i>Approuver
                                                     </button>
                                                     <button type="button" class="btn btn-danger btn-sm" onclick="showRejectModal('{{ $user->id }}')">
                                                         <i class="bi bi-x-lg me-1"></i>Rejeter
                                                     </button>
                                                     <button type="button" class="btn btn-info btn-sm" onclick="viewDetails('{{ $user->id }}')">
                                                         <i class="bi bi-eye me-1"></i>Détails
                                                     </button>
                                                </div>
                                            </td>
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

    <!-- Actions en lot -->
    <div class="row mt-4" id="bulkActions" style="display: none;">
        <div class="col-12">
            <div class="card shadow">
                <div class="card-header bg-warning text-dark">
                    <h6 class="mb-0"><i class="bi bi-gear me-2"></i>Actions en lot</h6>
                </div>
                <div class="card-body">
                    <div class="d-flex gap-2">
                        <button class="btn btn-success" onclick="bulkApprove()">
                            <i class="bi bi-check-lg me-2"></i>Approuver la sélection
                        </button>
                        <button class="btn btn-danger" onclick="bulkReject()">
                            <i class="bi bi-x-lg me-2"></i>Rejeter la sélection
                        </button>
                        <span class="text-muted align-self-center ms-3">
                            <span id="selectedCount">0</span> demandes sélectionnées
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal de rejet -->
<div class="modal fade" id="rejectModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-danger text-white">
                <h5 class="modal-title">
                    <i class="bi bi-exclamation-triangle me-2"></i>Rejeter la demande
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <p>Êtes-vous sûr de vouloir rejeter cette demande ?</p>
                <form id="rejectForm">
                    <input type="hidden" id="rejectUserId" name="user_id">
                    <div class="mb-3">
                        <label for="motifRejet" class="form-label">Motif du rejet *</label>
                        <textarea class="form-control" id="motifRejet" name="motif_rejet" rows="4" 
                                  placeholder="Expliquez les raisons du rejet..." required></textarea>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                <button type="button" class="btn btn-danger" onclick="confirmReject()">
                    <i class="bi bi-x-lg me-2"></i>Confirmer le rejet
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Modal de détails -->
<div class="modal fade" id="detailsModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-info text-white">
                <h5 class="modal-title">
                    <i class="bi bi-info-circle me-2"></i>Détails de la demande
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body" id="detailsContent">
                <!-- Le contenu sera chargé dynamiquement -->
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fermer</button>
            </div>
        </div>
    </div>
</div>

<style>
    .border-left-primary { border-left: 0.25rem solid #0d6efd !important; }
    .border-left-success { border-left: 0.25rem solid #198754 !important; }
    .border-left-danger { border-left: 0.25rem solid #dc3545 !important; }
    .border-left-info { border-left: 0.25rem solid #0dcaf0 !important; }
    .text-gray-800 { color: #5a5c69 !important; }
    .text-xs { font-size: 0.7rem; }
    
    .demande-row { transition: all 0.2s ease; }
    .demande-row:hover { background-color: #f8f9fa !important; transform: translateY(-1px); }
    
    .avatar-sm { width: 40px; height: 40px; }
    
    .btn-group .btn { border-radius: 0.375rem !important; }
    .btn-group .btn:first-child { border-top-left-radius: 0.375rem !important; border-bottom-left-radius: 0.375rem !important; }
    .btn-group .btn:last-child { border-top-right-radius: 0.375rem !important; border-bottom-right-radius: 0.375rem !important; }
</style>

<script>
// Variables globales
let selectedDemandes = new Set();
let currentFilters = {};

// Initialisation
document.addEventListener('DOMContentLoaded', function() {
    setupEventListeners();
    updateStats();
});

// Configuration des événements
function setupEventListeners() {
    // Sélection globale
    document.getElementById('selectAll').addEventListener('change', function() {
        const checkboxes = document.querySelectorAll('.demande-checkbox');
        checkboxes.forEach(checkbox => {
            checkbox.checked = this.checked;
            if (this.checked) {
                selectedDemandes.add(checkbox.value);
            } else {
                selectedDemandes.delete(checkbox.value);
            }
        });
        updateBulkActions();
    });

    // Sélection individuelle
    document.querySelectorAll('.demande-checkbox').forEach(checkbox => {
        checkbox.addEventListener('change', function() {
            if (this.checked) {
                selectedDemandes.add(this.value);
            } else {
                selectedDemandes.delete(this.value);
            }
            updateBulkActions();
        });
    });
}

// Mise à jour des actions en lot
function updateBulkActions() {
    const bulkActions = document.getElementById('bulkActions');
    const selectedCount = document.getElementById('selectedCount');
    
    if (selectedDemandes.size > 0) {
        bulkActions.style.display = 'block';
        selectedCount.textContent = selectedDemandes.size;
    } else {
        bulkActions.style.display = 'none';
    }
}

// Approuver un utilisateur
function approveUser(userId) {
    if (confirm('Êtes-vous sûr de vouloir approuver cette demande ?')) {
        const form = document.createElement('form');
        form.method = 'POST';
        form.action = `/dashboard/approuver/${userId}`;
        
        const csrfToken = document.createElement('input');
        csrfToken.type = 'hidden';
        csrfToken.name = '_token';
        csrfToken.value = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
        
        form.appendChild(csrfToken);
        document.body.appendChild(form);
        form.submit();
    }
}

// Afficher le modal de rejet
function showRejectModal(userId) {
    document.getElementById('rejectUserId').value = userId;
    const modal = new bootstrap.Modal(document.getElementById('rejectModal'));
    modal.show();
}

// Confirmer le rejet
function confirmReject() {
    const userId = document.getElementById('rejectUserId').value;
    const motif = document.getElementById('motifRejet').value;
    
    if (!motif.trim()) {
        alert('Veuillez saisir un motif de rejet.');
        return;
    }
    
    const form = document.createElement('form');
    form.method = 'POST';
    form.action = `/dashboard/rejeter/${userId}`;
    
    const csrfToken = document.createElement('input');
    csrfToken.type = 'hidden';
    csrfToken.name = '_token';
    csrfToken.value = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
    
    const motifInput = document.createElement('input');
    motifInput.type = 'hidden';
    motifInput.name = 'motif_rejet';
    motifInput.value = motif;
    
    form.appendChild(csrfToken);
    form.appendChild(motifInput);
    document.body.appendChild(form);
    form.submit();
}

// Voir les détails
function viewDetails(userId) {
    // Ici on pourrait charger les détails via AJAX
    const modal = new bootstrap.Modal(document.getElementById('detailsModal'));
    document.getElementById('detailsContent').innerHTML = `
        <div class="text-center py-4">
            <i class="bi bi-info-circle text-info" style="font-size: 3rem;"></i>
            <h5 class="mt-3">Détails de la demande #${userId}</h5>
            <p class="text-muted">Fonctionnalité en cours de développement...</p>
        </div>
    `;
    modal.show();
}

// Appliquer les filtres
function applyFilters() {
    const search = document.getElementById('searchInput').value;
    const sort = document.getElementById('sortSelect').value;
    const status = document.getElementById('statusFilter').value;
    
    currentFilters = { search, sort, status };
    
    // Ici on pourrait appliquer les filtres via AJAX
    console.log('Filtres appliqués:', currentFilters);
}

// Actualiser les données
function refreshData() {
    location.reload();
}

// Exporter les données
function exportData() {
    // Ici on pourrait exporter les données
    alert('Fonctionnalité d\'export en cours de développement...');
}

// Actions en lot
function bulkApprove() {
    if (selectedDemandes.size === 0) return;
    
    if (confirm(`Êtes-vous sûr de vouloir approuver ${selectedDemandes.size} demande(s) ?`)) {
        // Ici on pourrait traiter les approbations en lot
        console.log('Approbation en lot:', Array.from(selectedDemandes));
    }
}

function bulkReject() {
    if (selectedDemandes.size === 0) return;
    
    if (confirm(`Êtes-vous sûr de vouloir rejeter ${selectedDemandes.size} demande(s) ?`)) {
        // Ici on pourrait traiter les rejets en lot
        console.log('Rejet en lot:', Array.from(selectedDemandes));
    }
}

// Mise à jour des statistiques
function updateStats() {
    // Ici on pourrait mettre à jour les stats en temps réel
    document.getElementById('approvedToday').textContent = '3';
    document.getElementById('rejectedToday').textContent = '1';
    document.getElementById('avgWaitTime').textContent = '2.5h';
}
</script>
@endsection

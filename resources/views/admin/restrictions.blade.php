@extends('layouts.admin')

@section('content')
<div class="container-fluid px-4 py-4">
    <!-- En-tête -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <div>
                    <h1 class="h3 mb-0 text-warning">
                        <i class="bi bi-shield-lock me-2"></i>Gestion des restrictions de comptes
                    </h1>
                    <p class="text-muted mb-0">Suspendre et réactiver les comptes entrepreneurs</p>
                </div>
                <div class="d-flex gap-2">
                    <button class="btn btn-outline-warning" onclick="refreshData()">
                        <i class="bi bi-arrow-clockwise me-2"></i>Actualiser
                    </button>
                    <button class="btn btn-outline-info" onclick="exportRestrictions()">
                        <i class="bi bi-download me-2"></i>Exporter
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Statistiques -->
    <div class="row mb-4">
        <div class="col-xl-3 col-md-6 mb-3">
            <div class="card border-left-warning shadow h-100">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                                Comptes restreints
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800" id="restrictedCount">0</div>
                        </div>
                        <div class="col-auto">
                            <i class="bi bi-shield-lock fa-2x text-warning"></i>
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
                                Comptes actifs
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800" id="activeCount">0</div>
                        </div>
                        <div class="col-auto">
                            <i class="bi bi-shield-check fa-2x text-success"></i>
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
                                Expirations aujourd'hui
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800" id="expiringToday">0</div>
                        </div>
                        <div class="col-auto">
                            <i class="bi bi-clock-history fa-2x text-danger"></i>
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
                                Restrictions ce mois
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800" id="monthlyRestrictions">0</div>
                        </div>
                        <div class="col-auto">
                            <i class="bi bi-calendar-event fa-2x text-info"></i>
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

    <!-- Formulaire de restriction -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card shadow">
                <div class="card-header bg-warning text-dark">
                    <h6 class="mb-0"><i class="bi bi-plus-circle me-2"></i>Nouvelle restriction</h6>
                </div>
                <div class="card-body">
                    <form id="restrictionForm" method="POST" action="{{ route('admin.restrictions.store') }}">
                        @csrf
                        <div class="row">
                            <div class="col-md-4 mb-3">
                                <label for="entrepreneur_id" class="form-label">Entrepreneur *</label>
                                <select class="form-select" id="entrepreneur_id" name="entrepreneur_id" required>
                                    <option value="">Sélectionner un entrepreneur...</option>
                                    @foreach($entrepreneurs as $entrepreneur)
                                        <option value="{{ $entrepreneur->id }}" 
                                                data-email="{{ $entrepreneur->email }}"
                                                data-entreprise="{{ $entrepreneur->nom_entreprise }}">
                                            {{ $entrepreneur->nom_entreprise }} ({{ $entrepreneur->email }})
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-3 mb-3">
                                <label for="restriction_type" class="form-label">Type de restriction *</label>
                                <select class="form-select" id="restriction_type" name="restriction_type" required>
                                    <option value="">Choisir un type...</option>
                                    <option value="temporaire">Temporaire</option>
                                    <option value="permanente">Permanente</option>
                                    <option value="avertissement">Avertissement</option>
                                </select>
                            </div>
                            <div class="col-md-3 mb-3">
                                <label for="duration" class="form-label">Durée (jours) *</label>
                                <input type="number" class="form-control" id="duration" name="duration" 
                                       min="1" max="365" placeholder="Ex: 7" required>
                            </div>
                            <div class="col-md-2 mb-3">
                                <label for="start_date" class="form-label">Date de début</label>
                                <input type="date" class="form-control" id="start_date" name="start_date" 
                                       value="{{ date('Y-m-d') }}">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-8 mb-3">
                                <label for="motif" class="form-label">Motif de la restriction *</label>
                                <textarea class="form-control" id="motif" name="motif" rows="3" 
                                          placeholder="Expliquez les raisons de cette restriction..." required></textarea>
                            </div>
                            <div class="col-md-4 mb-3">
                                <label class="form-label">&nbsp;</label>
                                <div class="d-grid">
                                    <button type="submit" class="btn btn-warning">
                                        <i class="bi bi-shield-lock me-2"></i>Appliquer la restriction
                                    </button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Liste des restrictions -->
    <div class="row">
        <div class="col-12">
            <div class="card shadow">
                <div class="card-header bg-dark text-white d-flex justify-content-between align-items-center">
                    <h6 class="mb-0"><i class="bi bi-list-ul me-2"></i>Restrictions actives</h6>
                    <span class="badge bg-light text-dark fs-6" id="restrictionsCount">0 restrictions</span>
                </div>
                <div class="card-body p-0">
                    @if($restrictions->isEmpty())
                        <div class="text-center py-5">
                            <div class="mb-3">
                                <i class="bi bi-shield-check text-success" style="font-size: 4rem; opacity: 0.7;"></i>
                            </div>
                            <h5 class="text-muted mb-2">Aucune restriction active</h5>
                            <p class="text-muted">Tous les comptes entrepreneurs sont actifs !</p>
                        </div>
                    @else
                        <div class="table-responsive">
                            <table class="table table-hover mb-0" id="restrictionsTable">
                                <thead class="table-dark">
                                    <tr>
                                        <th scope="col">👤 Entrepreneur</th>
                                        <th scope="col">🔒 Type</th>
                                        <th scope="col">📅 Date de début</th>
                                        <th scope="col">⏰ Date de fin</th>
                                        <th scope="col">📊 Statut</th>
                                        <th scope="col">⚙️ Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($restrictions as $restriction)
                                        <tr class="restriction-row" data-id="{{ $restriction->id }}">
                                            <td>
                                                <div class="d-flex align-items-center">
                                                    <div class="avatar-sm me-3">
                                                        <div class="bg-warning rounded-circle d-flex align-items-center justify-content-center" style="width: 40px; height: 40px;">
                                                            <span class="text-white fw-bold">{{ strtoupper(substr($restriction->entrepreneur->email, 0, 1)) }}</span>
                                                        </div>
                                                    </div>
                                                    <div>
                                                        <div class="fw-bold">{{ $restriction->entrepreneur->nom_entreprise }}</div>
                                                        <small class="text-muted">{{ $restriction->entrepreneur->email }}</small>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                <span class="badge bg-{{ $restriction->type === 'permanente' ? 'danger' : ($restriction->type === 'avertissement' ? 'warning' : 'info') }}">
                                                    {{ ucfirst($restriction->type) }}
                                                </span>
                                            </td>
                                            <td>
                                                <div>{{ $restriction->start_date->format('d/m/Y') }}</div>
                                                <small class="text-muted">{{ $restriction->start_date->format('H:i') }}</small>
                                            </td>
                                            <td>
                                                @php
                                                    $endDate = $restriction->start_date->addDays($restriction->duration);
                                                    $isExpired = $endDate->isPast();
                                                    $daysLeft = now()->diffInDays($endDate, false);
                                                @endphp
                                                <div class="d-flex align-items-center">
                                                    <span class="badge bg-{{ $isExpired ? 'danger' : ($daysLeft <= 3 ? 'warning' : 'success') }} me-2">
                                                        {{ $endDate->format('d/m/Y') }}
                                                    </span>
                                                    @if(!$isExpired)
                                                        <small class="text-muted">{{ $daysLeft }} jours restants</small>
                                                    @else
                                                        <small class="text-danger">Expiré</small>
                                                    @endif
                                                </div>
                                            </td>
                                            <td>
                                                @if($restriction->is_active)
                                                    <span class="badge bg-danger">Restreint</span>
                                                @else
                                                    <span class="badge bg-success">Actif</span>
                                                @endif
                                            </td>
                                            <td>
                                                <div class="btn-group" role="group">
                                                    @if($restriction->is_active)
                                                        <button type="button" class="btn btn-success btn-sm" onclick="activateAccount('{{ $restriction->id }}')">
                                                            <i class="bi bi-unlock me-1"></i>Réactiver
                                                        </button>
                                                    @else
                                                        <button type="button" class="btn btn-warning btn-sm" onclick="extendRestriction('{{ $restriction->id }}')">
                                                            <i class="bi bi-clock me-1"></i>Prolonger
                                                        </button>
                                                    @endif
                                                    <button type="button" class="btn btn-info btn-sm" onclick="viewRestrictionDetails('{{ $restriction->id }}')">
                                                        <i class="bi bi-eye me-1"></i>Détails
                                                    </button>
                                                    <button type="button" class="btn btn-danger btn-sm" onclick="deleteRestriction('{{ $restriction->id }}')">
                                                        <i class="bi bi-trash me-1"></i>Supprimer
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
</div>

<!-- Modal de détails -->
<div class="modal fade" id="detailsModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-info text-white">
                <h5 class="modal-title">
                    <i class="bi bi-info-circle me-2"></i>Détails de la restriction
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

<!-- Modal de prolongation -->
<div class="modal fade" id="extendModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-warning text-dark">
                <h5 class="modal-title">
                    <i class="bi bi-clock me-2"></i>Prolonger la restriction
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <form id="extendForm">
                    <input type="hidden" id="extendRestrictionId" name="restriction_id">
                    <div class="mb-3">
                        <label for="extendDuration" class="form-label">Durée supplémentaire (jours) *</label>
                        <input type="number" class="form-control" id="extendDuration" name="duration" 
                               min="1" max="365" required>
                    </div>
                    <div class="mb-3">
                        <label for="extendMotif" class="form-label">Motif de la prolongation *</label>
                        <textarea class="form-control" id="extendMotif" name="motif" rows="3" required></textarea>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                <button type="button" class="btn btn-warning" onclick="confirmExtend()">
                    <i class="bi bi-clock me-2"></i>Prolonger
                </button>
            </div>
        </div>
    </div>
</div>

<style>
    .border-left-warning { border-left: 0.25rem solid #ffc107 !important; }
    .border-left-success { border-left: 0.25rem solid #198754 !important; }
    .border-left-danger { border-left: 0.25rem solid #dc3545 !important; }
    .border-left-info { border-left: 0.25rem solid #0dcaf0 !important; }
    .text-gray-800 { color: #5a5c69 !important; }
    .text-xs { font-size: 0.7rem; }
    
    .restriction-row { transition: all 0.2s ease; }
    .restriction-row:hover { background-color: #f8f9fa !important; transform: translateY(-1px); }
    
    .avatar-sm { width: 40px; height: 40px; }
    
    .btn-group .btn { border-radius: 0.375rem !important; }
    .btn-group .btn:first-child { border-top-left-radius: 0.375rem !important; border-bottom-left-radius: 0.375rem !important; }
    .btn-group .btn:last-child { border-top-right-radius: 0.375rem !important; border-bottom-right-radius: 0.375rem !important; }
</style>

<script>
// Variables globales
let restrictions = [];

// Initialisation
document.addEventListener('DOMContentLoaded', function() {
    setupEventListeners();
    updateStats();
});

// Configuration des événements
function setupEventListeners() {
    // Changement de type de restriction
    document.getElementById('restriction_type').addEventListener('change', function() {
        const durationField = document.getElementById('duration');
        if (this.value === 'permanente') {
            durationField.value = '365';
            durationField.disabled = true;
        } else {
            durationField.disabled = false;
        }
    });

    // Validation du formulaire
    document.getElementById('restrictionForm').addEventListener('submit', function(e) {
        const entrepreneur = document.getElementById('entrepreneur_id').value;
        const type = document.getElementById('restriction_type').value;
        const duration = document.getElementById('duration').value;
        const motif = document.getElementById('motif').value;

        if (!entrepreneur || !type || !duration || !motif.trim()) {
            e.preventDefault();
            alert('Veuillez remplir tous les champs obligatoires.');
            return false;
        }
    });
}

// Réactiver un compte
function activateAccount(restrictionId) {
    if (confirm('Êtes-vous sûr de vouloir réactiver ce compte ?')) {
        const form = document.createElement('form');
        form.method = 'POST';
        form.action = `/dashboard/restrictions/${restrictionId}/activate`;
        
        const csrfToken = document.createElement('input');
        csrfToken.type = 'hidden';
        csrfToken.name = '_token';
        csrfToken.value = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
        
        form.appendChild(csrfToken);
        document.body.appendChild(form);
        form.submit();
    }
}

// Prolonger une restriction
function extendRestriction(restrictionId) {
    document.getElementById('extendRestrictionId').value = restrictionId;
    const modal = new bootstrap.Modal(document.getElementById('extendModal'));
    modal.show();
}

// Confirmer la prolongation
function confirmExtend() {
    const restrictionId = document.getElementById('extendRestrictionId').value;
    const duration = document.getElementById('extendDuration').value;
    const motif = document.getElementById('extendMotif').value;
    
    if (!duration || !motif.trim()) {
        alert('Veuillez remplir tous les champs.');
        return;
    }
    
    const form = document.createElement('form');
    form.method = 'POST';
    form.action = `/dashboard/restrictions/${restrictionId}/extend`;
    
    const csrfToken = document.createElement('input');
    csrfToken.type = 'hidden';
    csrfToken.name = '_token';
    csrfToken.value = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
    
    const durationInput = document.createElement('input');
    durationInput.type = 'hidden';
    durationInput.name = 'duration';
    durationInput.value = duration;
    
    const motifInput = document.createElement('input');
    motifInput.type = 'hidden';
    motifInput.name = 'motif';
    motifInput.value = motif;
    
    form.appendChild(csrfToken);
    form.appendChild(durationInput);
    form.appendChild(motifInput);
    document.body.appendChild(form);
    form.submit();
}

// Voir les détails d'une restriction
function viewRestrictionDetails(restrictionId) {
    const modal = new bootstrap.Modal(document.getElementById('detailsModal'));
    document.getElementById('detailsContent').innerHTML = `
        <div class="text-center py-4">
            <i class="bi bi-info-circle text-info" style="font-size: 3rem;"></i>
            <h5 class="mt-3">Détails de la restriction #${restrictionId}</h5>
            <p class="text-muted">Fonctionnalité en cours de développement...</p>
        </div>
    `;
    modal.show();
}

// Supprimer une restriction
function deleteRestriction(restrictionId) {
    if (confirm('Êtes-vous sûr de vouloir supprimer cette restriction ?')) {
        const form = document.createElement('form');
        form.method = 'POST';
        form.action = `/dashboard/restrictions/${restrictionId}`;
        
        const csrfToken = document.createElement('input');
        csrfToken.type = 'hidden';
        csrfToken.name = '_token';
        csrfToken.value = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
        
        const methodInput = document.createElement('input');
        methodInput.type = 'hidden';
        methodInput.name = '_method';
        methodInput.value = 'DELETE';
        
        form.appendChild(csrfToken);
        form.appendChild(methodInput);
        document.body.appendChild(form);
        form.submit();
    }
}

// Actualiser les données
function refreshData() {
    location.reload();
}

// Exporter les restrictions
function exportRestrictions() {
    alert('Fonctionnalité d\'export en cours de développement...');
}

// Mise à jour des statistiques
function updateStats() {
    // Ici on pourrait mettre à jour les stats en temps réel
    document.getElementById('restrictedCount').textContent = '{{ $restrictions->where("is_active", true)->count() }}';
    document.getElementById('activeCount').textContent = '{{ $entrepreneurs->count() - $restrictions->where("is_active", true)->count() }}';
    document.getElementById('expiringToday').textContent = '{{ $restrictions->filter(function($r) { return $r->end_date->isToday(); })->count() }}';
    document.getElementById('monthlyRestrictions').textContent = '{{ $restrictions->where("created_at", ">=", now()->startOfMonth())->count() }}';
    document.getElementById('restrictionsCount').textContent = '{{ $restrictions->count() }} restrictions';
}
</script>
@endsection 
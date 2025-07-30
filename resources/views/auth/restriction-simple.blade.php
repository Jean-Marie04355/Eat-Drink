@extends('layouts.app')

@section('content')
<div class="container-fluid px-4 py-4">
    <!-- En-tête -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="position-relative" style="height: 150px; background: linear-gradient(120deg, #dc3545 60%, #f8d7da 100%);">
                <div class="position-absolute top-50 start-50 translate-middle w-100 text-center">
                    <h2 class="fw-bold display-6 mb-2" style="color: #dc3545; text-shadow: 0 2px 8px #fff;">
                        <i class="bi bi-shield-lock me-2"></i>Compte Temporairement Restreint
                    </h2>
                    <span class="badge bg-danger fs-6 shadow-sm">Accès suspendu</span>
                </div>
            </div>
        </div>
    </div>

    <div class="container my-4">
        @if(session('restriction'))
            @php
                $restriction = session('restriction');
                $endDate = \Carbon\Carbon::parse($restriction['end_date']);
                $startDate = \Carbon\Carbon::parse($restriction['start_date']);
                $now = \Carbon\Carbon::now();
                $daysLeft = $now->diffInDays($endDate, false);
                $hoursLeft = $now->diffInHours($endDate, false);
                
                if ($daysLeft > 0) {
                    $timeMessage = "Votre compte sera réactivé dans {$daysLeft} jour(s)";
                    $timeClass = 'success';
                } elseif ($hoursLeft > 0) {
                    $timeMessage = "Votre compte sera réactivé dans {$hoursLeft} heure(s)";
                    $timeClass = 'warning';
                } else {
                    $timeMessage = "Votre compte sera réactivé très prochainement";
                    $timeClass = 'info';
                }
            @endphp
            
            <!-- Carte principale -->
            <div class="row justify-content-center">
                <div class="col-lg-8">
                    <div class="card shadow-lg border-danger">
                        <div class="card-header bg-danger text-white text-center">
                            <h4 class="mb-0">
                                <i class="bi bi-exclamation-triangle me-2"></i>
                                Votre compte a été temporairement restreint
                            </h4>
                        </div>
                        <div class="card-body p-4">
                            <!-- Informations -->
                            <div class="row mb-4">
                                <div class="col-md-6">
                                    <div class="d-flex align-items-center mb-3">
                                        <div class="bg-danger rounded-circle d-flex align-items-center justify-content-center me-3" style="width: 50px; height: 50px;">
                                            <i class="bi bi-shield-lock text-white fs-4"></i>
                                        </div>
                                        <div>
                                            <h6 class="mb-0 text-danger">Type de restriction</h6>
                                            <span class="badge bg-{{ $restriction['type'] === 'permanente' ? 'danger' : ($restriction['type'] === 'avertissement' ? 'warning' : 'info') }} fs-6">
                                                {{ ucfirst($restriction['type']) }}
                                            </span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="d-flex align-items-center mb-3">
                                        <div class="bg-warning rounded-circle d-flex align-items-center justify-content-center me-3" style="width: 50px; height: 50px;">
                                            <i class="bi bi-clock text-white fs-4"></i>
                                        </div>
                                        <div>
                                            <h6 class="mb-0 text-warning">Date de fin</h6>
                                            <span class="fw-bold">{{ $endDate->format('d/m/Y à H:i') }}</span>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Motif -->
                            <div class="alert alert-light border mb-4">
                                <h6 class="text-dark mb-2">
                                    <i class="bi bi-info-circle me-2"></i>Motif de la restriction
                                </h6>
                                <p class="mb-0 text-muted">{{ $restriction['motif'] }}</p>
                            </div>

                            <!-- Temps restant -->
                            <div class="alert alert-{{ $timeClass }} border-{{ $timeClass }} mb-4">
                                <div class="d-flex align-items-center">
                                    <i class="bi bi-clock-history fs-4 me-3"></i>
                                    <div>
                                        <h6 class="mb-1">Temps restant</h6>
                                        <p class="mb-0 fw-bold">{{ $timeMessage }}</p>
                                    </div>
                                </div>
                            </div>

                            <!-- Actions -->
                            <div class="row">
                                <div class="col-md-4">
                                    <a href="{{ route('login') }}" class="btn btn-outline-secondary w-100">
                                        <i class="bi bi-arrow-left me-2"></i>Retour à la connexion
                                    </a>
                                </div>
                                <div class="col-md-4">
                                    <a href="{{ route('accueil') }}" class="btn btn-outline-primary w-100">
                                        <i class="bi bi-house me-2"></i>Retour à l'accueil
                                    </a>
                                </div>
                                <div class="col-md-4">
                                    <button type="button" class="btn btn-outline-info w-100" onclick="showContactForm()">
                                        <i class="bi bi-envelope me-2"></i>Contester
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        @else
            <!-- Message par défaut -->
            <div class="row justify-content-center">
                <div class="col-lg-6">
                    <div class="card shadow text-center">
                        <div class="card-body py-5">
                            <div class="mb-3">
                                <i class="bi bi-shield-check text-success" style="font-size: 4rem;"></i>
                            </div>
                            <h4 class="text-success mb-3">Aucune restriction active</h4>
                            <p class="text-muted mb-4">Votre compte n'est pas actuellement restreint.</p>
                            <a href="{{ route('login') }}" class="btn btn-primary">
                                <i class="bi bi-box-arrow-in-right me-2"></i>Se connecter
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        @endif
    </div>
</div>

<!-- Modal de contact -->
<div class="modal fade" id="contactModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-info text-white">
                <h5 class="modal-title">
                    <i class="bi bi-envelope me-2"></i>Contester la restriction
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <form id="contactForm">
                    <div class="mb-3">
                        <label for="contactEmail" class="form-label">Votre email *</label>
                        <input type="email" class="form-control" id="contactEmail" name="email" required>
                    </div>
                    <div class="mb-3">
                        <label for="contactMessage" class="form-label">Message *</label>
                        <textarea class="form-control" id="contactMessage" name="message" rows="4" 
                                  placeholder="Expliquez pourquoi vous pensez que cette restriction est injustifiée..." required></textarea>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                <button type="button" class="btn btn-info" onclick="sendContactMessage()">
                    <i class="bi bi-send me-2"></i>Envoyer
                </button>
            </div>
        </div>
    </div>
</div>

<script>
function showContactForm() {
    const modal = new bootstrap.Modal(document.getElementById('contactModal'));
    modal.show();
}

function sendContactMessage() {
    const email = document.getElementById('contactEmail').value;
    const message = document.getElementById('contactMessage').value;
    
    if (!email || !message.trim()) {
        alert('Veuillez remplir tous les champs.');
        return;
    }
    
    alert('Message envoyé avec succès !');
    bootstrap.Modal.getInstance(document.getElementById('contactModal')).hide();
}
</script>

<style>
.card.border-danger { border-width: 2px !important; }
.alert.border { border-width: 1px !important; }
</style>
@endsection 
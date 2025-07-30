@extends('layouts.app')

@section('content')
<div class="container-fluid px-4 py-4">
    <!-- En-tête avec message d'erreur -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="position-relative restriction-header">
                <div class="position-absolute top-50 start-50 translate-middle w-100 text-center">
                    <h2 class="fw-bold display-6 mb-2 restriction-title">
                        <i class="bi bi-shield-lock me-2"></i>Compte Temporairement Restreint
                    </h2>
                    <span class="badge bg-danger fs-6 shadow-sm">Accès suspendu</span>
                </div>
                <!-- Animation de fond -->
                <div class="restriction-bg-animation"></div>
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
                $totalDays = $startDate->diffInDays($endDate);
                
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
            
            <!-- Carte principale de restriction -->
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
                            <!-- Informations de la restriction -->
                            <div class="row mb-4">
                                <div class="col-md-4">
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
                                <div class="col-md-4">
                                    <div class="d-flex align-items-center mb-3">
                                        <div class="bg-warning rounded-circle d-flex align-items-center justify-content-center me-3" style="width: 50px; height: 50px;">
                                            <i class="bi bi-calendar-event text-white fs-4"></i>
                                        </div>
                                        <div>
                                            <h6 class="mb-0 text-warning">Date de début</h6>
                                            <span class="fw-bold">{{ $startDate->format('d/m/Y à H:i') }}</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="d-flex align-items-center mb-3">
                                        <div class="bg-info rounded-circle d-flex align-items-center justify-content-center me-3" style="width: 50px; height: 50px;">
                                            <i class="bi bi-clock text-white fs-4"></i>
                                        </div>
                                        <div>
                                            <h6 class="mb-0 text-info">Date de fin</h6>
                                            <span class="fw-bold">{{ $endDate->format('d/m/Y à H:i') }}</span>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Motif de la restriction -->
                            <div class="alert alert-light border">
                                <h6 class="text-dark mb-2">
                                    <i class="bi bi-info-circle me-2"></i>Motif de la restriction
                                </h6>
                                <p class="mb-0 text-muted">{{ $restriction['motif'] }}</p>
                            </div>

                            <!-- Temps restant -->

                            <div class="alert alert-{{ $timeClass }} border-{{ $timeClass }}">
                                <div class="d-flex align-items-center mb-3">
                                    <i class="bi bi-clock-history fs-4 me-3"></i>
                                    <div>
                                        <h6 class="mb-1">Temps restant</h6>
                                        <p class="mb-0 fw-bold">{{ $timeMessage }}</p>
                                    </div>
                                </div>
                                
                                <!-- Barre de progression -->
                                @php
                                    $totalDuration = $totalDays * 24 * 60; // en minutes
                                    $elapsedMinutes = $now->diffInMinutes($startDate);
                                    $remainingMinutes = $now->diffInMinutes($endDate, false);
                                    $progress = max(0, min(100, ($elapsedMinutes / $totalDuration) * 100));
                                @endphp
                                
                                <div class="progress restriction-progress">
                                    <div class="progress-bar bg-{{ $timeClass }}" 
                                         role="progressbar" 
                                         style="width: {{ $progress }}%"
                                         aria-valuenow="{{ $progress }}" 
                                         aria-valuemin="0" 
                                         aria-valuemax="100">
                                    </div>
                                </div>
                                <small class="text-muted mt-2 d-block">
                                    {{ $totalDays }} jour(s) au total • {{ $elapsedMinutes }} min écoulées
                                </small>
                            </div>

                            <!-- Actions -->
                            <div class="row mt-4">
                                <div class="col-md-3">
                                    <a href="{{ route('login') }}" class="btn btn-outline-secondary w-100">
                                        <i class="bi bi-arrow-left me-2"></i>Retour à la connexion
                                    </a>
                                </div>
                                <div class="col-md-3">
                                    <a href="{{ route('accueil') }}" class="btn btn-outline-primary w-100">
                                        <i class="bi bi-house me-2"></i>Retour à l'accueil
                                    </a>
                                </div>
                                <div class="col-md-3">
                                    <button type="button" class="btn btn-outline-info w-100" onclick="showContactForm()">
                                        <i class="bi bi-envelope me-2"></i>Contester
                                    </button>
                                </div>
                                <div class="col-md-3">
                                    <button type="button" class="btn btn-outline-warning w-100" onclick="refreshPage()">
                                        <i class="bi bi-arrow-clockwise me-2"></i>Actualiser
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

                                        <!-- Informations supplémentaires -->
                            <div class="row justify-content-center mt-4">
                                <div class="col-lg-8">
                                    <div class="card shadow">
                                        <div class="card-header bg-light">
                                            <h6 class="mb-0">
                                                <i class="bi bi-question-circle me-2"></i>Que faire maintenant ?
                                            </h6>
                                        </div>
                                        <div class="card-body">
                                            <div class="row">
                                                <div class="col-md-4 mb-3">
                                                    <div class="d-flex">
                                                        <div class="bg-info rounded-circle d-flex align-items-center justify-content-center me-3 action-icon">
                                                            <i class="bi bi-envelope text-white"></i>
                                                        </div>
                                                        <div>
                                                            <h6 class="mb-1">Contacter l'administration</h6>
                                                            <small class="text-muted">Si vous pensez qu'il s'agit d'une erreur</small>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-4 mb-3">
                                                    <div class="d-flex">
                                                        <div class="bg-success rounded-circle d-flex align-items-center justify-content-center me-3 action-icon">
                                                            <i class="bi bi-clock text-white"></i>
                                                        </div>
                                                        <div>
                                                            <h6 class="mb-1">Attendre la réactivation</h6>
                                                            <small class="text-muted">Automatique à la date de fin</small>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-4 mb-3">
                                                    <div class="d-flex">
                                                        <div class="bg-warning rounded-circle d-flex align-items-center justify-content-center me-3 action-icon">
                                                            <i class="bi bi-shield-check text-white"></i>
                                                        </div>
                                                        <div>
                                                            <h6 class="mb-1">Vérifier le statut</h6>
                                                            <small class="text-muted">Actualiser la page pour voir les changements</small>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Timeline de la restriction -->
                            <div class="row justify-content-center mt-4">
                                <div class="col-lg-8">
                                    <div class="card shadow">
                                        <div class="card-header bg-light">
                                            <h6 class="mb-0">
                                                <i class="bi bi-clock-history me-2"></i>Timeline de la restriction
                                            </h6>
                                        </div>
                                        <div class="card-body">
                                            <div class="timeline">
                                                <div class="timeline-item completed">
                                                    <div class="timeline-marker bg-success">
                                                        <i class="bi bi-shield-lock text-white"></i>
                                                    </div>
                                                    <div class="timeline-content">
                                                        <h6 class="mb-1">Restriction appliquée</h6>
                                                        <small class="text-muted">{{ $startDate->format('d/m/Y à H:i') }}</small>
                                                    </div>
                                                </div>
                                                <div class="timeline-item {{ $now->isAfter($startDate) ? 'completed' : '' }}">
                                                    <div class="timeline-marker {{ $now->isAfter($startDate) ? 'bg-success' : 'bg-secondary' }}">
                                                        <i class="bi bi-clock text-white"></i>
                                                    </div>
                                                    <div class="timeline-content">
                                                        <h6 class="mb-1">Période de restriction</h6>
                                                        <small class="text-muted">{{ $totalDays }} jour(s) au total</small>
                                                    </div>
                                                </div>
                                                <div class="timeline-item">
                                                    <div class="timeline-marker bg-warning">
                                                        <i class="bi bi-shield-check text-white"></i>
                                                    </div>
                                                    <div class="timeline-content">
                                                        <h6 class="mb-1">Réactivation automatique</h6>
                                                        <small class="text-muted">{{ $endDate->format('d/m/Y à H:i') }}</small>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

        @else
            <!-- Message par défaut si aucune restriction n'est trouvée -->
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
    
    // Ici on pourrait envoyer le message via AJAX
    fetch('{{ route("auth.restriction.contact") }}', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        },
        body: JSON.stringify({
            email: email,
            message: message,
            restriction_id: 1 // À adapter selon le contexte
        })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            alert('Message envoyé avec succès !');
            bootstrap.Modal.getInstance(document.getElementById('contactModal')).hide();
        } else {
            alert('Erreur lors de l\'envoi du message.');
        }
    })
    .catch(error => {
        console.error('Erreur:', error);
        alert('Erreur lors de l\'envoi du message.');
    });
}

function refreshPage() {
    location.reload();
}

// Animation de la barre de progression
function animateProgress() {
    const progressBar = document.querySelector('.progress-bar');
    if (progressBar) {
        const width = progressBar.style.width;
        progressBar.style.width = '0%';
        setTimeout(() => {
            progressBar.style.transition = 'width 2s ease-in-out';
            progressBar.style.width = width;
        }, 500);
    }
}

// Initialisation des animations
document.addEventListener('DOMContentLoaded', function() {
    animateProgress();
    
    // Animation des cartes au chargement
    const cards = document.querySelectorAll('.card');
    cards.forEach((card, index) => {
        card.style.opacity = '0';
        card.style.transform = 'translateY(20px)';
        setTimeout(() => {
            card.style.transition = 'all 0.5s ease';
            card.style.opacity = '1';
            card.style.transform = 'translateY(0)';
        }, index * 200);
    });
});
</script>

<style>
    .card.border-danger { border-width: 2px !important; }
    .alert.border { border-width: 1px !important; }
    
    .bg-danger.rounded-circle,
    .bg-warning.rounded-circle,
    .bg-info.rounded-circle,
    .bg-success.rounded-circle {
        width: 50px;
        height: 50px;
    }
    
    .action-icon {
        width: 40px;
        height: 40px;
    }
    
    .restriction-progress {
        height: 8px;
    }
    
    /* En-tête avec animation */
    .restriction-header {
        height: 150px;
        background: linear-gradient(120deg, #dc3545 60%, #f8d7da 100%);
        overflow: hidden;
    }
    
    .restriction-title {
        color: #dc3545;
        text-shadow: 0 2px 8px #fff;
        letter-spacing: 1px;
        font-family: 'Segoe UI', 'Arial', sans-serif;
    }
    
    .restriction-bg-animation {
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: linear-gradient(45deg, transparent 30%, rgba(255,255,255,0.1) 50%, transparent 70%);
        animation: shimmer 3s infinite;
    }
    
    @keyframes shimmer {
        0% { transform: translateX(-100%); }
        100% { transform: translateX(100%); }
    }
    
    /* Timeline */
    .timeline {
        position: relative;
        padding-left: 30px;
    }
    
    .timeline::before {
        content: '';
        position: absolute;
        left: 15px;
        top: 0;
        bottom: 0;
        width: 2px;
        background: #e9ecef;
    }
    
    .timeline-item {
        position: relative;
        margin-bottom: 30px;
        opacity: 0.5;
        transition: opacity 0.3s ease;
    }
    
    .timeline-item.completed {
        opacity: 1;
    }
    
    .timeline-marker {
        position: absolute;
        left: -22px;
        top: 0;
        width: 30px;
        height: 30px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        border: 3px solid #fff;
        box-shadow: 0 2px 4px rgba(0,0,0,0.1);
    }
    
    .timeline-content {
        margin-left: 20px;
    }
    
    /* Animations des cartes */
    .card {
        transition: all 0.3s ease;
    }
    
    .card:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 25px rgba(0,0,0,0.15) !important;
    }
    
    /* Boutons améliorés */
    .btn {
        transition: all 0.3s ease;
    }
    
    .btn:hover {
        transform: translateY(-1px);
        box-shadow: 0 4px 8px rgba(0,0,0,0.2);
    }
    
    /* Responsive */
    @media (max-width: 768px) {
        .restriction-header {
            height: 120px;
        }
        
        .restriction-title {
            font-size: 1.5rem !important;
        }
        
        .timeline {
            padding-left: 20px;
        }
        
        .timeline-marker {
            left: -15px;
            width: 25px;
            height: 25px;
        }
    }
</style>
@endsection 
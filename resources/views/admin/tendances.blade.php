@extends('layouts.admin')

@section('content')
<div class="container-fluid px-4 py-4">
    <div class="row mb-4">
        <div class="col-12">
            <h1 class="h3 mb-0 text-success">
                <i class="bi bi-activity me-2"></i>Courbes de tendance en temps réel
            </h1>
            <p class="text-muted">Surveillance des tendances d'activité de la plateforme</p>
        </div>
    </div>

    <!-- Contrôles -->
    <div class="row mb-4">
        <div class="col-md-6">
            <div class="card shadow">
                <div class="card-header bg-success text-white">
                    <h6 class="mb-0"><i class="bi bi-sliders me-2"></i>Contrôles</h6>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Type de données</label>
                            <select id="dataType" class="form-select">
                                <option value="commandes">Commandes</option>
                                <option value="entrepreneurs">Nouveaux entrepreneurs</option>
                                <option value="produits">Nouveaux produits</option>
                                <option value="revenus">Revenus (FCFA)</option>
                            </select>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Période</label>
                            <select id="period" class="form-select">
                                <option value="24h">24 heures</option>
                                <option value="7d">7 jours</option>
                                <option value="30d">30 jours</option>
                            </select>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <button id="startBtn" class="btn btn-success w-100">
                                <i class="bi bi-play-circle me-2"></i>Démarrer
                            </button>
                        </div>
                        <div class="col-md-6">
                            <button id="pauseBtn" class="btn btn-warning w-100" disabled>
                                <i class="bi bi-pause-circle me-2"></i>Pause
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card shadow">
                <div class="card-header bg-info text-white">
                    <h6 class="mb-0"><i class="bi bi-info-circle me-2"></i>Informations</h6>
                </div>
                <div class="card-body">
                    <div class="row text-center">
                        <div class="col-6">
                            <div class="border rounded p-3">
                                <div class="h4 text-success mb-0" id="currentValue">0</div>
                                <small class="text-muted">Valeur actuelle</small>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="border rounded p-3">
                                <div class="h4 text-primary mb-0" id="trendValue">0%</div>
                                <small class="text-muted">Tendance</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Graphique principal -->
    <div class="row">
        <div class="col-12">
            <div class="card shadow">
                <div class="card-header bg-dark text-white">
                    <h6 class="mb-0"><i class="bi bi-graph-up me-2"></i>Courbe de tendance en temps réel</h6>
                </div>
                <div class="card-body p-0">
                    <div id="chartContainer" style="height: 400px; background: #000; position: relative; overflow: hidden;">
                        <canvas id="trendChart" width="1200" height="400"></canvas>
                        
                        <!-- Grille de fond -->
                        <div class="grid-overlay" style="position: absolute; top: 0; left: 0; width: 100%; height: 100%; pointer-events: none;">
                            <div class="grid-line" style="position: absolute; top: 25%; left: 0; width: 100%; height: 1px; background: rgba(0,255,0,0.2);"></div>
                            <div class="grid-line" style="position: absolute; top: 50%; left: 0; width: 100%; height: 1px; background: rgba(0,255,0,0.2);"></div>
                            <div class="grid-line" style="position: absolute; top: 75%; left: 0; width: 100%; height: 1px; background: rgba(0,255,0,0.2);"></div>
                            <div class="grid-line" style="position: absolute; top: 0; left: 25%; width: 1px; height: 100%; background: rgba(0,255,0,0.2);"></div>
                            <div class="grid-line" style="position: absolute; top: 0; left: 50%; width: 1px; height: 100%; background: rgba(0,255,0,0.2);"></div>
                            <div class="grid-line" style="position: absolute; top: 0; left: 75%; width: 1px; height: 100%; background: rgba(0,255,0,0.2);"></div>
                        </div>
                        
                        <!-- Indicateurs -->
                        <div class="indicators" style="position: absolute; top: 10px; right: 10px; color: #00ff00; font-family: monospace; font-size: 12px;">
                            <div id="currentTime">--:--:--</div>
                            <div id="dataTypeLabel">Commandes</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Graphiques secondaires -->
    <div class="row mt-4">
        <div class="col-md-6">
            <div class="card shadow">
                <div class="card-header bg-warning text-dark">
                    <h6 class="mb-0"><i class="bi bi-speedometer2 me-2"></i>Vitesse de croissance</h6>
                </div>
                <div class="card-body">
                    <canvas id="speedChart" width="400" height="200"></canvas>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card shadow">
                <div class="card-header bg-danger text-white">
                    <h6 class="mb-0"><i class="bi bi-exclamation-triangle me-2"></i>Alertes</h6>
                </div>
                <div class="card-body">
                    <div id="alertsContainer">
                        <div class="alert alert-info">
                            <i class="bi bi-info-circle me-2"></i>
                            Surveillance en cours...
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .grid-overlay {
        z-index: 1;
    }
    
    #trendChart {
        position: absolute;
        top: 0;
        left: 0;
        z-index: 2;
    }
    
    .indicators {
        z-index: 3;
        background: rgba(0,0,0,0.7);
        padding: 5px 10px;
        border-radius: 5px;
    }
    
    .pulse {
        animation: pulse 2s infinite;
    }
    
    @keyframes pulse {
        0% { opacity: 1; }
        50% { opacity: 0.5; }
        100% { opacity: 1; }
    }
    
    .trend-up {
        color: #00ff00 !important;
    }
    
    .trend-down {
        color: #ff0000 !important;
    }
</style>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
// Variables globales
let isRunning = false;
let dataPoints = [];
let maxPoints = 100;
let currentValue = 0;
let trend = 0;
let animationId = null;
let mainChart = null;
let speedChart = null;

// Initialisation
function initializeCharts() {
    console.log('Initialisation des graphiques...');
    
    try {
        // Graphique principal
        const trendCanvas = document.getElementById('trendChart');
        if (!trendCanvas) {
            console.error('Canvas trendChart non trouvé');
            return false;
        }
        
        const ctx = trendCanvas.getContext('2d');
        mainChart = new Chart(ctx, {
            type: 'line',
            data: {
                labels: [],
                datasets: [{
                    label: 'Tendance',
                    data: [],
                    borderColor: '#00ff00',
                    backgroundColor: 'rgba(0, 255, 0, 0.1)',
                    borderWidth: 2,
                    fill: true,
                    tension: 0.4,
                    pointRadius: 0,
                    pointHoverRadius: 4
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        display: false
                    }
                },
                scales: {
                    x: {
                        display: false,
                        grid: {
                            display: false
                        }
                    },
                    y: {
                        display: false,
                        grid: {
                            display: false
                        }
                    }
                },
                animation: {
                    duration: 0
                }
            }
        });
        
        // Graphique de vitesse
        const speedCanvas = document.getElementById('speedChart');
        if (!speedCanvas) {
            console.error('Canvas speedChart non trouvé');
            return false;
        }
        
        const speedCtx = speedCanvas.getContext('2d');
        speedChart = new Chart(speedCtx, {
            type: 'doughnut',
            data: {
                labels: ['Croissance', 'Stable', 'Déclin'],
                datasets: [{
                    data: [60, 30, 10],
                    backgroundColor: ['#00ff00', '#ffff00', '#ff0000'],
                    borderWidth: 0
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        position: 'bottom',
                        labels: {
                            color: '#333'
                        }
                    }
                }
            }
        });
        
        console.log('Graphiques initialisés avec succès');
        return true;
    } catch (error) {
        console.error('Erreur lors de l\'initialisation des graphiques:', error);
        return false;
    }
}

// Configuration des événements
function setupEventListeners() {
    console.log('Configuration des événements...');
    
    const startBtn = document.getElementById('startBtn');
    const pauseBtn = document.getElementById('pauseBtn');
    const dataTypeSelect = document.getElementById('dataType');
    const periodSelect = document.getElementById('period');
    
    if (startBtn) {
        startBtn.addEventListener('click', startAnimation);
        console.log('Bouton start configuré');
    }
    if (pauseBtn) {
        pauseBtn.addEventListener('click', pauseAnimation);
        console.log('Bouton pause configuré');
    }
    if (dataTypeSelect) {
        dataTypeSelect.addEventListener('change', (e) => changeDataType(e.target.value));
    }
    if (periodSelect) {
        periodSelect.addEventListener('change', (e) => changePeriod(e.target.value));
    }
}

// Génération des données initiales
function generateInitialData() {
    console.log('Génération des données initiales...');
    
    const baseValue = Math.random() * 100 + 50;
    for (let i = 0; i < maxPoints; i++) {
        const time = new Date(Date.now() - (maxPoints - i) * 1000);
        const value = baseValue + Math.sin(i * 0.1) * 20 + Math.random() * 10;
        dataPoints.push({
            time: time,
            value: value
        });
    }
    updateChart();
    console.log('Données initiales générées:', dataPoints.length, 'points');
}

// Démarrer l'animation
function startAnimation() {
    if (isRunning) return;
    
    console.log('Démarrage de l\'animation');
    isRunning = true;
    
    const startBtn = document.getElementById('startBtn');
    const pauseBtn = document.getElementById('pauseBtn');
    
    if (startBtn) startBtn.disabled = true;
    if (pauseBtn) pauseBtn.disabled = false;
    
    animate();
}

// Pause l'animation
function pauseAnimation() {
    console.log('Pause de l\'animation');
    isRunning = false;
    
    const startBtn = document.getElementById('startBtn');
    const pauseBtn = document.getElementById('pauseBtn');
    
    if (startBtn) startBtn.disabled = false;
    if (pauseBtn) pauseBtn.disabled = true;
    
    if (animationId) {
        cancelAnimationFrame(animationId);
    }
}

// Boucle d'animation
function animate() {
    if (!isRunning) return;
    
    updateData();
    updateChart();
    updateIndicators();
    updateSpeedChart();
    checkAlerts();
    
    animationId = requestAnimationFrame(animate);
}

// Mise à jour des données
function updateData() {
    const now = new Date();
    const lastValue = dataPoints.length > 0 ? dataPoints[dataPoints.length - 1].value : 50;
    
    // Générer une nouvelle valeur avec tendance
    const newTrend = Math.sin(Date.now() * 0.001) * 0.5 + Math.random() * 0.3;
    const newValue = lastValue + newTrend * 2 + (Math.random() - 0.5) * 5;
    
    dataPoints.push({
        time: now,
        value: Math.max(0, newValue)
    });
    
    if (dataPoints.length > maxPoints) {
        dataPoints.shift();
    }
    
    currentValue = newValue;
    trend = newTrend;
}

// Mise à jour du graphique
function updateChart() {
    if (!mainChart) {
        console.error('Graphique principal non initialisé');
        return;
    }
    
    const labels = dataPoints.map(d => d.time.toLocaleTimeString());
    const data = dataPoints.map(d => d.value);
    
    mainChart.data.labels = labels;
    mainChart.data.datasets[0].data = data;
    mainChart.update('none');
}

// Mise à jour des indicateurs
function updateIndicators() {
    const currentValueEl = document.getElementById('currentValue');
    const trendValueEl = document.getElementById('trendValue');
    const currentTimeEl = document.getElementById('currentTime');
    
    if (currentValueEl) {
        currentValueEl.textContent = Math.round(currentValue);
    }
    if (trendValueEl) {
        trendValueEl.textContent = (trend * 100).toFixed(1) + '%';
        trendValueEl.className = trend > 0 ? 'h4 text-primary mb-0 trend-up' : 'h4 text-primary mb-0 trend-down';
    }
    if (currentTimeEl) {
        currentTimeEl.textContent = new Date().toLocaleTimeString();
    }
}

// Mise à jour du graphique de vitesse
function updateSpeedChart() {
    if (!speedChart) {
        console.error('Graphique de vitesse non initialisé');
        return;
    }
    
    const growth = Math.max(0, trend * 100 + 50);
    const stable = 30;
    const decline = Math.max(0, 100 - growth - stable);
    
    speedChart.data.datasets[0].data = [growth, stable, decline];
    speedChart.update();
}

// Vérification des alertes
function checkAlerts() {
    const alertsContainer = document.getElementById('alertsContainer');
    
    if (trend > 0.5) {
        showAlert('Croissance forte détectée!', 'success');
    } else if (trend < -0.5) {
        showAlert('Déclin détecté!', 'danger');
    } else if (Math.abs(trend) < 0.1) {
        showAlert('Activité stable', 'info');
    }
}

// Affichage des alertes
function showAlert(message, type) {
    const alertsContainer = document.getElementById('alertsContainer');
    const alertId = 'alert-' + Date.now();
    
    const alertHtml = `
        <div id="${alertId}" class="alert alert-${type} alert-dismissible fade show">
            <i class="bi bi-${type === 'success' ? 'check-circle' : type === 'danger' ? 'exclamation-triangle' : 'info-circle'} me-2"></i>
            ${message}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    `;
    
    alertsContainer.innerHTML = alertHtml;
    
    // Supprimer l'alerte après 3 secondes
    setTimeout(() => {
        const alert = document.getElementById(alertId);
        if (alert) {
            alert.remove();
        }
    }, 3000);
}

// Changement de type de données
function changeDataType(type) {
    const dataTypeLabel = document.getElementById('dataTypeLabel');
    if (dataTypeLabel) {
        dataTypeLabel.textContent = type.charAt(0).toUpperCase() + type.slice(1);
    }
    console.log('Type de données changé:', type);
}

// Changement de période
function changePeriod(period) {
    console.log('Période changée:', period);
}

// Initialisation au chargement de la page
document.addEventListener('DOMContentLoaded', function() {
    console.log('DOM chargé, initialisation...');
    
    if (initializeCharts()) {
        setupEventListeners();
        generateInitialData();
        console.log('Initialisation terminée avec succès');
    } else {
        console.error('Échec de l\'initialisation');
    }
});
</script>
@endsection 
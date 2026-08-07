@extends('layouts.app')

@push('styles')
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700;800&family=Playfair+Display:ital,wght@0,700;1,700&display=swap" rel="stylesheet">
    <style>
        :root {
            --luxury-gold: #d4af37;
            --luxury-dark: #0f172a;
            --luxury-emerald: #10b981;
            --luxury-ruby: #ef4444;
            --luxury-glass: rgba(255, 255, 255, 0.04);
            --luxury-glass-border: rgba(255, 255, 255, 0.1);
        }

        .entrepreneur-dashboard {
            font-family: 'Outfit', sans-serif;
            background: radial-gradient(circle at 50% 0%, #1e293b 0%, #0f172a 100%);
            color: white;
            min-height: 100vh;
            padding-top: 1rem;
            padding-bottom: 6rem;
        }

        /* Ambient Mesh Background */
        .ambient-mesh {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            pointer-events: none;
            z-index: 0;
            opacity: 0.35;
            background: 
                radial-gradient(at 10% 10%, rgba(212, 175, 55, 0.15) 0px, transparent 50%),
                radial-gradient(at 90% 90%, rgba(16, 185, 129, 0.1) 0px, transparent 50%);
        }

        /* Hero Command Header */
        .hero-command-card {
            background: linear-gradient(135deg, rgba(255, 255, 255, 0.05) 0%, rgba(255, 255, 255, 0.01) 100%);
            backdrop-filter: blur(25px);
            -webkit-backdrop-filter: blur(25px);
            border: 1px solid var(--luxury-glass-border);
            border-radius: 30px;
            padding: 2.5rem;
            position: relative;
            box-shadow: 0 30px 60px -15px rgba(0, 0, 0, 0.5);
            margin-bottom: 2.5rem;
            z-index: 1;
        }

        .gold-pill-badge {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 6px 16px;
            background: rgba(212, 175, 55, 0.12);
            border: 1px solid rgba(212, 175, 55, 0.3);
            color: var(--luxury-gold);
            font-weight: 700;
            font-size: 0.75rem;
            letter-spacing: 2px;
            border-radius: 50px;
            text-transform: uppercase;
        }

        .live-dot {
            width: 8px;
            height: 8px;
            background: #10b981;
            border-radius: 50%;
            box-shadow: 0 0 10px #10b981;
            animation: pulseGreen 1.5s infinite;
        }

        @keyframes pulseGreen {
            0% { transform: scale(1); opacity: 1; }
            50% { transform: scale(1.4); opacity: 0.5; }
            100% { transform: scale(1); opacity: 1; }
        }

        /* Stats Cards */
        .stat-card-gold {
            background: rgba(255, 255, 255, 0.03);
            backdrop-filter: blur(20px);
            border: 1px solid rgba(255, 255, 255, 0.08);
            border-radius: 24px;
            padding: 1.5rem;
            position: relative;
            overflow: hidden;
            transition: all 0.4s ease;
            height: 100%;
        }

        .stat-card-gold:hover {
            transform: translateY(-5px);
            border-color: var(--luxury-gold);
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.4);
            background: rgba(255, 255, 255, 0.05);
        }

        .stat-icon {
            width: 48px;
            height: 48px;
            border-radius: 16px;
            background: rgba(212, 175, 55, 0.12);
            color: var(--luxury-gold);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.3rem;
            margin-bottom: 1.2rem;
            border: 1px solid rgba(212, 175, 55, 0.2);
        }

        /* KDS Kitchen Filter Tabs */
        .kds-tab-btn {
            background: rgba(255, 255, 255, 0.04);
            border: 1px solid rgba(255, 255, 255, 0.08);
            color: rgba(255, 255, 255, 0.7);
            padding: 10px 20px;
            border-radius: 50px;
            font-size: 0.82rem;
            font-weight: 700;
            letter-spacing: 0.5px;
            transition: all 0.3s ease;
            cursor: pointer;
        }

        .kds-tab-btn.active, .kds-tab-btn:hover {
            background: var(--luxury-gold);
            color: #0f172a;
            border-color: var(--luxury-gold);
            box-shadow: 0 0 15px rgba(212, 175, 55, 0.4);
        }

        /* Order KDS Cards */
        .kds-order-card {
            background: rgba(255, 255, 255, 0.03);
            backdrop-filter: blur(20px);
            border: 1px solid rgba(255, 255, 255, 0.08);
            border-radius: 24px;
            overflow: hidden;
            transition: all 0.3s ease;
            height: 100%;
        }

        .kds-order-card.urgent {
            border-color: #ef4444 !important;
            box-shadow: 0 0 25px rgba(239, 68, 68, 0.25);
            animation: pulseUrgent 2s infinite;
        }

        @keyframes pulseUrgent {
            0%, 100% { border-color: rgba(239, 68, 68, 0.8); }
            50% { border-color: rgba(239, 68, 68, 0.3); }
        }

        .kds-card-header {
            background: rgba(0, 0, 0, 0.3);
            padding: 1.2rem;
            border-bottom: 1px solid rgba(255, 255, 255, 0.05);
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .kds-card-body {
            padding: 1.25rem;
        }

        .btn-action-status {
            width: 100%;
            padding: 12px;
            border-radius: 14px;
            font-weight: 800;
            font-size: 0.8rem;
            letter-spacing: 1px;
            text-transform: uppercase;
            border: none;
            transition: all 0.3s ease;
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.3);
        }

        .btn-status-prep {
            background: linear-gradient(135deg, #d4af37 0%, #b8860b 100%);
            color: #0f172a;
        }

        .btn-status-ready {
            background: linear-gradient(135deg, #10b981 0%, #059669 100%);
            color: white;
        }

        .btn-status-done {
            background: rgba(255, 255, 255, 0.1);
            color: white;
            border: 1px solid rgba(255, 255, 255, 0.2);
        }

        .btn-action-status:hover {
            transform: translateY(-2px);
            filter: brightness(1.15);
        }

        /* Glass Container Box */
        .glass-box {
            background: rgba(255, 255, 255, 0.03);
            backdrop-filter: blur(20px);
            border: 1px solid rgba(255, 255, 255, 0.08);
            border-radius: 28px;
            padding: 1.8rem;
        }

        /* Dishes Quick Manager Table */
        .dish-row-item {
            display: flex;
            align-items: center;
            gap: 15px;
            padding: 12px;
            background: rgba(255, 255, 255, 0.02);
            border-radius: 16px;
            margin-bottom: 10px;
            border: 1px solid rgba(255, 255, 255, 0.04);
            transition: all 0.3s ease;
        }

        .dish-row-item:hover {
            background: rgba(255, 255, 255, 0.05);
            border-color: rgba(212, 175, 55, 0.3);
        }

        .dish-thumb {
            width: 48px;
            height: 48px;
            border-radius: 12px;
            object-fit: cover;
            border: 1px solid rgba(212, 175, 55, 0.3);
        }

        /* Mobile Adjustments */
        @media (max-width: 768px) {
            .hero-command-card {
                padding: 1.5rem 1.25rem !important;
                border-radius: 20px !important;
            }
            .hero-command-card h1 {
                font-size: 1.8rem !important;
            }
            .stat-card-gold, .glass-box {
                padding: 1.25rem !important;
                border-radius: 20px !important;
            }
        }
    </style>
@endpush

@section('content')
    <div class="ambient-mesh"></div>

    <div class="entrepreneur-dashboard container position-relative z-index-1">
        <!-- Notification Alert -->
        @if(session('success'))
            <div class="alert alert-success bg-emerald text-white border-0 rounded-4 p-3 mb-4 d-flex align-items-center justify-content-between animate__animated animate__fadeIn">
                <div><i class="fas fa-check-circle me-2"></i> {{ session('success') }}</div>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert"></button>
            </div>
        @endif

        <!-- Hero Header -->
        <div class="hero-command-card">
            <div class="row align-items-center">
                <div class="col-lg-7">
                    <div class="d-flex align-items-center gap-3 mb-3 flex-wrap">
                        <span class="gold-pill-badge">
                            <span class="live-dot"></span> ÉTABLISSEMENT CERTIFIÉ EAT&DRINK
                        </span>
                        <span class="text-white-50 small" id="liveClock">
                            <i class="far fa-clock me-1 text-gold"></i> <span id="clockText">--:--:--</span>
                        </span>
                    </div>
                    <h1 class="display-5 fw-800 text-white mb-2" style="font-family: 'Playfair Display', serif;">
                        Bienvenue, <span class="text-gold">{{ Auth::user()->nom_entreprise }}</span>
                    </h1>
                    <p class="text-white-50 mb-0 lead" style="font-size: 1rem;">
                        Gestion en direct de vos commandes, créations culinaires et performances de vente.
                    </p>
                </div>
                <div class="col-lg-5 text-lg-end mt-4 mt-lg-0">
                    <div class="d-flex justify-content-lg-end gap-2 flex-wrap">
                        <button type="button" class="btn btn-warning rounded-pill px-4 py-25 fw-800 text-dark shadow-gold"
                            data-bs-toggle="modal" data-bs-target="#modalAddDish"
                            style="background: linear-gradient(135deg, #d4af37 0%, #b8860b 100%); border: none;">
                            <i class="fas fa-plus-circle me-2"></i>AJOUTER UN PLAT
                        </button>
                        <a href="{{ route('entrepreneur.produits.index') }}" class="btn btn-outline-light rounded-pill px-4 py-25 border-opacity-25 fw-600">
                            <i class="fas fa-utensils me-2"></i>MA CARTE
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- 4 Key Stat Cards -->
        <div class="row g-3 g-md-4 mb-5">
            <div class="col-6 col-lg-3">
                <div class="stat-card-gold">
                    <div class="stat-icon"><i class="fas fa-wallet"></i></div>
                    <div class="text-white-50 tiny-label text-uppercase fw-700 letter-spacing-1 mb-1">Chiffre d'Affaires</div>
                    <h3 class="fw-800 text-white mb-0 fs-4 fs-md-3">
                        {{ number_format($total_ventes, 0, ',', ' ') }} <span class="fs-6 opacity-50 text-gold">CFA</span>
                    </h3>
                </div>
            </div>

            <div class="col-6 col-lg-3">
                <div class="stat-card-gold">
                    <div class="stat-icon" style="color: #10b981; background: rgba(16, 185, 129, 0.12); border-color: rgba(16, 185, 129, 0.2);">
                        <i class="fas fa-shopping-bag"></i>
                    </div>
                    <div class="text-white-50 tiny-label text-uppercase fw-700 letter-spacing-1 mb-1">Commandes Réalisées</div>
                    <h3 class="fw-800 text-white mb-0 fs-4 fs-md-3">
                        {{ $total_commandes }} <span class="fs-6 opacity-50 text-emerald">commandes</span>
                    </h3>
                </div>
            </div>

            <div class="col-6 col-lg-3">
                <div class="stat-card-gold">
                    <div class="stat-icon" style="color: #3b82f6; background: rgba(59, 130, 246, 0.12); border-color: rgba(59, 130, 246, 0.2);">
                        <i class="fas fa-receipt"></i>
                    </div>
                    <div class="text-white-50 tiny-label text-uppercase fw-700 letter-spacing-1 mb-1">Panier Moyen</div>
                    <h3 class="fw-800 text-white mb-0 fs-4 fs-md-3">
                        {{ number_format($panier_moyen, 0, ',', ' ') }} <span class="fs-6 opacity-50">CFA</span>
                    </h3>
                </div>
            </div>

            <div class="col-6 col-lg-3">
                <div class="stat-card-gold">
                    <div class="stat-icon">
                        <i class="fas fa-concierge-bell"></i>
                    </div>
                    <div class="text-white-50 tiny-label text-uppercase fw-700 letter-spacing-1 mb-1">Plats à la Carte</div>
                    <h3 class="fw-800 text-white mb-0 fs-4 fs-md-3">
                        {{ $total_produits }} <span class="fs-6 opacity-50 text-gold">référence(s)</span>
                    </h3>
                </div>
            </div>
        </div>

        <div class="row g-4">
            <!-- Left Side: KDS Live Kitchen Command & Chart -->
            <div class="col-lg-8">
                <!-- Kitchen Display Header & Tab Filter -->
                <div class="glass-box mb-4">
                    <div class="d-flex align-items-center justify-content-between mb-4 flex-wrap gap-3">
                        <div class="d-flex align-items-center gap-3">
                            <h4 class="fw-800 mb-0 text-white">
                                <i class="fas fa-fire-alt text-warning me-2"></i>Cuisine en Direct (KDS)
                            </h4>
                        </div>
                        <div class="text-emerald small fw-700">
                            <i class="fas fa-sync-alt fa-spin me-1"></i> Actualisation automatique
                        </div>
                    </div>

                    <!-- KDS Status Tabs -->
                    <div class="d-flex gap-2 flex-wrap mb-4" id="kdsFilterTabs">
                        @php
                            $pendingCount = $commandes->where('statut', 'en_attente')->count();
                            $prepCount = $commandes->where('statut', 'en_preparation')->count();
                            $readyCount = $commandes->where('statut', 'prete')->count();
                        @endphp
                        <button class="kds-tab-btn active" data-filter="all">Tous ({{ $commandes->whereIn('statut', ['en_attente', 'en_preparation', 'prete'])->count() }})</button>
                        <button class="kds-tab-btn" data-filter="en_attente">🔥 En Attente ({{ $pendingCount }})</button>
                        <button class="kds-tab-btn" data-filter="en_preparation">👨‍🍳 En Préparation ({{ $prepCount }})</button>
                        <button class="kds-tab-btn" data-filter="prete">✅ Prêtes ({{ $readyCount }})</button>
                    </div>

                    <!-- Live Kitchen Orders Grid -->
                    <div class="row g-3" id="kdsContainer">
                        @php
                            $activeOrders = $commandes->whereIn('statut', ['en_attente', 'en_preparation', 'prete']);
                        @endphp

                        @forelse($activeOrders as $commande)
                            @php
                                $waitingTime = $commande->created_at->diffInMinutes();
                                $isUrgent = $waitingTime > 15 && $commande->statut != 'prete';
                            @endphp
                            <div class="col-md-6 kds-order-col" data-status="{{ $commande->statut }}">
                                <div class="kds-order-card {{ $isUrgent ? 'urgent' : '' }}">
                                    <div class="kds-card-header">
                                        <div>
                                            <span class="badge bg-dark rounded-pill px-3 py-2 me-2 border border-secondary">#{{ $commande->id }}</span>
                                            <span class="fw-800 text-white">
                                                {{ $commande->type_commande === 'sur_place' ? ('Table ' . ($commande->numero_table ?? 'Indéfinie')) : 'À Emporter / Livraison' }}
                                            </span>
                                        </div>
                                        <div class="small fw-700 {{ $isUrgent ? 'text-danger' : 'text-white-50' }}">
                                            <i class="far fa-clock me-1"></i>{{ $waitingTime }} min
                                        </div>
                                    </div>

                                    <div class="kds-card-body">
                                        <div class="small text-white-50 mb-3">
                                            <i class="fas fa-user me-1 text-gold"></i> {{ $commande->nom_client }} • <i class="fas fa-phone me-1 text-gold"></i> {{ $commande->telephone }}
                                        </div>

                                        <ul class="list-unstyled mb-4">
                                            @foreach($commande->produits as $prod)
                                                <li class="d-flex justify-content-between align-items-center mb-2 p-2 rounded" style="background: rgba(255,255,255,0.02)">
                                                    <span>
                                                        <span class="badge bg-gold-luxury text-dark fw-800 me-2">{{ $prod->pivot->quantite }}x</span>
                                                        <strong class="text-white">{{ $prod->nom }}</strong>
                                                    </span>
                                                    <span class="small text-white-50">{{ number_format($prod->prix * $prod->pivot->quantite, 0, ',', ' ') }} CFA</span>
                                                </li>
                                            @endforeach
                                        </ul>

                                        @if($commande->statut == 'en_attente')
                                            <button onclick="updateStatus({{ $commande->id }}, 'en_preparation', this)"
                                                class="btn-action-status btn-status-prep">
                                                <i class="fas fa-play me-2"></i> Lancer la Préparation
                                            </button>
                                        @elseif($commande->statut == 'en_preparation')
                                            <button onclick="updateStatus({{ $commande->id }}, 'prete', this)"
                                                class="btn-action-status btn-status-ready">
                                                <i class="fas fa-check me-2"></i> Marquer comme Prêt
                                            </button>
                                        @elseif($commande->statut == 'prete')
                                            <button onclick="updateStatus({{ $commande->id }}, 'terminee', this)"
                                                class="btn-action-status btn-status-done">
                                                <i class="fas fa-box-check me-2"></i> Servi / Archiver
                                            </button>
                                        @endif
                                    </div>
                                    <div class="progress" style="height: 4px; background: rgba(255,255,255,0.05)">
                                        <div class="progress-bar {{ $commande->statut == 'en_preparation' ? 'bg-warning' : 'bg-success' }}"
                                            style="width: {{ $commande->statut == 'en_attente' ? '25%' : ($commande->statut == 'en_preparation' ? '65%' : '100%') }}">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @empty
                            <div class="col-12">
                                <div class="text-center py-5 opacity-50">
                                    <i class="fas fa-concierge-bell fa-4x mb-3 text-gold"></i>
                                    <h5 class="fw-800 text-white">Aucune commande en attente</h5>
                                    <p class="small text-white-50">La cuisine est prête pour les prochaines commandes.</p>
                                </div>
                            </div>
                        @endforelse
                    </div>
                </div>

                <!-- Hourly Performance Graph -->
                <div class="glass-box">
                    <h5 class="fw-800 mb-4 text-gold text-uppercase letter-spacing-1">
                        <i class="fas fa-chart-line me-2"></i> Performance Horaires de Ventes
                    </h5>
                    <canvas id="salesChart" height="220"></canvas>
                </div>
            </div>

            <!-- Right Side: Dish Manager & Best Sellers -->
            <div class="col-lg-4">
                <!-- Live Dishes Availability Quick Manager -->
                <div class="glass-box mb-4">
                    <div class="d-flex align-items-center justify-content-between mb-4">
                        <h5 class="fw-800 text-white mb-0">
                            <i class="fas fa-utensils text-gold me-2"></i>Gestion de la Carte
                        </h5>
                        <a href="{{ route('entrepreneur.produits.index') }}" class="small text-gold text-decoration-none fw-700">Tout voir <i class="fas fa-chevron-right ms-1"></i></a>
                    </div>

                    <div class="dishes-quick-list" style="max-height: 380px; overflow-y: auto;">
                        @forelse($produits as $produit)
                            <div class="dish-row-item">
                                <img src="{{ $produit->photo ? (\Illuminate\Support\Str::startsWith($produit->photo, 'http') ? $produit->photo : asset('storage/' . $produit->photo)) : 'https://images.unsplash.com/photo-1546069901-ba9599a7e63c' }}"
                                    class="dish-thumb" alt="{{ $produit->nom }}">
                                <div class="flex-grow-1 overflow-hidden">
                                    <div class="fw-700 text-white text-truncate small">{{ $produit->nom }}</div>
                                    <div class="text-gold tiny-text fw-800">{{ number_format($produit->prix, 0, ',', ' ') }} CFA</div>
                                </div>
                                <div>
                                    <form action="{{ route('entrepreneur.produits.toggle', $produit->id) }}" method="POST">
                                        @csrf
                                        <button type="submit" class="btn btn-sm {{ $produit->est_disponible ? 'btn-outline-success' : 'btn-outline-danger' }} rounded-pill px-3 py-1 text-uppercase fw-800" style="font-size: 0.65rem;">
                                            {{ $produit->est_disponible ? 'Dispo' : 'Épuisé' }}
                                        </button>
                                    </form>
                                </div>
                            </div>
                        @empty
                            <div class="text-center py-4 opacity-50">
                                <p class="small text-white-50 mb-0">Aucun plat dans votre carte.</p>
                            </div>
                        @endforelse
                    </div>
                </div>

                <!-- Best Sellers -->
                <div class="glass-box mb-4">
                    <h5 class="fw-800 mb-4 text-gold text-uppercase letter-spacing-1">
                        <i class="fas fa-trophy me-2"></i> Meilleurs Succès
                    </h5>
                    <div class="top-products-list">
                        @forelse($topProduits as $id => $stats)
                            <div class="dish-row-item">
                                <img src="{{ $stats['photo'] ? (\Illuminate\Support\Str::startsWith($stats['photo'], 'http') ? $stats['photo'] : asset('storage/' . $stats['photo'])) : 'https://images.unsplash.com/photo-1546069901-ba9599a7e63c' }}"
                                    class="dish-thumb me-2">
                                <div class="flex-grow-1">
                                    <h6 class="mb-0 fw-800 text-white small">{{ $stats['nom'] }}</h6>
                                    <small class="text-white-50 tiny-text">{{ $stats['total_vendu'] }} unités vendues</small>
                                </div>
                                <div class="text-gold fw-800 small">{{ number_format($stats['revenu'], 0, ',', ' ') }} CFA</div>
                            </div>
                        @empty
                            <div class="text-center py-3 opacity-50 small">Aucune donnée de vente accumulée.</div>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Quick Add Dish -->
    <div class="modal fade" id="modalAddDish" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content bg-dark text-white border-gold-glow rounded-4 p-3">
                <div class="modal-header border-0 pb-0">
                    <h5 class="modal-title fw-800 text-gold"><i class="fas fa-plus-circle me-2"></i>Nouveau Plat Signature</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <form action="{{ route('entrepreneur.produits.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-body pt-4">
                        <div class="mb-3">
                            <label class="form-label text-white-50 small text-uppercase fw-700">Nom de la Création</label>
                            <input type="text" name="nom" class="form-control bg-secondary bg-opacity-25 text-white border-secondary rounded-3" placeholder="Ex: Risotto aux Truffes" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label text-white-50 small text-uppercase fw-700">Prix (CFA)</label>
                            <input type="number" name="prix" class="form-control bg-secondary bg-opacity-25 text-white border-secondary rounded-3" placeholder="Ex: 8500" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label text-white-50 small text-uppercase fw-700">Description Gourmande</label>
                            <textarea name="description" rows="3" class="form-control bg-secondary bg-opacity-25 text-white border-secondary rounded-3" placeholder="Ingrédients nobles et préparation..." required></textarea>
                        </div>
                        <div class="mb-3">
                            <label class="form-label text-white-50 small text-uppercase fw-700">Photo du Plat</label>
                            <input type="file" name="photo" class="form-control bg-secondary bg-opacity-25 text-white border-secondary rounded-3">
                        </div>
                        <div class="form-check form-switch mt-3">
                            <input class="form-check-input" type="checkbox" name="est_disponible" id="flexCheckDispo" checked>
                            <label class="form-check-label text-white small fw-700" for="flexCheckDispo">Disponible immédiatement à la vente</label>
                        </div>
                    </div>
                    <div class="modal-footer border-0 pt-0">
                        <button type="button" class="btn btn-outline-light rounded-pill px-4" data-bs-dismiss="modal">Annuler</button>
                        <button type="submit" class="btn btn-warning rounded-pill px-4 fw-800 text-dark" style="background: var(--luxury-gold); border: none;">ENREGISTRER</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    @push('scripts')
        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                // Digital Clock
                function updateClock() {
                    const now = new Date();
                    const clock = document.getElementById('clockText');
                    if (clock) {
                        clock.textContent = now.toLocaleTimeString('fr-FR');
                    }
                }
                setInterval(updateClock, 1000);
                updateClock();

                // KDS Tab Filtering
                const kdsTabs = document.querySelectorAll('#kdsFilterTabs .kds-tab-btn');
                const kdsCols = document.querySelectorAll('.kds-order-col');

                kdsTabs.forEach(tab => {
                    tab.addEventListener('click', function() {
                        kdsTabs.forEach(t => t.classList.remove('active'));
                        this.classList.add('active');
                        const filter = this.getAttribute('data-filter');

                        kdsCols.forEach(col => {
                            const status = col.getAttribute('data-status');
                            if (filter === 'all' || status === filter) {
                                col.style.display = 'block';
                            } else {
                                col.style.display = 'none';
                            }
                        });
                    });
                });

                // Chart.js Sales Graph
                const ctx = document.getElementById('salesChart');
                if (ctx) {
                    const salesData = @json(array_values($salesByHour));
                    new Chart(ctx.getContext('2d'), {
                        type: 'line',
                        data: {
                            labels: Array.from({ length: 24 }, (_, i) => `${i}h`),
                            datasets: [{
                                label: 'Ventes (CFA)',
                                data: salesData,
                                borderColor: '#d4af37',
                                backgroundColor: 'rgba(212, 175, 55, 0.1)',
                                borderWidth: 3,
                                fill: true,
                                tension: 0.4,
                                pointBackgroundColor: '#ffffff',
                                pointRadius: 4
                            }]
                        },
                        options: {
                            responsive: true,
                            plugins: { legend: { display: false } },
                            scales: {
                                y: { grid: { color: 'rgba(255,255,255,0.05)' }, ticks: { color: 'rgba(255,255,255,0.5)' } },
                                x: { grid: { display: false }, ticks: { color: 'rgba(255,255,255,0.5)' } }
                            }
                        }
                    });
                }
            });

            // Update Order Status AJAX
            function updateStatus(id, newStatus, btn) {
                if (btn) {
                    btn.disabled = true;
                    btn.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i> En cours...';
                }

                fetch(`/entrepreneur/commandes/${id}/status`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({ statut: newStatus })
                })
                .then(async response => {
                    const data = await response.json().catch(() => ({}));
                    if (response.ok && data.success) {
                        location.reload();
                    } else {
                        alert('Erreur: ' + (data.message || 'Mise à jour impossible'));
                        if (btn) {
                            btn.disabled = false;
                            btn.innerHTML = 'Réessayer';
                        }
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('Erreur de connexion au serveur');
                    if (btn) {
                        btn.disabled = false;
                        btn.innerHTML = 'Réessayer';
                    }
                });
            }
        </script>
    @endpush
@endsection
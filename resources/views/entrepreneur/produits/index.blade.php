{{-- resources/views/entrepreneur/produits/index.blade.php --}}
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

        .produits-page-wrapper {
            font-family: 'Outfit', sans-serif;
            background: radial-gradient(circle at 50% 0%, #1e293b 0%, #0f172a 100%);
            color: white;
            min-height: 100vh;
            padding-top: 1rem;
            padding-bottom: 6rem;
        }

        /* Ambient background glow */
        .ambient-glow {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            pointer-events: none;
            z-index: 0;
            opacity: 0.3;
            background: 
                radial-gradient(at 20% 20%, rgba(212, 175, 55, 0.15) 0px, transparent 50%),
                radial-gradient(at 80% 80%, rgba(16, 185, 129, 0.1) 0px, transparent 50%);
        }

        /* Hero Header */
        .catalog-hero-card {
            background: linear-gradient(135deg, rgba(255, 255, 255, 0.05) 0%, rgba(255, 255, 255, 0.01) 100%);
            backdrop-filter: blur(25px);
            -webkit-backdrop-filter: blur(25px);
            border: 1px solid var(--luxury-glass-border);
            border-radius: 30px;
            padding: 2.5rem;
            box-shadow: 0 30px 60px -15px rgba(0, 0, 0, 0.5);
            margin-bottom: 2.5rem;
            position: relative;
            z-index: 1;
        }

        .gold-pill-tag {
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

        /* Stats Bar */
        .stats-metric-card {
            background: rgba(255, 255, 255, 0.03);
            backdrop-filter: blur(20px);
            border: 1px solid rgba(255, 255, 255, 0.08);
            border-radius: 20px;
            padding: 1.25rem 1.5rem;
            transition: all 0.3s ease;
        }

        .stats-metric-card:hover {
            border-color: var(--luxury-gold);
            background: rgba(255, 255, 255, 0.05);
        }

        /* Product Cards */
        .dish-card-lux {
            background: rgba(255, 255, 255, 0.03);
            backdrop-filter: blur(20px);
            border: 1px solid rgba(255, 255, 255, 0.08);
            border-radius: 24px;
            overflow: hidden;
            transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
            height: 100%;
            display: flex;
            flex-direction: column;
            position: relative;
        }

        .dish-card-lux:hover {
            transform: translateY(-8px);
            border-color: var(--luxury-gold);
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.4);
        }

        .dish-img-wrapper {
            position: relative;
            height: 220px;
            overflow: hidden;
        }

        .dish-img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform 0.6s ease;
        }

        .dish-card-lux:hover .dish-img {
            transform: scale(1.08);
        }

        .price-badge-floating {
            position: absolute;
            top: 15px;
            right: 15px;
            background: rgba(15, 23, 42, 0.85);
            backdrop-filter: blur(10px);
            color: var(--luxury-gold);
            padding: 6px 14px;
            border-radius: 50px;
            font-weight: 800;
            font-size: 0.85rem;
            border: 1px solid var(--luxury-gold);
            z-index: 2;
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.3);
        }

        .status-badge-floating {
            position: absolute;
            top: 15px;
            left: 15px;
            padding: 5px 12px;
            border-radius: 50px;
            font-weight: 800;
            font-size: 0.7rem;
            letter-spacing: 1px;
            text-transform: uppercase;
            z-index: 2;
            backdrop-filter: blur(10px);
        }

        .status-badge-floating.dispo {
            background: rgba(16, 185, 129, 0.85);
            color: white;
            border: 1px solid #10b981;
        }

        .status-badge-floating.epuise {
            background: rgba(239, 68, 68, 0.85);
            color: white;
            border: 1px solid #ef4444;
        }

        .card-actions-hover {
            position: absolute;
            bottom: 15px;
            right: 15px;
            display: flex;
            gap: 8px;
            z-index: 3;
        }

        .btn-action-icon {
            width: 38px;
            height: 38px;
            border-radius: 50%;
            background: rgba(15, 23, 42, 0.85);
            backdrop-filter: blur(10px);
            color: white;
            border: 1px solid rgba(255, 255, 255, 0.2);
            display: flex;
            align-items: center;
            justify-content: center;
            transition: all 0.3s ease;
            text-decoration: none;
        }

        .btn-action-icon:hover {
            background: var(--luxury-gold);
            color: #0f172a;
            border-color: var(--luxury-gold);
            transform: scale(1.1);
        }

        .btn-action-icon.delete:hover {
            background: #ef4444;
            color: white;
            border-color: #ef4444;
        }

        /* Filter Chips */
        .filter-chip-item {
            background: rgba(255, 255, 255, 0.04);
            border: 1px solid rgba(255, 255, 255, 0.08);
            color: rgba(255, 255, 255, 0.7);
            padding: 8px 18px;
            border-radius: 50px;
            font-size: 0.8rem;
            font-weight: 700;
            transition: all 0.3s ease;
            cursor: pointer;
        }

        .filter-chip-item.active, .filter-chip-item:hover {
            background: var(--luxury-gold);
            color: #0f172a;
            border-color: var(--luxury-gold);
        }

        /* Mobile adjustments */
        @media (max-width: 768px) {
            .catalog-hero-card {
                padding: 1.5rem 1.25rem !important;
                border-radius: 20px !important;
            }
            .catalog-hero-card h1 {
                font-size: 1.8rem !important;
            }
        }
    </style>
@endpush

@section('content')
    <div class="ambient-glow"></div>

    <div class="produits-page-wrapper container position-relative z-index-1">
        <!-- Alert Notification -->
        @if(session('success'))
            <div class="alert alert-success bg-emerald text-white border-0 rounded-4 p-3 mb-4 d-flex align-items-center justify-content-between animate__animated animate__fadeIn">
                <div><i class="fas fa-check-circle me-2"></i> {{ session('success') }}</div>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert"></button>
            </div>
        @endif

        <!-- Hero Card Header -->
        <div class="catalog-hero-card">
            <div class="row align-items-center">
                <div class="col-lg-7">
                    <div class="d-flex align-items-center gap-3 mb-3 flex-wrap">
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb mb-0">
                                <li class="breadcrumb-item"><a href="{{ route('entrepreneur.dashboard') }}" class="text-white-50 text-decoration-none">Dashboard</a></li>
                                <li class="breadcrumb-item active text-gold" aria-current="page">Mon Catalogue</li>
                            </ol>
                        </nav>
                    </div>
                    <h1 class="display-5 fw-800 text-white mb-2" style="font-family: 'Playfair Display', serif;">
                        Gestion du <span class="text-gold">Menu & Créations</span>
                    </h1>
                    <p class="text-white-50 mb-0 lead" style="font-size: 1rem;">
                        Ajustez vos prix, visualisez vos produits et contrôlez les stocks en direct.
                    </p>
                </div>

                <div class="col-lg-5 text-lg-end mt-4 mt-lg-0">
                    <a href="{{ route('entrepreneur.produits.create') }}" class="btn btn-warning rounded-pill px-4 py-25 fw-800 text-dark shadow-gold me-2"
                        style="background: linear-gradient(135deg, #d4af37 0%, #b8860b 100%); border: none;">
                        <i class="fas fa-plus-circle me-2"></i>NOUVEAU PLAT
                    </a>
                </div>
            </div>
        </div>

        <!-- Metric Stats Bar -->
        <div class="row g-3 mb-4">
            <div class="col-6 col-md-3">
                <div class="stats-metric-card">
                    <div class="text-white-50 tiny-text text-uppercase fw-700 letter-spacing-1 mb-1">TOTAL PLATS</div>
                    <div class="h3 fw-800 mb-0 text-white">{{ $produits->count() }}</div>
                </div>
            </div>

            <div class="col-6 col-md-3">
                <div class="stats-metric-card">
                    <div class="text-white-50 tiny-text text-uppercase fw-700 letter-spacing-1 mb-1">VALEUR DU MENU</div>
                    <div class="h3 fw-800 mb-0 text-gold">{{ number_format($produits->sum('prix'), 0, ',', ' ') }} <span class="fs-6 opacity-50">CFA</span></div>
                </div>
            </div>

            <div class="col-6 col-md-3">
                <div class="stats-metric-card">
                    <div class="text-white-50 tiny-text text-uppercase fw-700 letter-spacing-1 mb-1">EN VENTE</div>
                    <div class="h3 fw-800 mb-0 text-emerald">{{ $produits->where('est_disponible', true)->count() }}</div>
                </div>
            </div>

            <div class="col-6 col-md-3">
                <div class="stats-metric-card">
                    <div class="text-white-50 tiny-text text-uppercase fw-700 letter-spacing-1 mb-1">ÉPUISÉS</div>
                    <div class="h3 fw-800 mb-0 text-danger">{{ $produits->where('est_disponible', false)->count() }}</div>
                </div>
            </div>
        </div>

        <!-- Search Bar & Filters -->
        <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-3">
            <div class="position-relative flex-grow-1" style="max-width: 400px;">
                <i class="fas fa-search position-absolute top-50 start-0 translate-middle-y ms-3 text-white-50"></i>
                <input type="text" id="dishSearchInput" class="form-control bg-dark text-white border-secondary rounded-pill ps-5 py-2" placeholder="Rechercher une création...">
            </div>

            <div class="d-flex gap-2" id="statusFilterChips">
                <div class="filter-chip-item active" data-filter="all">Tous ({{ $produits->count() }})</div>
                <div class="filter-chip-item" data-filter="dispo">En Vente ({{ $produits->where('est_disponible', true)->count() }})</div>
                <div class="filter-chip-item" data-filter="epuise">Épuisés ({{ $produits->where('est_disponible', false)->count() }})</div>
            </div>
        </div>

        @if($produits->isEmpty())
            <div class="text-center py-5 opacity-50 bg-dark bg-opacity-25 rounded-4 p-5">
                <i class="fas fa-utensils fa-4x mb-3 text-gold"></i>
                <h4 class="fw-800 text-white">Votre carte est vierge</h4>
                <p class="text-white-50">Ajoutez votre premier plat signature pour commencer à recevoir des commandes.</p>
                <a href="{{ route('entrepreneur.produits.create') }}" class="btn btn-warning rounded-pill px-4 py-2 fw-800 text-dark mt-2" style="background: var(--luxury-gold); border: none;">
                    AJOUTER UN PLAT
                </a>
            </div>
        @else
            <!-- Product Grid -->
            <div class="row g-4" id="dishesGrid">
                @foreach($produits as $produit)
                    <div class="col-md-6 col-lg-4 dish-card-col"
                        data-name="{{ strtolower($produit->nom . ' ' . $produit->description) }}"
                        data-status="{{ $produit->est_disponible ? 'dispo' : 'epuise' }}">
                        <div class="dish-card-lux">
                            <!-- Image Header -->
                            <div class="dish-img-wrapper">
                                <span class="price-badge-floating">
                                    {{ number_format($produit->prix, 0, ',', ' ') }} <span class="small opacity-75">CFA</span>
                                </span>

                                <span class="status-badge-floating {{ $produit->est_disponible ? 'dispo' : 'epuise' }}">
                                    {{ $produit->est_disponible ? 'En Vente' : 'Épuisé' }}
                                </span>

                                <div class="card-actions-hover">
                                    <a href="{{ route('entrepreneur.produits.edit', $produit) }}" class="btn-action-icon" title="Modifier">
                                        <i class="fas fa-pen small"></i>
                                    </a>
                                    <button type="button" class="btn-action-icon delete" data-bs-toggle="modal" data-bs-target="#modalDelete{{ $produit->id }}" title="Supprimer">
                                        <i class="fas fa-trash small"></i>
                                    </button>
                                </div>

                                <img src="{{ $produit->photo ? (\Illuminate\Support\Str::startsWith($produit->photo, 'http') ? $produit->photo : asset('storage/' . $produit->photo)) : 'https://images.unsplash.com/photo-1546069901-ba9599a7e63c' }}"
                                    onerror="this.onerror=null;this.src='https://images.unsplash.com/photo-1546069901-ba9599a7e63c';"
                                    class="dish-img"
                                    alt="{{ $produit->nom }}">
                            </div>

                            <!-- Body Info -->
                            <div class="p-4 d-flex flex-column flex-grow-1">
                                <h5 class="fw-800 text-white mb-2 fs-5" style="font-family: 'Playfair Display', serif;">{{ $produit->nom }}</h5>
                                <p class="text-white-50 small mb-4 flex-grow-1" style="line-height: 1.6; display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden;">
                                    {{ $produit->description ?: "Une signature culinaire préparée avec passion et ingrédients de choix." }}
                                </p>

                                <!-- Toggle Stock Status -->
                                <form action="{{ route('entrepreneur.produits.toggle', $produit->id) }}" method="POST" class="mt-auto">
                                    @csrf
                                    <button type="submit" class="btn w-100 rounded-pill fw-800 py-25 text-uppercase {{ $produit->est_disponible ? 'btn-outline-danger' : 'btn-success' }}" style="font-size: 0.75rem; letter-spacing: 1px;">
                                        <i class="fas {{ $produit->est_disponible ? 'fa-minus-circle' : 'fa-check-circle' }} me-2"></i>
                                        {{ $produit->est_disponible ? 'MARQUER ÉPUISÉ' : 'REMETTRE EN VENTE' }}
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>

                    <!-- Delete Modal -->
                    <div class="modal fade" id="modalDelete{{ $produit->id }}" tabindex="-1" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered">
                            <div class="modal-content bg-dark text-white border border-secondary rounded-4 p-4 text-center">
                                <div class="mb-3 text-danger"><i class="fas fa-trash-alt fa-3x"></i></div>
                                <h4 class="fw-800 text-white mb-2">Supprimer ce plat ?</h4>
                                <p class="text-white-50 small mb-4">Voulez-vous vraiment retirer <strong class="text-white">"{{ $produit->nom }}"</strong> de votre carte ?</p>
                                <div class="d-flex justify-content-center gap-3">
                                    <button type="button" class="btn btn-outline-light rounded-pill px-4" data-bs-dismiss="modal">Annuler</button>
                                    <form action="{{ route('entrepreneur.produits.destroy', $produit) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger rounded-pill px-4 fw-800">Oui, Supprimer</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <div id="noDishesFound" class="text-center py-5 d-none opacity-50">
                <i class="fas fa-search fa-3x mb-3 text-gold"></i>
                <h5 class="fw-800">Aucun plat ne correspond à votre recherche</h5>
            </div>
        @endif
    </div>

    @push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const searchInput = document.getElementById('dishSearchInput');
            const chips = document.querySelectorAll('#statusFilterChips .filter-chip-item');
            const dishCols = document.querySelectorAll('.dish-card-col');
            const noDishes = document.getElementById('noDishesFound');
            let currentFilter = 'all';

            function filterDishes() {
                const query = searchInput ? searchInput.value.toLowerCase().trim() : '';
                let visible = 0;

                dishCols.forEach(col => {
                    const name = col.getAttribute('data-name') || '';
                    const status = col.getAttribute('data-status') || '';
                    const matchesSearch = !query || name.includes(query);
                    const matchesStatus = currentFilter === 'all' || status === currentFilter;

                    if (matchesSearch && matchesStatus) {
                        col.style.display = 'block';
                        visible++;
                    } else {
                        col.style.display = 'none';
                    }
                });

                if (noDishes) {
                    if (visible === 0) {
                        noDishes.classList.remove('d-none');
                    } else {
                        noDishes.classList.add('d-none');
                    }
                }
            }

            if (searchInput) {
                searchInput.addEventListener('input', filterDishes);
            }

            chips.forEach(chip => {
                chip.addEventListener('click', function() {
                    chips.forEach(c => c.classList.remove('active'));
                    this.classList.add('active');
                    currentFilter = this.getAttribute('data-filter') || 'all';
                    filterDishes();
                });
            });
        });
    </script>
    @endpush
@endsection
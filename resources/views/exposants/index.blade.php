@extends('layouts.app')

@section('content')
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700;800&family=Playfair+Display:ital,wght@0,700;1,700&display=swap');

        :root {
            --luxury-gold: #d4af37;
            --luxury-dark: #0f172a;
            --luxury-emerald: #10b981;
            --luxury-glass: rgba(255, 255, 255, 0.03);
            --luxury-glass-border: rgba(255, 255, 255, 0.1);
        }

        .luxury-index-wrapper {
            font-family: 'Outfit', sans-serif;
            background: radial-gradient(circle at 50% 0%, #1e293b 0%, #0f172a 100%);
            min-height: 100vh;
            color: white;
            padding-top: 4rem;
            padding-bottom: 6rem;
            overflow-x: hidden;
        }

        .luxury-mesh {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            z-index: 0;
            pointer-events: none;
            opacity: 0.4;
            background:
                radial-gradient(at 0% 0%, rgba(16, 185, 129, 0.1) 0px, transparent 50%),
                radial-gradient(at 100% 0%, rgba(212, 175, 55, 0.1) 0px, transparent 50%),
                radial-gradient(at 50% 100%, rgba(29, 78, 216, 0.05) 0px, transparent 50%);
        }

        .hero-title {
            font-family: 'Playfair Display', serif;
            font-size: 4.5rem;
            font-style: italic;
            background: linear-gradient(to right, #fff, rgba(255, 255, 255, 0.5));
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            margin-bottom: 1.5rem;
        }

        .luxury-card-exposant {
            background: var(--luxury-glass);
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            border: 1px solid var(--luxury-glass-border);
            border-radius: 35px;
            overflow: hidden;
            transition: all 0.5s cubic-bezier(0.4, 0, 0.2, 1);
            height: 100%;
            position: relative;
        }

        .luxury-card-exposant:hover {
            transform: translateY(-15px);
            border-color: var(--luxury-gold);
            background: rgba(255, 255, 255, 0.06);
            box-shadow: 0 40px 80px -20px rgba(0, 0, 0, 0.6);
        }

        .exposant-logo-container {
            height: 180px;
            padding: 30px;
            background: rgba(255, 255, 255, 0.01);
            display: flex;
            align-items: center;
            justify-content: center;
            position: relative;
            overflow: hidden;
        }

        .exposant-logo-container::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 0;
            width: 100%;
            height: 1px;
            background: linear-gradient(to right, transparent, var(--luxury-glass-border), transparent);
        }

        .logo-img-luxury {
            max-width: 100%;
            max-height: 100%;
            object-fit: contain;
            filter: drop-shadow(0 10px 20px rgba(0, 0, 0, 0.3));
            transition: transform 0.6s ease;
        }

        .luxury-card-exposant:hover .logo-img-luxury {
            transform: scale(1.1);
        }

        .luxury-badge-sector {
            position: absolute;
            top: 20px;
            left: 20px;
            background: rgba(212, 175, 55, 0.1);
            color: var(--luxury-gold);
            backdrop-filter: blur(10px);
            padding: 8px 18px;
            border-radius: 15px;
            font-size: 0.7rem;
            font-weight: 800;
            letter-spacing: 2px;
            text-transform: uppercase;
            border: 1px solid rgba(212, 175, 55, 0.2);
            z-index: 5;
        }

        .search-lux-container {
            max-width: 800px;
            margin: 0 auto 5rem;
            position: relative;
        }

        .search-lux-input {
            background: var(--luxury-glass);
            border: 1px solid var(--luxury-glass-border);
            border-radius: 25px;
            padding: 20px 30px;
            padding-left: 70px;
            color: white;
            width: 100%;
            font-size: 1.1rem;
            transition: all 0.4s;
            backdrop-filter: blur(20px);
        }

        .search-lux-input:focus {
            outline: none;
            border-color: var(--luxury-gold);
            background: rgba(255, 255, 255, 0.08);
            box-shadow: 0 0 40px rgba(212, 175, 55, 0.15);
        }

        .search-icon-lux {
            position: absolute;
            left: 25px;
            top: 50%;
            transform: translateY(-50%);
            color: var(--luxury-gold);
            font-size: 1.5rem;
            opacity: 0.6;
        }

        .filter-chip {
            background: rgba(255, 255, 255, 0.03);
            border: 1px solid rgba(255, 255, 255, 0.08);
            color: rgba(255, 255, 255, 0.4);
            padding: 10px 25px;
            border-radius: 50px;
            font-weight: 600;
            transition: all 0.3s;
            cursor: pointer;
            font-size: 0.85rem;
        }

        .filter-chip:hover,
        .filter-chip.active {
            background: var(--luxury-gold);
            color: var(--luxury-dark);
            border-color: var(--luxury-gold);
            transform: scale(1.05);
        }

        .exposant-stats-badge {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            background: rgba(16, 185, 129, 0.1);
            color: var(--luxury-emerald);
            padding: 6px 15px;
            border-radius: 50px;
            font-size: 0.75rem;
            font-weight: 700;
            margin-bottom: 1.5rem;
        }

        .btn-view-profile {
            background: transparent;
            border: 1px solid var(--luxury-gold);
            color: var(--luxury-gold);
            padding: 12px 30px;
            border-radius: 15px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 2px;
            font-size: 0.8rem;
            transition: all 0.4s;
            width: 100%;
            margin-top: auto;
        }

        .luxury-card-exposant:hover .btn-view-profile {
            background: var(--luxury-gold);
            color: var(--luxury-dark);
            box-shadow: 0 10px 20px rgba(212, 175, 55, 0.2);
        }

        @media (max-width: 768px) {
            .hero-title {
                font-size: 2.3rem !important;
                margin-bottom: 0.8rem;
            }
            .luxury-index-wrapper {
                padding-top: 2rem;
                padding-bottom: 4rem;
            }
            .exposant-logo-container {
                height: 130px !important;
                padding: 15px;
            }
            .luxury-card-exposant .p-5 {
                padding: 1.25rem !important;
            }
            .luxury-card-exposant {
                border-radius: 24px !important;
            }
            .row.g-5 {
                --bs-gutter-y: 1.25rem !important;
            }
        }
    </style>

    <div class="luxury-index-wrapper">
        <div class="luxury-mesh"></div>

        <div class="container position-relative z-index-1 animate__animated animate__fadeIn">
            <div class="text-center mb-5">
                <nav class="mb-4 opacity-50">
                    <span class="small fw-700 letter-spacing-2 text-uppercase">Expérience Exclusive <i
                            class="fas fa-chevron-right mx-3" style="font-size: 0.7rem;"></i> Catalogue</span>
                </nav>
                <h1 class="hero-title">L'Élite de la Gastronomie</h1>
                <p class="text-white-50 fs-5 mx-auto" style="max-width: 700px; font-weight: 300;">
                    Un voyage sensoriel à travers les créations les plus raffinées de nos chefs partenaires.
                </p>
            </div>

            <div class="search-lux-container mb-5">
                <i class="fas fa-search search-icon-lux"></i>
                <input type="text" id="searchInput" class="search-lux-input" placeholder="Quel voyage gustatif recherchez-vous ?">
                <div class="d-flex justify-content-center gap-2 gap-md-3 mt-4 flex-wrap" id="filterChips">
                    @php $secteurs = $exposants->pluck('secteur')->unique()->filter(); @endphp
                    <div class="filter-chip active" data-filter="all">Tous les Stands</div>
                    @foreach($secteurs as $secteur)
                        <div class="filter-chip" data-filter="{{ strtolower($secteur) }}">{{ $secteur }}</div>
                    @endforeach
                </div>
            </div>

            @if($exposants->isEmpty())
                <div class="text-center py-5 opacity-40">
                    <i class="fas fa-gem fa-4x mb-4 text-gold"></i>
                    <h3 class="fw-800">Le Panthéon est vide</h3>
                    <p>De nouvelles expériences gastronomiques arrivent bientôt.</p>
                </div>
            @else
                <div class="row g-4" id="exposantsGrid">
                    @foreach($exposants as $index => $exposant)
                        <div class="col-md-6 col-lg-4 col-xl-3 exposant-card-col animate__animated animate__fadeInUp"
                            style="animation-delay: {{ $index * 0.05 }}s"
                            data-name="{{ strtolower($exposant->nom_entreprise . ' ' . $exposant->description) }}"
                            data-secteur="{{ strtolower($exposant->secteur ?? '') }}">
                            <a href="{{ route('exposants.show', $exposant->id) }}" class="text-decoration-none h-100 d-block">
                                <div class="luxury-card-exposant d-flex flex-column h-100">
                                    @if($exposant->secteur)
                                        <div class="luxury-badge-sector">{{ $exposant->secteur }}</div>
                                    @endif

                                    <div class="exposant-logo-container">
                                        <img src="{{ $exposant->logo_url }}" class="logo-img-luxury"
                                            alt="{{ $exposant->nom_entreprise }}">
                                    </div>

                                    <div class="p-4 p-md-5 text-center d-flex flex-column flex-grow-1">
                                        <div class="exposant-stats-badge mx-auto mb-3">
                                            <i class="fas fa-certificate me-1"></i> PARTENAIRE CERTIFIÉ
                                        </div>
                                        <h4 class="fw-800 text-white mb-2 fs-5">{{ $exposant->nom_entreprise }}</h4>
                                        <p class="text-white-50 small mb-4 flex-grow-1">
                                            {{ \Illuminate\Support\Str::limit($exposant->description ?: "Une signature gastronomique unique alliant tradition et excellence.", 90) }}
                                        </p>

                                        <div class="btn-view-profile mt-auto">
                                            DÉCOUVRIR LE STAND
                                        </div>
                                    </div>
                                </div>
                            </a>
                        </div>
                    @endforeach
                </div>

                <div id="noResults" class="text-center py-5 d-none opacity-50">
                    <i class="fas fa-search fa-3x mb-3 text-gold"></i>
                    <h4 class="fw-700">Aucun stand ne correspond à votre recherche</h4>
                    <p class="small">Essayez un autre mot-clé ou modifiez la catégorie sélectionnée.</p>
                </div>
            @endif
        </div>
    </div>

    @push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const searchInput = document.getElementById('searchInput');
            const chips = document.querySelectorAll('#filterChips .filter-chip');
            const cardCols = document.querySelectorAll('.exposant-card-col');
            const noResults = document.getElementById('noResults');
            let currentFilter = 'all';

            function filterStands() {
                const query = searchInput ? searchInput.value.toLowerCase().trim() : '';
                let visibleCount = 0;

                cardCols.forEach(col => {
                    const name = col.getAttribute('data-name') || '';
                    const secteur = col.getAttribute('data-secteur') || '';
                    const matchesSearch = !query || name.includes(query);
                    const matchesFilter = currentFilter === 'all' || secteur.includes(currentFilter);

                    if (matchesSearch && matchesFilter) {
                        col.classList.remove('d-none');
                        visibleCount++;
                    } else {
                        col.classList.add('d-none');
                    }
                });

                if (noResults) {
                    if (visibleCount === 0) {
                        noResults.classList.remove('d-none');
                    } else {
                        noResults.classList.add('d-none');
                    }
                }
            }

            if (searchInput) {
                searchInput.addEventListener('input', filterStands);
            }

            chips.forEach(chip => {
                chip.addEventListener('click', function() {
                    chips.forEach(c => c.classList.remove('active'));
                    this.classList.add('active');
                    currentFilter = this.getAttribute('data-filter') || 'all';
                    filterStands();
                });
            });
        });
    </script>
    @endpush
@endsection
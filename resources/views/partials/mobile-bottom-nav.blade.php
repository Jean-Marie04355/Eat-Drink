<!-- Mobile Bottom Navigation Bar (Visible only on Mobile & Tablets) -->
<nav class="mobile-bottom-nav d-lg-none">
    @if(request()->is('entrepreneur*'))
        <!-- Barre Mobile Entrepreneur -->
        <a href="{{ route('entrepreneur.dashboard') }}" class="mobile-nav-item {{ request()->routeIs('entrepreneur.dashboard') ? 'active' : '' }}">
            <div class="nav-icon-box">
                <i class="fas fa-chart-line"></i>
            </div>
            <span>Bord</span>
        </a>

        <a href="{{ route('entrepreneur.produits.index') }}" class="mobile-nav-item {{ request()->routeIs('entrepreneur.produits.index') ? 'active' : '' }}">
            <div class="nav-icon-box">
                <i class="fas fa-utensils"></i>
            </div>
            <span>Ma Carte</span>
        </a>

        <a href="{{ route('entrepreneur.produits.create') }}" class="mobile-nav-item {{ request()->routeIs('entrepreneur.produits.create') ? 'active' : '' }}">
            <div class="nav-icon-box">
                <i class="fas fa-plus-circle text-gold"></i>
            </div>
            <span>Nouveau</span>
        </a>

        <a href="{{ route('exposants.show', Auth::id()) }}" class="mobile-nav-item" target="_blank">
            <div class="nav-icon-box">
                <i class="fas fa-store"></i>
            </div>
            <span>Mon Stand</span>
        </a>
    @else
        <!-- Barre Mobile Client / Visiteur -->
        <a href="/accueil" class="mobile-nav-item {{ request()->is('accueil') || request()->is('/') ? 'active' : '' }}">
            <div class="nav-icon-box">
                <i class="fas fa-home"></i>
            </div>
            <span>Accueil</span>
        </a>

        <a href="{{ route('exposants.index') }}" class="mobile-nav-item {{ request()->routeIs('exposants.*') ? 'active' : '' }}">
            <div class="nav-icon-box">
                <i class="fas fa-utensils"></i>
            </div>
            <span>Stands</span>
        </a>

        <a href="{{ route('panier') }}" class="mobile-nav-item {{ request()->routeIs('panier') ? 'active' : '' }}">
            <div class="nav-icon-box position-relative">
                <i class="fas fa-shopping-bag"></i>
                @if(session('panier') && count(session('panier')) > 0)
                    <span class="mobile-badge-count">{{ count(session('panier')) }}</span>
                @endif
            </div>
            <span>Panier</span>
        </a>

        @auth
            <a href="{{ route('commandes.index') }}" class="mobile-nav-item {{ request()->routeIs('commandes.*') ? 'active' : '' }}">
                <div class="nav-icon-box position-relative">
                    <i class="fas fa-receipt"></i>
                    @if(Auth::user()->getActiveOrder())
                        <span class="mobile-pulse-dot"></span>
                    @endif
                </div>
                <span>Commandes</span>
            </a>

            <a href="{{ route('client.club-prive') }}" class="mobile-nav-item {{ request()->routeIs('client.club-prive') ? 'active' : '' }}">
                <div class="nav-icon-box">
                    <i class="fas fa-crown text-gold"></i>
                </div>
                <span>Mon Club</span>
            </a>
        @else
            <a href="{{ route('commandes.rechercher') }}" class="mobile-nav-item {{ request()->routeIs('commandes.rechercher') ? 'active' : '' }}">
                <div class="nav-icon-box">
                    <i class="fas fa-search"></i>
                </div>
                <span>Suivi</span>
            </a>

            <a href="/login" class="mobile-nav-item {{ request()->is('login') ? 'active' : '' }}">
                <div class="nav-icon-box">
                    <i class="fas fa-user-circle"></i>
                </div>
                <span>Connexion</span>
            </a>
        @endauth
    @endif
</nav>

<style>
    /* Mobile Bottom Nav Styles */
    .mobile-bottom-nav {
        position: fixed;
        bottom: 0;
        left: 0;
        width: 100%;
        height: 65px;
        background: rgba(15, 23, 42, 0.95);
        backdrop-filter: blur(25px);
        -webkit-backdrop-filter: blur(25px);
        border-top: 1px solid rgba(212, 175, 55, 0.25);
        display: flex;
        align-items: center;
        justify-content: space-around;
        z-index: 1050;
        box-shadow: 0 -10px 30px rgba(0, 0, 0, 0.5);
        padding-bottom: env(safe-area-inset-bottom);
    }

    .mobile-nav-item {
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        color: rgba(255, 255, 255, 0.5);
        text-decoration: none !important;
        font-size: 0.65rem;
        font-weight: 600;
        letter-spacing: 0.5px;
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        width: 20%;
    }

    .mobile-nav-item .nav-icon-box {
        font-size: 1.25rem;
        margin-bottom: 2px;
        transition: transform 0.3s ease;
    }

    .mobile-nav-item:hover,
    .mobile-nav-item.active {
        color: #d4af37;
    }

    .mobile-nav-item.active .nav-icon-box {
        transform: translateY(-3px) scale(1.15);
        color: #d4af37;
    }

    .mobile-badge-count {
        position: absolute;
        top: -4px;
        right: -8px;
        background: #10b981;
        color: #0f172a;
        font-size: 0.6rem;
        font-weight: 800;
        width: 16px;
        height: 16px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        box-shadow: 0 0 8px rgba(16, 185, 129, 0.8);
    }

    .mobile-pulse-dot {
        position: absolute;
        top: 0;
        right: -2px;
        width: 8px;
        height: 8px;
        background: #10b981;
        border-radius: 50%;
        box-shadow: 0 0 10px rgba(16, 185, 129, 0.9);
        animation: pulseDot 1.5s infinite;
    }

    @keyframes pulseDot {
        0% { transform: scale(0.9); opacity: 1; }
        50% { transform: scale(1.4); opacity: 0.6; }
        100% { transform: scale(0.9); opacity: 1; }
    }

    /* Padding for page container so bottom nav doesn't hide content */
    @media (max-width: 991px) {
        body {
            padding-bottom: 75px !important;
        }
    }
</style>

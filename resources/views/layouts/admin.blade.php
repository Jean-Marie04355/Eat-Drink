<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Administration - Eat&Drink</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        .sidebar {
            min-height: 100vh;
            background: linear-gradient(180deg, #198754 0%, #0d6efd 100%);
            box-shadow: 2px 0 10px rgba(0,0,0,0.1);
        }
        
        .sidebar .nav-link {
            color: rgba(255,255,255,0.8);
            padding: 12px 20px;
            margin: 4px 0;
            border-radius: 8px;
            transition: all 0.3s ease;
        }
        
        .sidebar .nav-link:hover,
        .sidebar .nav-link.active {
            color: white;
            background: rgba(255,255,255,0.2);
            transform: translateX(5px);
        }
        
        .sidebar .nav-link i {
            width: 20px;
            margin-right: 10px;
        }
        
        .main-content {
            margin-left: 0;
            transition: margin-left 0.3s ease;
        }
        
        @media (min-width: 768px) {
            .main-content {
                margin-left: 250px;
            }
        }
        
        .sidebar-brand {
            padding: 20px;
            color: white;
            font-size: 1.5rem;
            font-weight: bold;
            border-bottom: 1px solid rgba(255,255,255,0.2);
            margin-bottom: 20px;
        }
        
        .sidebar-footer {
            position: absolute;
            bottom: 0;
            width: 100%;
            padding: 20px;
            border-top: 1px solid rgba(255,255,255,0.2);
        }
        
        .mobile-toggle {
            display: block;
            position: fixed;
            top: 20px;
            left: 20px;
            z-index: 1050;
            background: #198754;
            border: none;
            color: white;
            padding: 10px;
            border-radius: 5px;
        }
        
        @media (min-width: 768px) {
            .mobile-toggle {
                display: none;
            }
        }
        
        .sidebar-mobile {
            position: fixed;
            top: 0;
            left: -250px;
            width: 250px;
            height: 100vh;
            z-index: 1040;
            transition: left 0.3s ease;
        }
        
        .sidebar-mobile.show {
            left: 0;
        }
        
        .overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0,0,0,0.5);
            z-index: 1030;
            display: none;
        }
        
        .overlay.show {
            display: block;
        }
    </style>
</head>
<body>
    <!-- Mobile Toggle Button -->
    <button class="mobile-toggle d-md-none" onclick="toggleSidebar()">
        <i class="bi bi-list"></i>
    </button>
    
    <!-- Overlay for mobile -->
    <div class="overlay" id="overlay" onclick="toggleSidebar()"></div>
    
    <!-- Sidebar -->
    <div class="sidebar position-fixed d-none d-md-block" style="width: 250px;">
        <div class="sidebar-brand">
            <i class="bi bi-shield-check me-2"></i>
            Administration
        </div>
        
        <nav class="nav flex-column">
            <a class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}" href="{{ route('admin.dashboard') }}">
                <i class="bi bi-person-check"></i>
                Demandes d'approbation
            </a>
            <a class="nav-link {{ request()->routeIs('admin.commandes-entrepreneurs') ? 'active' : '' }}" href="{{ route('admin.commandes-entrepreneurs') }}">
                <i class="bi bi-box-seam"></i>
                Commandes par entrepreneur
            </a>
            <a class="nav-link {{ request()->routeIs('admin.statistiques') ? 'active' : '' }}" href="{{ route('admin.statistiques') }}">
                <i class="bi bi-graph-up"></i>
                Statistiques
            </a>
            <a class="nav-link {{ request()->routeIs('admin.tendances') ? 'active' : '' }}" href="{{ route('admin.tendances') }}">
                <i class="bi bi-activity"></i>
                Courbes de tendance
            </a>
            <a class="nav-link {{ request()->routeIs('admin.restrictions*') ? 'active' : '' }}" href="{{ route('admin.restrictions') }}">
                <i class="bi bi-shield-lock"></i>
                Restrictions
            </a>
            <a class="nav-link" href="{{ route('accueil') }}">
                <i class="bi bi-house"></i>
                Retour au site
            </a>
        </nav>
        
        <div class="sidebar-footer">
            <div class="text-white-50 small">
                <i class="bi bi-person-circle me-2"></i>
                {{ Auth::user()->email }}
            </div>
            <form method="POST" action="{{ route('logout') }}" class="mt-2">
                @csrf
                <button type="submit" class="btn btn-outline-light btn-sm w-100">
                    <i class="bi bi-box-arrow-right me-2"></i>Déconnexion
                </button>
            </form>
        </div>
    </div>
    
    <!-- Mobile Sidebar -->
    <div class="sidebar sidebar-mobile d-md-none" id="mobileSidebar">
        <div class="sidebar-brand">
            <i class="bi bi-shield-check me-2"></i>
            Administration
        </div>
        
        <nav class="nav flex-column">
            <a class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}" href="{{ route('admin.dashboard') }}" onclick="toggleSidebar()">
                <i class="bi bi-person-check"></i>
                Demandes d'approbation
            </a>
            <a class="nav-link {{ request()->routeIs('admin.commandes-entrepreneurs') ? 'active' : '' }}" href="{{ route('admin.commandes-entrepreneurs') }}" onclick="toggleSidebar()">
                <i class="bi bi-box-seam"></i>
                Commandes par entrepreneur
            </a>
            <a class="nav-link {{ request()->routeIs('admin.statistiques') ? 'active' : '' }}" href="{{ route('admin.statistiques') }}" onclick="toggleSidebar()">
                <i class="bi bi-graph-up"></i>
                Statistiques
            </a>
            <a class="nav-link {{ request()->routeIs('admin.tendances') ? 'active' : '' }}" href="{{ route('admin.tendances') }}" onclick="toggleSidebar()">
                <i class="bi bi-activity"></i>
                Courbes de tendance
            </a>
            <a class="nav-link {{ request()->routeIs('admin.restrictions*') ? 'active' : '' }}" href="{{ route('admin.restrictions') }}" onclick="toggleSidebar()">
                <i class="bi bi-shield-lock"></i>
                Restrictions
            </a>
            <a class="nav-link {{ request()->routeIs('admin.test-restriction') ? 'active' : '' }}" href="{{ route('admin.test-restriction') }}" onclick="toggleSidebar()">
                <i class="bi bi-bug"></i>
                Test Restriction
            </a>
            <a class="nav-link" href="{{ route('accueil') }}" onclick="toggleSidebar()">
                <i class="bi bi-house"></i>
                Retour au site
            </a>
        </nav>
        
        <div class="sidebar-footer">
            <div class="text-white-50 small">
                <i class="bi bi-person-circle me-2"></i>
                {{ Auth::user()->email }}
            </div>
            <form method="POST" action="{{ route('logout') }}" class="mt-2">
                @csrf
                <button type="submit" class="btn btn-outline-light btn-sm w-100">
                    <i class="bi bi-box-arrow-right me-2"></i>Déconnexion
                </button>
            </form>
        </div>
    </div>
    
    <!-- Main Content -->
    <div class="main-content">
        @yield('content')
    </div>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        function toggleSidebar() {
            const sidebar = document.getElementById('mobileSidebar');
            const overlay = document.getElementById('overlay');
            
            sidebar.classList.toggle('show');
            overlay.classList.toggle('show');
        }
    </script>
</body>
</html> 
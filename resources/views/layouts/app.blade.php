<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Eat&Drink</title>
     <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="{{ asset('../css/app.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

</head>
<body>
    @include('partials.navbar')

    <main class="container mt-4">
        @yield('content')
    </main>

</body>



<!-- Footer amélioré -->
<footer class="bg-dark text-white pt-5 pb-3 mt-5 border-top border-secondary shadow-lg">
    <div class="container">
        <div class="row gy-4 align-items-center">
            <!-- Logo & Slogan -->
            <div class="col-md-4 text-center text-md-start mb-3 mb-md-0">
                <h4 class="fw-bold mb-2" style="color: #7b1e3d;">Eat&Drink <span class="fs-5">🍽️</span></h4>
                <p class="mb-1 small">La plateforme incontournable pour découvrir, commander et savourer les meilleures créations culinaires de Cotonou.</p>
                <span class="badge bg-primary mt-2">Gastronomie & Innovation</span>
            </div>
            <!-- Liens rapides -->
            <div class="col-md-4 text-center mb-3 mb-md-0">
                <h6 class="text-uppercase fw-bold mb-3">Liens rapides</h6>
                <ul class="list-unstyled mb-0">
                    <li><a href="/accueil" class="text-white text-decoration-none"><i class="fas fa-home me-2"></i>Accueil</a></li>
                    <li><a href="{{ route('exposants.index') }}" class="text-white text-decoration-none"><i class="fas fa-users me-2"></i>Exposants</a></li>
                    <li><a href="{{ route('panier.index') }}" class="text-white text-decoration-none"><i class="fas fa-shopping-cart me-2"></i>Mon panier</a></li>
                    <li><a href="{{ route('commandes.index') }}" class="text-white text-decoration-none"><i class="fas fa-receipt me-2"></i>Mes commandes</a></li>
                </ul>
            </div>
            <!-- Contact & Réseaux -->
            <div class="col-md-4 text-center text-md-end">
                <h6 class="text-uppercase fw-bold mb-3">Contact</h6>
                <p class="mb-1"><i class="fas fa-envelope me-2"></i>contact@eatdrink.com</p>
                <p class="mb-2"><i class="fas fa-phone me-2"></i>+229 91 00 00 00</p>
                <div class="d-flex justify-content-center justify-content-md-end gap-3 mt-2">
                    <a href="#" class="text-white fs-4"><i class="fab fa-facebook-f"></i></a>
                    <a href="#" class="text-white fs-4"><i class="fab fa-twitter"></i></a>
                    <a href="#" class="text-white fs-4"><i class="fab fa-instagram"></i></a>
                    <a href="#" class="text-white fs-4"><i class="fab fa-linkedin-in"></i></a>
                </div>
            </div>
        </div>
        <hr class="my-4 border-secondary">
        <div class="text-center small">
            © {{ date('Y') }} Eat&Drink. Tous droits réservés. | Made with <span style="color: #e25555;">♥</span> à Cotonou
        </div>
    </div>
</footer>

</html>

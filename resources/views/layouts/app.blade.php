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



<!-- Footer -->
<footer class="bg-dark text-white pt-4 mt-5">
    <div class="container text-center text-md-left">
        <div class="row">
            <!-- Infos -->
            <div class="col-md-4 mb-4">
                <h5 class="text-uppercase fw-bold">Eat&Drink Admin</h5>
                <p>Plateforme de gestion d’exposants, produits et événements gastronomiques.</p>
            </div>

            <!-- Contact et réseaux -->
            <div class="col-md-4 mb-4">
                <h5 class="text-uppercase fw-bold">Contact</h5>
                <p>Email : contact@eatdrink.com</p>
                <p>Tél : +229 91 00 00 00</p>
                <div class="d-flex justify-content-start">
                    <a href="#" class="text-white me-3 social-icon"><i class="fab fa-facebook-f"></i></a>
                    <a href="#" class="text-white me-3 social-icon"><i class="fab fa-twitter"></i></a>
                    <a href="#" class="text-white me-3 social-icon"><i class="fab fa-instagram"></i></a>
                    <a href="#" class="text-white social-icon"><i class="fab fa-linkedin-in"></i></a>
                </div>
            </div>
        </div>
    </div>

    <div class="text-center py-3 border-top border-secondary mt-3">
        © {{ date('Y') }} Eat&Drink. Tous droits réservés.
    </div>
</footer>

</html>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <meta name="theme-color" content="#0f172a">
    <meta name="mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black-translucent">
    <meta name="apple-mobile-web-app-title" content="Eat&Drink">
    <link rel="manifest" href="/manifest.json">
    <link rel="icon" type="image/svg+xml" href="/images/logo.svg">
    <link rel="apple-touch-icon" href="/images/logo.svg">
    <title>Eat&Drink Premium</title>

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700;800&display=swap"
        rel="stylesheet">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <!-- Animations -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css">

    <!-- Custom Style -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">

    @stack('styles')

    <style>
        :root {
            --luxury-gold: #d4af37;
            --luxury-dark: #0f172a;
        }

        body {
            font-family: 'Outfit', sans-serif;
            background: #0f172a;
            color: white;
            overflow-x: hidden;
            scroll-behavior: smooth;
        }

        /* Custom Premium Scrollbar */
        ::-webkit-scrollbar {
            width: 8px;
        }

        ::-webkit-scrollbar-track {
            background: #0f172a;
        }

        ::-webkit-scrollbar-thumb {
            background: linear-gradient(to bottom, transparent, var(--luxury-gold), transparent);
            border-radius: 10px;
        }

        .container-main {
            min-height: 80vh;
            padding-top: 105px;
        }

        /* Selection color */
        ::selection {
            background: var(--luxury-gold);
            color: #000;
        }

        /* Global Mobile Optimization System */
        @media (max-width: 991px) {
            .container-main {
                padding-top: 95px;
                padding-bottom: 85px;
            }
        }

        @media (max-width: 768px) {
            html, body {
                max-width: 100vw;
                overflow-x: hidden;
            }

            /* Responsive Typography */
            h1, .display-1, .display-2, .display-3, .display-4 {
                font-size: clamp(1.75rem, 6vw, 2.5rem) !important;
                line-height: 1.25 !important;
            }

            h2 {
                font-size: clamp(1.4rem, 5vw, 2rem) !important;
            }

            h3 {
                font-size: clamp(1.2rem, 4.5vw, 1.6rem) !important;
            }

            .lead, p {
                font-size: 0.95rem;
            }

            /* Inputs & Forms Touch Target Optimization */
            input[type="text"],
            input[type="email"],
            input[type="password"],
            input[type="number"],
            input[type="tel"],
            select,
            textarea {
                font-size: 16px !important; /* Prevents auto-zoom in Safari iOS */
                padding: 0.75rem 1rem !important;
                border-radius: 12px !important;
            }

            .btn {
                min-height: 44px;
                display: inline-flex;
                align-items: center;
                justify-content: center;
                border-radius: 12px;
                font-size: 0.9rem;
            }

            /* Cards & Modals Padding */
            .glass-card-luxury,
            .card,
            .auth-card,
            .modal-content {
                padding: 1.25rem !important;
                border-radius: 1.25rem !important;
            }

            /* Grid Columns Spacing */
            .row.g-4, .row.g-5 {
                --bs-gutter-y: 1.25rem;
            }

            /* Tables Responsiveness */
            .table-responsive {
                border-radius: 12px;
                overflow-x: auto;
                -webkit-overflow-scrolling: touch;
            }

            .table th, .table td {
                padding: 0.75rem 0.5rem;
                font-size: 0.85rem;
                white-space: nowrap;
            }
        }
    </style>
</head>

<body>
    @include('partials.navbar')

    <main class="container-main">
        @yield('content')
    </main>

    @include('partials.footer')
    @include('partials.mobile-bottom-nav')

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        if ('serviceWorker' in navigator) {
            window.addEventListener('load', () => {
                navigator.serviceWorker.register('/sw.js').catch(err => console.log('SW reg error: ', err));
            });
        }
    </script>
    @stack('scripts')
</body>

</html>
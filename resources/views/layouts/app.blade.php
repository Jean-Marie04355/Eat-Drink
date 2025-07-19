<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Eat&Drink</title>
     <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="{{ asset('../css/app.css') }}" rel="stylesheet">
</head>
<body>
    @include('partials.navbar')

    <main class="container mt-4">
        @yield('content')
    </main>

    @include('partials.footer')
    <script src="{{ asset('js/app.js') }}"></script>
</body>
</html>

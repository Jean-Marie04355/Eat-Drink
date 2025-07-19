@extends('layouts.app')

@section('content')
<div class="container mt-5" style="max-width: 600px;">
    <div class="card shadow-sm border-0">
        <div class="card-body p-4">
            <h3 class="text-center fw-bold mb-4" style="color: #7b1e3d;">Connexion Eat&Drink</h3>

            @if (session('status'))
                <div class="alert alert-info text-center">
                    {{ session('status') }}
                </div>
            @endif

            <form method="POST" action="{{ route('login.process') }}">
                @csrf

                <!-- Email -->
                <div class="mb-3">
                    <label for="email" class="form-label">Adresse email</label>
                    <input type="email" id="email" name="email"
                        class="form-control @error('email') is-invalid @enderror"
                        value="{{ old('email') }}" required autofocus>
                    @error('email')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Mot de passe -->
                <div class="mb-4">
                    <label for="password" class="form-label">Mot de passe</label>
                    <input type="password" id="password" name="password"
                        class="form-control @error('password') is-invalid @enderror" required>
                    @error('password')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Bouton -->
                <div class="d-grid">
                    <button type="submit" class="btn btn-lg" style="background-color: #7b1e3d; color: white;">
                        Se connecter
                    </button>
                </div>
            </form>

            <p class="mt-4 text-center text-muted">
                Pas encore inscrit ? <a href="{{ route('auth.inscription') }}" class="fw-bold text-decoration-none" style="color: #7b1e3d;">Demandez un stand ici</a>
            </p>
        </div>
    </div>
</div>
@endsection

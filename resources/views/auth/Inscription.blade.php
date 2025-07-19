@extends('layouts.app')
@section('content')
<div class="container mt-5" style="max-width: 600px;">
    <div class="card shadow-sm border-0">
        <div class="card-body p-4">
            <h2 class="text-center fw-bold mb-4" style="color: #7b1e3d;">Demande de Stand Eat&Drink</h2>

            @if (session('status'))
                <div class="alert alert-info text-center">
                    {{ session('status') }}
                </div>
            @endif

            <form method="POST" action="{{ route('auth.inscription') }}">
                @csrf

                <!-- Nom entreprise -->
                <div class="mb-3">
                    <label for="nom_entreprise" class="form-label">Nom de l’entreprise</label>
                    <input type="text" id="nom_entreprise" name="nom_entreprise"
                        class="form-control @error('nom_entreprise') is-invalid @enderror"
                        value="{{ old('nom_entreprise') }}" required>
                    @error('nom_entreprise')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Email -->
                <div class="mb-3">
                    <label for="email" class="form-label">Adresse email</label>
                    <input type="email" id="email" name="email"
                        class="form-control @error('email') is-invalid @enderror"
                        value="{{ old('email') }}" required>
                    @error('email')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Mot de passe -->
                <div class="mb-3">
                    <label for="password" class="form-label">Mot de passe</label>
                    <input type="password" id="password" name="password"
                        class="form-control @error('password') is-invalid @enderror"
                        required>
                    @error('password')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Confirmation -->
                <div class="mb-4">
                    <label for="password_confirmation" class="form-label">Confirmer le mot de passe</label>
                    <input type="password" id="password_confirmation" name="password_confirmation"
                        class="form-control" required>
                </div>

                <!-- Bouton rouge au vin -->
                <div class="d-grid">
                    <button type="submit" class="btn btn-lg" style="background-color: #7b1e3d; color: white;">
                        Soumettre la demande
                    </button>
                </div>
            </form>

            <p class="mt-4 text-center text-muted">
                Déjà un compte ? <a href="{{ route('login') }}" class="fw-bold text-decoration-none" style="color: #7b1e3d;">Connectez-vous ici</a>.
            </p>
        </div>
    </div>
</div>
@endsection

@extends('layouts.app')

@section('content')
<div class="container mt-5" style="max-width: 500px;">
    <h2 class="mb-4 text-center">Connexion à Eat&Drink</h2>

    @if (session('status'))
        <div class="alert alert-success">
            {{ session('status') }}
        </div>
    @endif

    <form method="POST" action="/login">
        @csrf

        <!-- Adresse email -->
        <div class="mb-3">
            <label for="email" class="form-label">Adresse email</label>
            <input type="email" id="email" name="email"
                value="{{ old('email') }}"
                class="form-control @error('email') is-invalid @enderror"
                required autofocus>

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

        <!-- Soumettre -->
        <div class="d-grid gap-2">
            <button type="submit" class="btn btn-primary">Se connecter</button>
        </div>
    </form>

    <p class="mt-3 text-center">
        Pas encore inscrit ? <a href="/inscription">Demandez un stand ici</a>.
    </p>
</div>
@endsection

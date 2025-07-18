<!-- Inscription des visiteurs et des entrepreneurs -->
 <!DOCTYPE html>
 <html lang="en">
 <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inscription</title>
 </head>
 <body>
    <!-- Formulaire d'inscription -->
     @extends('layouts.app')

@section('content')
<div class="container mt-5">
    <h2 class="mb-4">Demande de stand</h2>
    <form method="POST" action="/inscription">
        @csrf

        <!-- Nom de l'entreprise -->
        <div class="mb-3">
            <label for="nom_entreprise" class="form-label">Nom de l’entreprise</label>
            <input type="text" class="form-control @error('nom_entreprise') is-invalid @enderror" id="nom_entreprise" name="nom_entreprise" value="{{ old('nom_entreprise') }}" required>
            @error('nom_entreprise')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <!-- Email -->
        <div class="mb-3">
            <label for="email" class="form-label">Adresse email</label>
            <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email" value="{{ old('email') }}" required>
            @error('email')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <!-- Mot de passe -->
        <div class="mb-3">
            <label for="password" class="form-label">Mot de passe</label>
            <input type="password" class="form-control @error('password') is-invalid @enderror" id="password" name="password" required>
            @error('password')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <!-- Confirmation -->
        <div class="mb-3">
            <label for="password_confirmation" class="form-label">Confirmer le mot de passe</label>
            <input type="password" class="form-control" id="password_confirmation" name="password_confirmation" required>
        </div>

        <!-- Bouton -->
        <button type="submit" class="btn btn-success">Soumettre la demande</button>
    </form>

    <p class="mt-3">Déjà un compte ? <a href="/ogin">Connectez-vous ici</a>.</p>
</div>
@endsection

 </body>
 </html>
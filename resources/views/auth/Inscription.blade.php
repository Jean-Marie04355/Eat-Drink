@extends('layouts.app')
@section('content')
    <div class="container py-5" style="max-width: 650px;">
        <div class="card shadow-lg border-0 rounded-4 overflow-hidden">
            <div class="row g-0">
                <div class="col-md-5 d-none d-md-flex align-items-center justify-content-center bg-light" style="background: linear-gradient(135deg, #f8e1e7 0%, #fff 100%);">
                    <div class="text-center w-100 p-4">
                        <img src="https://img.icons8.com/color/96/chef-hat.png" alt="Demande de stand" class="mb-3" style="max-width: 90px;">
                        <h5 class="fw-bold mb-2" style="color: #198754;">Rejoignez Eat&Drink !</h5>
                        <ul class="list-unstyled small text-muted text-start mx-auto" style="max-width: 220px;">
                            <li><i class="fas fa-check-circle text-success me-2"></i>Visibilité locale</li>
                            <li><i class="fas fa-check-circle text-success me-2"></i>Gestion simple</li>
                            <li><i class="fas fa-check-circle text-success me-2"></i>Support dédié</li>
                        </ul>
                    </div>
                </div>
                <div class="col-md-7">
                    <div class="card-body p-4">
                        <h2 class="text-center fw-bold mb-4" style="color: #198754;">Demande de Stand</h2>
                        <div class="mb-4 d-flex justify-content-center gap-2">
                            <span class="badge bg-success">1</span> <span class="text-muted">Infos</span>
                            <span class="badge bg-secondary">2</span> <span class="text-muted">Validation</span>
                        </div>
                        @if (session('status'))
                            <div class="alert alert-info text-center">{{ session('status') }}</div>
                        @endif
                        <form method="POST" action="{{ route('auth.inscription') }}">
                            @csrf
                            <div class="mb-3">
                                <label for="nom_entreprise" class="form-label">Nom de l’entreprise <span class="text-danger">*</span></label>
                                <input type="text" id="nom_entreprise" name="nom_entreprise" class="form-control @error('nom_entreprise') is-invalid @enderror" value="{{ old('nom_entreprise') }}" placeholder="Ex : Le Goût du Bénin" required autofocus>
                                @error('nom_entreprise')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                            <div class="mb-3">
                                <label for="email" class="form-label">Adresse email <span class="text-danger">*</span></label>
                                <input type="email" id="email" name="email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email') }}" placeholder="exposant@email.com" required>
                                @error('email')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                            <div class="mb-3">
                                <label for="password" class="form-label">Mot de passe <span class="text-danger">*</span></label>
                                <input type="password" id="password" name="password" class="form-control @error('password') is-invalid @enderror" placeholder="••••••••" required>
                                @error('password')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                            <div class="mb-4">
                                <label for="password_confirmation" class="form-label">Confirmer le mot de passe <span class="text-danger">*</span></label>
                                <input type="password" id="password_confirmation" name="password_confirmation" class="form-control" placeholder="••••••••" required>
                            </div>
                            <div class="d-grid">
                                <button type="submit" class="btn btn-lg" style="background-color: #198754; color: white;">Soumettre la demande</button>
                            </div>
                        </form>
                        <p class="mt-4 text-center text-muted small">
                            Déjà un compte ? <a href="{{ route('login') }}" class="fw-bold text-decoration-none" style="color: #198754;">Connectez-vous ici</a>.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
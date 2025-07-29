@extends('layouts.app')

@section('content')
<div class="container py-5" style="max-width: 500px;">
    <div class="card shadow-lg border-0 rounded-4 overflow-hidden">
        <div class="row g-0">
            <div class="col-md-5 d-none d-md-flex align-items-center justify-content-center bg-light" style="background: linear-gradient(135deg, #f8e1e7 0%, #fff 100%);">
                <img src="https://img.icons8.com/color/96/lock-2.png" alt="Connexion" class="img-fluid" style="max-width: 80px;">
            </div>
            <div class="col-md-7">
                <div class="card-body p-4">
                    <h3 class="text-center fw-bold mb-4" style="color: #198754;">Connexion Eat&Drink</h3>
                    @if (session('status'))
                        <div class="alert alert-info text-center">{{ session('status') }}</div>
                    @endif
                    <form method="POST" action="{{ route('login.process') }}">
                        @csrf
                        <div class="mb-3">
                            <label for="email" class="form-label">Adresse email <span class="text-danger">*</span></label>
                            <input type="email" id="email" name="email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email') }}" placeholder="exposant@email.com" required autofocus>
                            @error('email')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="mb-4">
                            <label for="password" class="form-label">Mot de passe <span class="text-danger">*</span></label>
                            <input type="password" id="password" name="password" class="form-control @error('password') is-invalid @enderror" placeholder="••••••••" required>
                            @error('password')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="d-grid">
                            <button type="submit" class="btn btn-lg" style="background-color: #198754; color: white;">Se connecter</button>
                        </div>
                    </form>
                    <p class="mt-4 text-center text-muted small">
                        Pas encore inscrit ? <a href="{{ route('auth.inscription') }}" class="fw-bold text-decoration-none" style="color: #198754;">Demandez un stand ici</a>
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@extends('layouts.admin')

@section('content')
<div class="container-fluid px-4 py-4">
    <div class="row mb-4">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <div>
                    <h1 class="h3 mb-0 text-warning">
                        <i class="bi bi-bug me-2"></i>Test de Restriction
                    </h1>
                    <p class="text-muted mb-0">Simuler une restriction pour tester l'interface</p>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-8 mx-auto">
            <div class="card shadow">
                <div class="card-header bg-warning text-dark">
                    <h6 class="mb-0">
                        <i class="bi bi-gear me-2"></i>Simulation de restriction
                    </h6>
                </div>
                <div class="card-body">
                    <form method="GET" action="{{ route('auth.restriction') }}">
                        <div class="mb-3">
                            <label for="testEmail" class="form-label">Email de l'entrepreneur à tester</label>
                            <input type="email" class="form-control" id="testEmail" name="email" 
                                   placeholder="exemple@email.com" required>
                            <small class="text-muted">Entrez l'email d'un entrepreneur pour voir la page de restriction</small>
                        </div>
                        <div class="d-grid">
                            <button type="submit" class="btn btn-warning">
                                <i class="bi bi-eye me-2"></i>Voir la page de restriction
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="row mt-4">
        <div class="col-lg-8 mx-auto">
            <div class="card shadow">
                <div class="card-header bg-info text-white">
                    <h6 class="mb-0">
                        <i class="bi bi-info-circle me-2"></i>Instructions de test
                    </h6>
                </div>
                <div class="card-body">
                    <ol>
                        <li>Créez d'abord une restriction pour un entrepreneur via la page "Restrictions"</li>
                        <li>Entrez l'email de cet entrepreneur dans le champ ci-dessus</li>
                        <li>Cliquez sur "Voir la page de restriction" pour simuler l'expérience</li>
                        <li>Vous verrez exactement ce que verra l'entrepreneur restreint</li>
                    </ol>
                    
                    <div class="alert alert-info mt-3">
                        <i class="bi bi-lightbulb me-2"></i>
                        <strong>Astuce :</strong> Vous pouvez aussi tester en vous connectant directement avec le compte de l'entrepreneur restreint.
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 
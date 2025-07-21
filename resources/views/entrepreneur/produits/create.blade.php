@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="fw-bold">➕ Ajouter un produit</h2>
        <a href="{{ route('entrepreneur.produits.index') }}" class="btn btn-secondary">
            ⬅️ Retour à la liste
        </a>
    </div>

    @if ($errors->any())
        <div class="alert alert-danger">
            <strong>Erreur !</strong> Veuillez corriger les champs ci-dessous :
            <ul class="mb-0 mt-2">
                @foreach ($errors->all() as $error)
                    <li>⚠️ {{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('entrepreneur.produits.store') }}" method="POST" enctype="multipart/form-data" class="bg-light p-4 rounded shadow-sm">
        @csrf

        <div class="mb-3">
            <label for="nom" class="form-label">📝 Nom du produit</label>
            <input type="text" name="nom" id="nom" class="form-control" value="{{ old('nom') }}" required>
        </div>

        <div class="mb-3">
            <label for="description" class="form-label">📃 Description</label>
            <textarea name="description" id="description" rows="4" class="form-control" required>{{ old('description') }}</textarea>
        </div>

        <div class="mb-3">
            <label for="prix" class="form-label">💰 Prix (en FCFA)</label>
            <input type="number" name="prix" id="prix" class="form-control" value="{{ old('prix') }}" required min="0">
        </div>

        <div class="mb-3">
            <label for="photo" class="form-label">📸 Photo du produit (facultatif)</label>
            <input type="file" name="photo" id="photo" class="form-control">
        </div>

        <div class="text-end">
            <button type="submit" class="btn btn-primary">
                💾 Enregistrer le produit
            </button>
        </div>
    </form>
</div>
@endsection

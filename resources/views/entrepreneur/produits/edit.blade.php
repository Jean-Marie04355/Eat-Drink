@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="fw-bold">✏️ Modifier le produit</h2>
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

    <form action="{{ route('entrepreneur.produits.update', $produit->id) }}" method="POST" enctype="multipart/form-data" class="bg-light p-4 rounded shadow-sm">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label for="nom" class="form-label">📝 Nom du produit</label>
            <input type="text" name="nom" id="nom" class="form-control" value="{{ old('nom', $produit->nom) }}" required>
        </div>

        <div class="mb-3">
            <label for="description" class="form-label">📃 Description</label>
            <textarea name="description" id="description" rows="4" class="form-control" required>{{ old('description', $produit->description) }}</textarea>
        </div>

        <div class="mb-3">
            <label for="prix" class="form-label">💰 Prix (en FCFA)</label>
            <input type="number" name="prix" id="prix" class="form-control" value="{{ old('prix', $produit->prix) }}" required min="0">
        </div>

        <div class="mb-3">
            <label class="form-label">📸 Image actuelle</label><br>
            @if ($produit->photo)
                <img src="{{ asset('storage/' . $produit->photo) }}" alt="Image du produit" class="img-thumbnail mb-2" style="max-width: 200px;">
            @else
                <p><em>Aucune image</em></p>
            @endif
        </div>

        <div class="mb-3">
            <label for="photo" class="form-label">🔄 Changer la photo (facultatif)</label>
            <input type="file" name="photo" id="photo" class="form-control">
        </div>

        <div class="text-end">
            <button type="submit" class="btn btn-success">
                ✅ Mettre à jour
            </button>
        </div>
    </form>
</div>
@endsection

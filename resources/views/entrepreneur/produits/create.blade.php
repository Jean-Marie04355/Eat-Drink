<!-- Formulaire d'ajout de produits -->
@extends('layouts.app')

@section('content')
    <div class="container mt-5" style="max-width: 650px;">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 style="color: #7b1e3d;">Ajouter un produit</h2>
        <a href="{{ route('entrepreneur.produits.index') }}" class="btn btn-secondary">
            Retour à la liste
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
            <label for="nom" class="form-label"> Nom du produit</label>
            <input type="text" name="nom" id="nom" class="form-control" value="{{ old('nom') }}"  placeholder="Ex: Jus de bissap" style=" 
                                        border-color: #f9f6f7ff;
                                        box-shadow: 0 0 0 0.15rem rgba(190, 186, 187, 0.25);
                                        outline: none;" required>
        </div>

        <div class="mb-3">
            <label for="description" class="form-label">Description</label>
            <textarea name="description" id="description" rows="4" class="form-control" placeholder="Frais, naturel, fait maison" style=" 
                                        border-color: #f9f6f7ff;
                                        box-shadow: 0 0 0 0.15rem rgba(190, 186, 187, 0.25);
                                        outline: none;" required>{{ old('description') }}</textarea>
        </div>

        <div class="mb-3">
            <label for="prix" class="form-label"> Prix (en FCFA)</label>
            <input type="number" name="prix" id="prix" class="form-control" value="{{ old('prix') }}"  placeholder="Ex: 1500" style=" 
                                        border-color: #f9f6f7ff;
                                        box-shadow: 0 0 0 0.15rem rgba(190, 186, 187, 0.25);
                                        outline: none;" required min="0">
        </div>

        <div class="mb-4">
            <label for="photo" class="form-label">Photo du produit (facultatif)</label>
            <input type="file" name="photo" id="photo" class="form-control"  style=" 
                                        border-color: #f9f6f7ff;
                                        box-shadow: 0 0 0 0.15rem rgba(190, 186, 187, 0.25);
                                        outline: none;">
        </div>

             <div class="d-grid">
                <button type="submit" class="btn btn-lg" style="background-color: #7b1e3d; color: white;">
                    Ajouter
                </button>
            </div>
        </div>
    </form>
</div>
@endsection

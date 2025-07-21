{{-- resources/views/entrepreneur/dashboard.blade.php --}}
@extends('layouts.app')

@section('content')
<div class="container py-5">
    <h1 class="mb-4 text-center">Bienvenue sur votre espace entrepreneur</h1>

    <div class="card shadow-sm mb-4">
        <div class="card-header bg-success text-white">
            <h5 class="mb-0">Informations du compte</h5>
        </div>
        <div class="card-body">
            <dl class="row mb-0">
               
                <dt class="col-sm-3">Email :</dt>
                <dd class="col-sm-9">{{ Auth::user()->email }}</dd>

                <dt class="col-sm-3">Entreprise :</dt>
                <dd class="col-sm-9">{{ Auth::user()->nom_entreprise }}</dd>

                <dt class="col-sm-3">Statut :</dt>
                <dd class="col-sm-9 text-capitalize">
                    @if(Auth::user()->role === 'entrepreneur_approuve')
                        Approuvé
                    @elseif(Auth::user()->role === 'entrepreneur_en_attente')
                        En attente
                    @else
                        {{ Auth::user()->role }}
                    @endif
                </dd>
            </dl>
        </div>
    </div>

    <div class="d-flex justify-content-center gap-3 flex-wrap">
        <a href="{{ route('entrepreneur.produits.index') }}" class="btn btn-outline-success btn-lg">
            📦 Mes Produits
        </a>
        <a href="{{ route('exposants.index') }}" class="btn btn-primary btn-lg">
            Voir la liste des produits exposés
        </a>
    </div>

    {{-- Ici tu peux ajouter d'autres sections ou infos importantes pour l'entrepreneur --}}
</div>
@endsection

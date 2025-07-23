@extends('layouts.app')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow-lg border-0 rounded-4">
                <div class="card-body text-center p-5">
                    <h2 class="mb-4 text-warning fw-bold">⏳ Compte en attente d'approbation</h2>
                    <p class="fs-5 text-muted mb-4">
                        Merci pour votre inscription sur <span class="fw-bold text-success">Eat&Drink</span> !<br>
                        Votre demande a bien été prise en compte.<br>
                        Un administrateur va examiner votre profil et vous recevrez un email dès que votre compte sera activé.
                    </p>
                    <div class="alert alert-info mt-4">
                        <i class="bi bi-info-circle"></i> Vous ne pouvez pas accéder à la plateforme tant que votre compte n'est pas validé.
                    </div>
                    <a href="/logout" class="btn btn-outline-secondary mt-4">Se déconnecter</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
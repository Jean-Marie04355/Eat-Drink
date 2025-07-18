<!-- Page de l'entrepreneur après inscription -->
@extends('layouts.app')

@section('content')
<div class="container mt-5 text-center">
    <h2 class="mb-3">Demande en attente</h2>
    <p class="lead">Merci pour votre inscription à <strong>Eat&Drink</strong>.</p>
    <p>
        Votre demande de stand a bien été enregistrée et est actuellement en cours de validation
        par notre équipe. 👩‍🍳🧾
    </p>

    <p>
        Une fois approuvée, vous recevrez un email de confirmation
        et vous aurez accès à votre tableau de bord exposant.
    </p>

    <hr class="my-4">

    <p class="text-muted">Si vous avez des questions, contactez-nous à <a href="mailto:contact@eatdrink.com">contact@eatdrink.com</a></p>

    <a href="/logout"  class="btn btn-outline-danger mt-3">Déconnexion</a>
</div>
@endsection
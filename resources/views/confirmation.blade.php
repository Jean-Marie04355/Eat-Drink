<!-- simple page après commande -->
 @extends('layouts.app')

@section('content')
<div class="container mt-5 text-center" style="max-width: 600px;">
    <div class="card border-0 shadow-sm bg-light p-4">
        <h2 class="fw-bold mb-3" style="color: #7b1e3d;">Commande validée !</h2>
        <p class="lead">Merci pour votre commande auprès de nos exposants.</p>
        <p>Votre sélection a été transmise à l’équipe concernée et sera préparée avec attention.</p>

        <hr class="my-4">

        <p class="text-muted">Un récapitulatif pourra être envoyé par email si cette fonction est activée dans la suite du projet.</p>
        <a href="{{ route('exposants.index') }}" class="btn btn-outline-dark mt-3">Retour aux stands</a>
    </div>
</div>
@endsection

@extends('layouts.app')

@section('content')
<div class="container my-4">
    <h2 class="mb-4 text-center">Demandes en attente d'approbation</h2>

    @if(session('status'))
        <div class="alert alert-success text-center">{{ session('status') }}</div>
    @endif

    @if($demandes->isEmpty())
        <div class="alert alert-info text-center">Aucune demande en attente.</div>
    @else
        <div class="table-responsive">
            <table class="table table-hover align-middle text-center">
                <thead class="table-dark">
                    <tr>
                        <th scope="col">Email</th>
                        <th scope="col">Entreprise</th>
                        <th scope="col">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($demandes as $user)
                        <tr>
                            <td><span class="badge bg-secondary">{{ $user->email }}</span></td>
                            <td>{{ $user->nom_entreprise }}</td>
                            <td>
                                <!-- Approuver -->
                                <form method="POST" action="{{ route('admin.approuver', $user->id) }}" class="d-inline">
                                    @csrf
                                    <button type="submit" class="btn btn-outline-success btn-sm">
                                         Approuver
                                    </button>
                                </form>

                                <!-- Rejeter -->
                                <button type="button" class="btn btn-outline-danger btn-sm" onclick="toggleRejectForm({{ $user->id }})">
                                    Rejeter
                                </button>

                                <!-- Formulaire de rejet -->
                                <div id="reject-form-{{ $user->id }}" class="mt-2 d-none">
                                    <form method="POST" action="{{ route('admin.rejeter', $user->id) }}">
                                        @csrf
                                        <textarea name="motif_rejet" class="form-control my-2" rows="2" placeholder="Motif du rejet..." required></textarea>
                                        <button type="submit" class="btn btn-danger btn-sm">Confirmer rejet</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @endif
</div>

<!-- Script d'affichage du formulaire de rejet -->
<script>
    function toggleRejectForm(userId) {
        const form = document.getElementById('reject-form-' + userId);
        form.classList.toggle('d-none');
    }
</script>
@endsection

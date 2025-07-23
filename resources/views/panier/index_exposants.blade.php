<h2>Mon panier d’exposants</h2>
@if(session('success'))
    <div style="color: green;">{{ session('success') }}</div>
@endif
<ul>
    @forelse($panierExposants as $id => $exposant)
        <li>
            {{ $exposant['nom'] }} (Stand : {{ $exposant['stand'] }})
            <form action="{{ route('panier.retirerExposant', $id) }}" method="POST" style="display:inline;">
                @csrf
                <button type="submit">Retirer</button>
            </form>
        </li>
    @empty
        <li>Votre panier d’exposants est vide.</li>
    @endforelse
</ul> 
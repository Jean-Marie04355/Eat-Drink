<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <div class="container">
        <a class="navbar-brand" href="/accueil">Eat&Drink</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navMain">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navMain">
            <ul class="navbar-nav ms-auto">
                @guest
                    <li class="nav-item"><a class="nav-link" href="/login">Se connecter</a></li>
                    <li class="nav-item"><a class="nav-link" href="/inscription">Demander un stand</a></li>
                @else
                    @if(Auth::user()->role === 'admin')
                        <li class="nav-item"><a class="nav-link" href="{{ route('admin.dashboard') }}">Admin</a></li>
                    @elseif(Auth::user()->role === 'entrepreneur_approuve')
                       <li class="nav-item"><a class="nav-link" href="{{ route('entrepreneur.dashboard') }}">Accueil</a></li>
                       <li class="nav-item"><a class="nav-link" href="{{ route('entrepreneur.produits.index') }}">Produits</a></li>
                       <li class="nav-item"><a class="nav-link" href="{{ route('entrepreneur.dashboard') }}">Commandes</a></li>
                       <li class="nav-item"><a class="nav-link" href="/exposants/{{ Auth::user()->id }}">Stand</a></li>
                    @elseif(Auth::user()->role === 'entrepreneur_en_attente')
                        <li class="nav-item"><a class="nav-link" href="{{ route('auth.statut') }}">Statut</a></li>
                    @endif

                    <li class="nav-item">
                        <form method="POST" action="/logout">
                            @csrf
                            <button class="btn btn-link nav-link" type="submit">Déconnexion</button>
                        </form>
                    </li>
                @endguest
            </ul>
        </div>
    </div>
</nav>

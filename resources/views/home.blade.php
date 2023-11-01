@extends('layouts.app')

@section('content')
    <div class="container">
        @auth
            <h1>Bienvenue sur la page d'accueil</h1>
            <p>Vous êtes connecté en tant que {{ Auth::user()->nom }} {{ Auth::user()->prenom }}</p>
            <a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">Déconnexion</a>
            <a href="{{ route('add.bottle') }}">Ajouter une bouteille</a>
            <a href="{{ route('purchase.list') }}">Liste des achats</a>
            <a href="{{ route('cellier.create') }}">Ajouter un cellier</a>
            <a href="{{ route('search') }}">Recherche par catégorie</a>
        @else
            <p>Vous devez vous connecter pour accéder à la page d'accueil.</p>
            <a href="{{ route('login') }}">Connexion</a>
        @endauth
    </div>
@endsection

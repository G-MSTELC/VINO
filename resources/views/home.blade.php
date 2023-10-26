@extends('layouts.app')

@section('content')
    <div class="container">
        @auth
            <h1>Bienvenue sur la page d'accueil</h1>
            <p>Vous êtes connecté en tant que {{ Auth::user()->nom }} {{ Auth::user()->prenom }}</p>
            <a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">Déconnexion</a>
            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                @csrf
            </form>
            <a href="{{ route('add.bottle') }}">Ajouter une bouteille</a>
            <a href="{{ route('purchase.list') }}">Liste des achats</a>
        @else
            <p>Vous devez vous connecter pour accéder à la page d'accueil.</p>
            <a href="{{ route('login') }}">Connexion</a>
        @endauth
    </div>
@endsection

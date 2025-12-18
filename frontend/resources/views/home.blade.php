@extends('layouts.app')

@section('title', 'Accueil')

@section('content')
<div class="max-w-7xl mx-auto px-4 mt-10">

    <div class="bg-orange-500 text-white rounded-lg p-10">
        <h1 class="text-4xl font-bold mb-4">
            Bienvenue sur Helectro
        </h1>

        <p class="text-lg mb-6">
            Achetez vos produits électroniques en toute simplicité.
        </p>

        <a href="/catalogue"
           class="bg-white text-indigo-600 px-6 py-3 rounded font-semibold">
            Voir le catalogue
        </a>
    </div>

</div>
@endsection

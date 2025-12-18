@extends('layouts.app')

@section('title', 'Accueil')

@section('content')
<div class="text-center">
    <h1 class="text-4xl font-bold mb-4 text-indigo-600">
        Bienvenue sur HELECTRO
    </h1>

    <p class="text-gray-700 text-lg mb-6">
        La plateforme de personnalisation d’objets : T-shirts, Mugs, Découpes Laser, Impression 3D, et bien plus !
    </p>

    <a href="{{ url('/catalogue') }}"
       class="px-6 py-3 bg-indigo-600 text-white rounded-lg shadow hover:bg-indigo-700 transition">
        Voir le Catalogue
    </a>
</div>
@endsection

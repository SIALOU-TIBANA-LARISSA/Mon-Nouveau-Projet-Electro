@extends('layouts.app')

@section('title', 'Votre compte')

@section('content')
<div class="max-w-4xl mx-auto px-4 py-8">

    <h1 class="text-2xl font-bold mb-6">Votre compte</h1>

    <div class="bg-white shadow rounded p-6 space-y-4">
        <p class="text-gray-700">
            Bienvenue dans votre espace client.
        </p>

        <a href="/my-orders"
           class="inline-block bg-orange-500 text-white px-4 py-2 rounded hover:bg-orange-600">
            Voir mes commandes
        </a>
    </div>

</div>
@endsection

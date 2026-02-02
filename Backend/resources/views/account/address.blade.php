@extends('layouts.app')

@section('content')
<div class="max-w-5xl mx-auto px-4 py-8">
    <h1 class="text-2xl font-bold mb-6">📍 Mes adresses</h1>

    <p class="text-red-500">
        Erreur lors du chargement des adresses.
    </p>

    <a href="{{ route('account') }}"
       class="text-orange-500 hover:underline">
        ← Retour à mon compte
    </a>
</div>
@endsection

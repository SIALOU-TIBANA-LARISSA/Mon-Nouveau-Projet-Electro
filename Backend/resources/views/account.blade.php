@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto bg-white p-6 rounded shadow">
    <h1 class="text-2xl font-bold mb-4">Votre compte</h1>

    <p><strong>Nom :</strong> {{ auth()->user()->name }}</p>
    <p><strong>Email :</strong> {{ auth()->user()->email }}</p>

    <p class="mt-4 text-gray-600">
        Cette page permet au client de consulter ses informations personnelles.
    </p>
</div>
@endsection

@extends('layouts.app')

@section('title', 'Merci pour votre commande')

@section('content')
<div class="max-w-3xl mx-auto bg-white shadow p-8 rounded-lg text-center mt-10">

    <h1 class="text-4xl font-bold text-orange-600 mb-6">
        🎉 Merci pour votre commande !
    </h1>

    <p class="text-lg text-gray-700 mb-6">
        Votre commande a été enregistrée avec succès.
    </p>

    <a href="/catalogue"
       class="bg-orange-500 text-white px-6 py-3 rounded hover:bg-orange-500">
        Retour au catalogue
    </a>

</div>
@endsection

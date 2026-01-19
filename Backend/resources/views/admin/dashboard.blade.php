@extends('layouts.admin')

@section('content')

<h1 class="text-2xl font-bold mb-6">📊 Tableau de bord</h1>

<div class="grid grid-cols-1 md:grid-cols-3 lg:grid-cols-5 gap-6">

    <!-- Commandes -->
    <div class="bg-white shadow rounded p-4 text-center">
        <p class="text-gray-500">Total commandes</p>
        <p class="text-3xl font-bold">{{ $stats['total_orders'] }}</p>
    </div>

    <div class="bg-yellow-100 shadow rounded p-4 text-center">
        <p class="text-gray-600">En attente</p>
        <p class="text-3xl font-bold">{{ $stats['pending_orders'] }}</p>
    </div>

    <div class="bg-green-100 shadow rounded p-4 text-center">
        <p class="text-gray-600">Payées</p>
        <p class="text-3xl font-bold">{{ $stats['paid_orders'] }}</p>
    </div>

    <!-- Produits -->
    <div class="bg-blue-100 shadow rounded p-4 text-center">
        <p class="text-gray-600">Produits</p>
        <p class="text-3xl font-bold">{{ $stats['products'] }}</p>
    </div>

    <!-- Utilisateurs -->
    <div class="bg-purple-100 shadow rounded p-4 text-center">
        <p class="text-gray-600">Utilisateurs</p>
        <p class="text-3xl font-bold">{{ $stats['users'] }}</p>
    </div>

</div>

@endsection



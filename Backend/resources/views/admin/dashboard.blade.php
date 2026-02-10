@extends('layouts.admin')

@section('content')
<h1 class="text-2xl font-bold mb-8">📊 Tableau de bord</h1>

<!-- CARTES STATISTIQUES -->
<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-5 gap-6 mb-10">

    <div class="bg-white shadow rounded-lg p-6 text-center">
        <p class="text-gray-500 text-sm">Total commandes</p>
        <p class="text-3xl font-bold text-indigo-600">
            {{ $stats['total_orders'] }}
        </p>
    </div>

    <div class="bg-white shadow rounded-lg p-6 text-center">
        <p class="text-gray-500 text-sm">En attente</p>
        <p class="text-3xl font-bold text-yellow-500">
            {{ $stats['pending_orders'] }}
        </p>
    </div>

    <div class="bg-white shadow rounded-lg p-6 text-center">
        <p class="text-gray-500 text-sm">Payées</p>
        <p class="text-3xl font-bold text-green-600">
            {{ $stats['paid_orders'] }}
        </p>
    </div>

    <div class="bg-white shadow rounded-lg p-6 text-center">
        <p class="text-gray-500 text-sm">Produits</p>
        <p class="text-3xl font-bold text-blue-600">
            {{ $stats['products'] }}
        </p>
    </div>

    <div class="bg-white shadow rounded-lg p-6 text-center">
        <p class="text-gray-500 text-sm">Utilisateurs</p>
        <p class="text-3xl font-bold text-purple-600">
            {{ $stats['users'] }}
        </p>
    </div>

</div>

<!-- DERNIERS UTILISATEURS -->
<div class="bg-white shadow rounded-lg p-6">
    <h2 class="text-xl font-semibold mb-4">🧾 Derniers utilisateurs</h2>

    <table class="w-full text-sm border">
        <thead class="bg-gray-100">
            <tr>
                <th class="p-3 text-left">ID</th>
                <th class="p-3 text-left">Nom</th>
                <th class="p-3 text-left">Email</th>
                <th class="p-3 text-left">Date</th>
            </tr>
        </thead>
        <tbody>
            @foreach($users as $user)
                <tr class="border-t hover:bg-gray-50">
                    <td class="p-3">{{ $user->id }}</td>
                    <td class="p-3 font-medium">{{ $user->name }}</td>
                    <td class="p-3">{{ $user->email }}</td>
                    <td class="p-3 text-gray-500">
                        {{ $user->created_at->format('d/m/Y') }}
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>

@endsection

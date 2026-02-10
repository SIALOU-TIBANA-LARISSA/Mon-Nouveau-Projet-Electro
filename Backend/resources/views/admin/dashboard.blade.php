@extends('layouts.admin')

@section('content')

<h1 class="text-2xl font-bold mb-8">📊 Tableau de bord</h1>

<!-- CARTES STATISTIQUES -->
<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-5 gap-6 mb-10">

    <div class="bg-white shadow-md rounded-lg p-6 text-center border-t-4 border-indigo-500">
        <p class="text-gray-500 text-sm uppercase">Total commandes</p>
        <p class="text-4xl font-extrabold text-indigo-600 mt-2">
            {{ $stats['total_orders'] }}
        </p>
    </div>

    <div class="bg-white shadow-md rounded-lg p-6 text-center border-t-4 border-yellow-400">
        <p class="text-gray-500 text-sm uppercase">En attente</p>
        <p class="text-4xl font-extrabold text-yellow-500 mt-2">
            {{ $stats['pending_orders'] }}
        </p>
    </div>

    <div class="bg-white shadow-md rounded-lg p-6 text-center border-t-4 border-green-500">
        <p class="text-gray-500 text-sm uppercase">Payées</p>
        <p class="text-4xl font-extrabold text-green-600 mt-2">
            {{ $stats['paid_orders'] }}
        </p>
    </div>

    <div class="bg-white shadow-md rounded-lg p-6 text-center border-t-4 border-blue-500">
        <p class="text-gray-500 text-sm uppercase">Produits</p>
        <p class="text-4xl font-extrabold text-blue-600 mt-2">
            {{ $stats['products'] }}
        </p>
    </div>

    <div class="bg-white shadow-md rounded-lg p-6 text-center border-t-4 border-purple-500">
        <p class="text-gray-500 text-sm uppercase">Utilisateurs</p>
        <p class="text-4xl font-extrabold text-purple-600 mt-2">
            {{ $stats['users'] }}
        </p>
    </div>

</div>

<!-- TABLEAU -->
<div class="bg-white shadow-md rounded-lg p-6">

    <h2 class="text-xl font-semibold mb-4">🧾 Derniers utilisateurs</h2>

    <div class="overflow-x-auto">
        <table class="min-w-full border border-gray-200 text-sm">
            <thead class="bg-gray-100 text-gray-700">
                <tr>
                    <th class="px-4 py-3 text-left">ID</th>
                    <th class="px-4 py-3 text-left">Nom</th>
                    <th class="px-4 py-3 text-left">Email</th>
                    <th class="px-4 py-3 text-left">Date d’inscription</th>
                </tr>
            </thead>
            <tbody class="divide-y">

                @foreach($users as $user)
                <tr class="hover:bg-gray-50">
                    <td class="px-4 py-3">{{ $user->id }}</td>
                    <td class="px-4 py-3 font-medium">{{ $user->name }}</td>
                    <td class="px-4 py-3">{{ $user->email }}</td>
                    <td class="px-4 py-3 text-gray-500">
                        {{ $user->created_at->format('d/m/Y') }}
                    </td>
                </tr>
                @endforeach

            </tbody>
        </table>
    </div>

</div>

@endsection

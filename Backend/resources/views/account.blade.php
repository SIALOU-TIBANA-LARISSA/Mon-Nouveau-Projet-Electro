@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto px-4 py-8">

    <div class="flex gap-8">

        {{-- MENU GAUCHE --}}
        <aside class="w-64 bg-white border rounded-lg p-4">
            <h2 class="font-bold text-lg mb-4">Votre compte</h2>

            <ul class="space-y-3 text-gray-700">

                <li>
                    <a href="{{ route('orders.index') }}"
                       class="block px-2 py-1 rounded {{ request()->is('my-orders*') ? 'text-orange-600 font-semibold bg-orange-50' : 'hover:text-orange-500' }}">
                        Vos commandes
                    </a>
                </li>

                <li>
                    <a href="{{ route('account.messages') }}" class="block px-2 py-1 hover:text-orange-500">
                        Boîte de réception
                    </a>
                </li>

                <li>
                    <a href="{{ route('account.reviews') }}" class="block px-2 py-1 hover:text-orange-500">
                        Vos avis en attente
                    </a>
                </li>

                <li>
                    <a href="{{ route('account.vouchers') }}" class="block px-2 py-1 hover:text-orange-500">
                        Bons d'achat
                    </a>
                </li>

                <li>
                    <a href="{{ route('account.favorites') }}" class="block px-2 py-1 hover:text-orange-500">
                        Favoris
                    </a>
                </li>

                <li>
                    <a href="{{ route('account.followed-sellers') }}" class="block px-2 py-1 hover:text-orange-500">
                        Vendeurs suivis
                    </a>
                </li>

                <li>
                    <a href="{{ route('account.recent') }}" class="block px-2 py-1 hover:text-orange-500">
                        Vu récemment
                    </a>
                </li>
            </ul>
        </aside>

        {{-- CONTENU DROIT --}}
        <main class="flex-1">

            <h1 class="text-2xl font-bold mb-6">Votre compte</h1>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                <div class="bg-white border rounded-lg p-4">
                    <h3 class="font-semibold mb-2">INFORMATIONS PERSONNELLES</h3>
                    @auth
                     <p class="font-medium">{{ auth()->user()->name }}</p>
                     <p class="text-gray-600">{{ auth()->user()->email }}</p>
                    @else
                    <p class="text-gray-500">Utilisateur non connecté</p>
                    @endauth
   
                </div>

                <div class="bg-white border rounded-lg p-4">
                    <h3 class="font-semibold mb-2 flex justify-between">
                        ADRESSES
                        <a href="{{ route('account.addresses') }}">✏️</a>
                    </h3>
                    <p class="text-gray-600">Adresse par défaut</p>
                </div>

                <div class="bg-white border rounded-lg p-4">
                    <h3 class="font-semibold mb-2">CRÉDIT</h3>
                    <p class="font-bold text-blue-600">0 FCFA</p>
                </div>

                <div class="bg-white border rounded-lg p-4">
                    <h3 class="font-semibold mb-2">PRÉFÉRENCES DE COMMUNICATION</h3>
                    <a href="{{ route('account.preferences') }}" class="text-orange-500">
                        Modifier les préférences
                    </a>
                </div>

            </div>
        </main>

    </div>
</div>
@endsection

@extends('layouts.app')

@section('content')
<div class="max-w-6xl mx-auto bg-white rounded-lg shadow p-6 grid grid-cols-1 md:grid-cols-2 gap-8">

    {{-- Image produit --}}
    <div>
        <img
            src="/{{ $product['main_image_url'] }}"
            alt="{{ $product['name'] }}"
            class="w-full rounded-lg object-cover"
        >
    </div>

    {{-- Infos produit --}}
    <div>
        <h1 class="text-3xl font-bold mb-2">
            {{ $product['name'] }}
        </h1>

        <p class="text-gray-600 mb-4">
            {{ $product['description'] ?? 'Aucune description disponible.' }}
        </p>

        <div class="text-2xl font-bold text-orange-500 mb-4">
            {{ number_format($product['price'], 0, ',', ' ') }} FCFA
        </div>

        {{-- Stock --}}
        <p class="mb-4 text-sm text-gray-600">
            Disponibilité :
            @if(($product['stock_quantity'] ?? 0) > 0)
                <span class="text-green-600 font-semibold">En stock</span>
            @else
                <span class="text-red-600 font-semibold">Rupture de stock</span>
            @endif
        </p>

        {{-- Livraison --}}
        <div class="mb-6">
            <h3 class="font-semibold mb-1">🚚 Livraison</h3>
            <p class="text-sm text-gray-600">
                Livraison disponible partout en Côte d’Ivoire sous 24 à 72h.
            </p>
        </div>

        {{-- Bouton panier --}}
        <button
            class="bg-orange-500 hover:bg-orange-600 text-white px-6 py-3 rounded font-semibold">
            Ajouter au panier
        </button>
    </div>

</div>
@endsection


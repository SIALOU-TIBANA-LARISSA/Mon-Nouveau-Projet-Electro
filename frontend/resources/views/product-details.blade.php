@extends('layouts.app')

@section('title', $product['name'])

@section('content')
<div class="max-w-4xl mx-auto mt-10 bg-white shadow p-6 rounded-lg">

    <img src="{{ $product['main_image_url'] }}" 
         alt="Image produit" 
         class="w-full h-80 object-cover rounded mb-6">

    <h1 class="text-3xl font-bold mb-3">{{ $product['name'] }}</h1>

    <p class="text-gray-600 mb-4">{{ $product['description'] ?? 'Aucune description disponible.' }}</p>

    <div class="text-2xl font-bold text-indigo-600 mb-6">
        {{ number_format($product['price'], 0, ',', ' ') }} FCFA
    </div>

    <!-- Bouton du panier -->
    <button 
        onclick="addToCart({
            id: {{ $product['id'] }},
        name: '{{ $product['name'] }}',
        price: {{ $product['price'] }},
        image: '{{ $product['main_image_url'] ?? '' }}'
    })"
    class="bg-orange-500 text-white px-6 py-3 rounded font-semibold
           hover:bg-orange-600 transition"
>
    Ajouter au panier
    </button>

</div>

<!-- IMPORTANT : charger le fichier cart.js -->
<script src="/js/cart.js"></script>

@endsection

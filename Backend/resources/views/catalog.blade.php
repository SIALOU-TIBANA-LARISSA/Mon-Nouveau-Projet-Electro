@php use Illuminate\Support\Str; @endphp

@extends('layouts.app')

@section('title', 'Catalogue')

@section('content')

<h1 class="text-3xl font-bold mb-6">Catalogue de Produits</h1>

@if (count($products) === 0)
    <p class="text-gray-600">Aucun produit disponible.</p>
@else
    <div class="grid grid-cols-1 md:grid-cols-3 lg:grid-cols-4 gap-6">

        @foreach ($products as $product)
            <div class="bg-white shadow rounded-lg overflow-hidden">
                
                {{-- Image sécurisée (si pas d'image → placeholder) --}}
                <img 
                    src="{{ $product['image'] ?? $product['image_url'] ?? 'https://via.placeholder.com/300x200' }}" 
                    alt="image produit" 
                    class="w-full h-40 object-cover"
                >

                <div class="p-4">
                    <h2 class="text-lg font-semibold">
                        {{ $product['name'] ?? 'Nom indisponible' }}
                    </h2>

                    <p class="text-gray-500 text-sm">
                        {{ Str::limit($product['description'] ?? 'Aucune description', 60) }}
                    </p>

                    <div class="mt-3 font-bold text-indigo-600">
                        {{ number_format($product['price'] ?? 0, 0, ',', ' ') }} FCFA
                    </div>

                    <a href="#" class="mt-4 inline-block bg-indigo-600 text-white px-4 py-2 rounded-lg hover:bg-indigo-700">
                        Voir détails
                    </a>
                </div>
            </div>
        @endforeach

    </div>
@endif

@endsection

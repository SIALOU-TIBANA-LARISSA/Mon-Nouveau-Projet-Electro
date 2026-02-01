@extends('layouts.app')

@section('title', $product['name'])

@section('content')
<div class="max-w-4xl mx-auto mt-10 bg-white shadow p-6 rounded-lg">

    <img
    src="{{ asset(is_array($product) ? $product['main_image_url'] : $product->main_image_url) }}"
    class="w-full max-w-[380px] h-[320px] object-contain rounded mx-auto"
    alt="image produit"
    />


    <h1 class="text-3xl font-bold mb-3">{{ $product['name'] }}</h1>

    <p class="text-gray-600 mb-4">{{ $product['description'] ?? 'Aucune description disponible.' }}</p>

    <div class="text-2xl font-bold text-indigo-600 mb-6">
        {{ number_format($product['price'], 0, ',', ' ') }} FCFA
    </div> 

@php
    $exampleMap = [
        'boite-bijoux-decorative' => [
    '/images/customization-examples/boite-a-bijoux/exemple-1.avif',
    '/images/customization-examples/boite-a-bijoux/exemple-2.avif',
],

        'cadre-photo' => [
            '/images/customization-examples/cadre-photo/exemple-1.avif',
            '/images/customization-examples/cadre-photo/exemple-2.avif'
        ],
        'casquette-personnalisable' => [
            '/images/customization-examples/casquette/exemple-1.avif',
            '/images/customization-examples/casquette/exemple-2.avif',
        ],
        'coque-iphone12-personnalisee' => [
            '/images/customization-examples/coque-iphone-12/exemple-1.avif',
            '/images/customization-examples/coque-iphone-12/exemple-2.avif',
        ],
        'coque-iphone-13-pro' => [
            '/images/customization-examples/coque-iphone-15-pro/exemple-1.avif',
            '/images/customization-examples/coque-iphone-15-pro/exemple-2.avif',
        ],
        'coussin-decoratif' => [
            '/images/customization-examples/coussin/exemple-1.avif',
            '/images/customization-examples/coussin/exemple-2.avif',
        ],
        'mug-blanc-personnalise' => [
            '/images/customization-examples/mug-blanc/exemple-1.avif',
            '/images/customization-examples/mug-blanc/exemple-2.avif',
        ],
        'mug-noir' => [
            '/images/customization-examples/mug-noir/exemple-1.avif',
            '/images/customization-examples/mug-noir/exemple-2.avif',
        ],
        'polo-classique' => [
            '/images/customization-examples/polo/exemple-1.avif',
            '/images/customization-examples/polo/exemple-2.avif',
        ],
        'sticker-vinyle-rectangle' => [
            '/images/customization-examples/sticker-vinyle-rectangle/exemple-1.avif',
            '/images/customization-examples/sticker-vinyle-rectangle/exemple-2.avif',
        ],
        'sticker-vinyle-rond' => [
            '/images/customization-examples/sticker-vinyle-rond/exemple-1.avif',
            '/images/customization-examples/sticker-vinyle-rond/exemple-2.avif',
        ],
        'stylos-publicitaires' => [
            '/images/customization-examples/stylos/exemple-1.avif',
            '/images/customization-examples/stylos/exemple-2.avif',
        ],

        'decoration-noel-personnalisee' => [
    '/images/customization-examples/decoration-noel/exemple-1.avif',
    '/images/customization-examples/decoration-noel/exemple-2.avif'
     ],

    'outils-bureau-contreplaque' => [
    '/images/customization-examples/outils-bureau/exemple-1.avif',
    '/images/customization-examples/outils-bureau/exemple-2.avif'
    ],

    'puzzle-personnalise' => [
    '/images/customization-examples/puzzle/exemple-1.avif',
    '/images/customization-examples/puzzle/exemple-2.avif'
    ],

   'sapin-noel-decoratif' => [
    '/images/customization-examples/sapin-noel/exemple-1.avif',
    '/images/customization-examples/sapin-noel/exemple-2.avif'
    ],

    'trophee-plexiglass' => [
    '/images/customization-examples/trophee/exemple-1.avif',
    '/images/customization-examples/trophee/exemple-2.avif'
     ],

    'vase-decoratif-filament' => [
    '/images/customization-examples/vase/exemple-1.avif',
    '/images/customization-examples/vase/exemple-2.avif'
     ],
     
    // 🔹 Boucles d’oreilles africaines
    'boucles-oreilles-africaines' => [
        '/images/customization-examples/boucles-oreilles/exemple-1.avif',
        '/images/customization-examples/boucles-oreilles/exemple-2.avif',
    ],

    // 🔹 Support ordinateur
    'support-ordinateur' => [
        '/images/customization-examples/support-ordinateur/exemple-1.avif',
        '/images/customization-examples/support-ordinateur/exemple-2.avif',
    ],

    // 🔹 Présentoir bijoux
    'presentoir-bijoux' => [
        '/images/customization-examples/presentoir-bijoux/exemple-1.avif',
        '/images/customization-examples/presentoir-bijoux/exemple-2.avif',
    ],


];

    $slug = $product['slug'] ?? null;
@endphp


@if(isset($exampleMap[$slug]))
    <hr class="my-8">

    <h2 class="text-xl font-semibold mb-4">
        🎨 Exemples de personnalisation
    </h2>

    <div class="grid grid-cols-2 md:grid-cols-3 gap-4">
        @foreach($exampleMap[$slug] as $img)
            <img src="{{ $img }}" class="rounded shadow" alt="Exemple de personnalisation">
        @endforeach
    </div>

    <p class="text-sm text-gray-500 mt-3">
        Ces visuels sont des exemples de personnalisations possibles.
    </p>
@endif




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

    <hr class="my-8">

<div class="grid grid-cols-1 md:grid-cols-2 gap-8">

    <!-- Détails du produit -->
    <div>
        <h2 class="text-xl font-semibold mb-4">🧾 Détails du produit</h2>

        <ul class="space-y-2 text-gray-700">
            <li><strong>Catégorie :</strong> {{ $product['category']['name'] ?? 'Non précisée' }}</li>
            <li><strong>Compatibilité :</strong> {{ $product['compatibility'] ?? 'Universelle' }}</li>
            <li><strong>Matière :</strong> {{ $product['material'] ?? 'Non précisée' }}</li>
            <li><strong>Disponibilité :</strong> En stock</li>
        </ul>
    </div>

    <!-- Livraison -->
    <div>
        <h2 class="text-xl font-semibold mb-4">🚚 Livraison</h2>

        <ul class="text-gray-700 space-y-2">
            <li>📦 Livraison à Abidjan : <strong>24 à 48h</strong></li>
            <li>🚚 Hors Abidjan : <strong>2 à 5 jours</strong></li>
            <li>💳 Paiement à la livraison disponible</li>
        </ul>
    </div>

</div>



@endsection

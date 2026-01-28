@extends('layouts.app')

@section('title', 'Catalogue')

@section('content')

<div class="max-w-7xl mx-auto px-4">
    <div class="flex gap-6">

<!-- ================= MENU À GAUCHE ================= -->
        <aside class="w-64 bg-white shadow rounded-lg sticky top-24
              max-h-[80vh] overflow-y-auto">


            <div class="bg-orange-500 text-white px-4 py-3 rounded-t-lg font-bold">
                Nos Catégories
            </div>

            <div class="p-3 space-y-3">

                <!-- Groupe 1 -->
                <details class="group">
                    <summary class="cursor-pointer font-semibold flex justify-between items-center">
                        📱 Téléphones & accessoires
                        <span class="group-open:rotate-180">▼</span>
                    </summary>
                    <ul class="ml-4 mt-2 space-y-1 text-gray-700">
                        <li>Coques</li>
                        <li>Stickers</li>
                    </ul>
                </details>

                <!-- Groupe 2 -->
                <details class="group">
                    <summary class="cursor-pointer font-semibold flex justify-between items-center">
                        🎁 Cadeaux personnalisés
                        <span class="group-open:rotate-180">▼</span>
                    </summary>
                    <ul class="ml-4 mt-2 space-y-1 text-gray-700">
                        <li>Mugs</li>
                        <li>Boîtes à bijoux</li>
                        <li>Puzzle personnalisé</li>
                        <li>Sticker Vinyle Rectangle</li>
                    </ul>
                </details>

                <!-- Groupe 3 -->
                <details class="group">
                    <summary class="cursor-pointer font-semibold flex justify-between items-center">
                        🏠 Maison & déco
                        <span class="group-open:rotate-180">▼</span>
                    </summary>
                    <ul class="ml-4 mt-2 space-y-1 text-gray-700">
                        <li>Cadres photo</li>
                        <li>Sapin de Noël décoratif personnalisé</li>
                        <li>Vase décoratif </li>
                        <li>Décoration de Noël personnalisée</li>
                    </ul>
                </details>

                <!-- Groupe 4 -->
                <details class="group">
                    <summary class="cursor-pointer font-semibold flex justify-between items-center">
                        ✍️ Bureau & papeterie
                        <span class="group-open:rotate-180">▼</span>
                    </summary>
                    <ul class="ml-4 mt-2 space-y-1 text-gray-700">
                        <li>Tapis de souris</li>
                        <li>Outils de bureau personnalisés en contreplaqué</li>
                        <li>Trophée personnalisé en plexiglass</li>
                    </ul>
                </details>

                <div class="text-gray-400 pt-2 border-t text-sm">
                    + Autres catégories
                </div>

            </div>
        </aside>

    <!-- PRODUITS À DROITE -->
    <section class="flex-1">


        <!-- 🔍 BARRE DE RECHERCHE AJAX -->
<div class="mb-6">
    <input
        type="text"
        id="search-input"
        placeholder="Rechercher un produit..."
        class="w-full border border-gray-300 rounded px-4 py-2
               focus:outline-none focus:ring-2 focus:ring-orange-500"
    >
</div>


        @if ($products->isEmpty())


            <p class="text-gray-600">Aucun produit disponible.</p>
        @else
            <div id="products-container"
     class="grid grid-cols-1 md:grid-cols-3 lg:grid-cols-4 gap-6">


                @foreach ($products as $product)
                    <div class="bg-white shadow rounded-lg overflow-hidden">

                        <img
                          src="/{{ $product->main_image_url }}"
                          class="w-full h-40 object-cover"
                          alt="image produit"
                        />


                        <div class="p-4">
                            <h2 class="font-semibold text-sm">
                                {{ $product['name'] }}
                            </h2>

                            <div class="mt-2 font-bold text-orange-500">
                                {{ number_format($product['price'], 0, ',', ' ') }} FCFA
                            </div>

                            <a href="{{ route('product.details', $product['id']) }}"
                               class="mt-3 block text-center bg-orange-500 text-white py-2 rounded hover:bg-orange-600">
                                Voir détails
                            </a>

                            <button
    onclick="addToCart({
        id: {{ $product['id'] }},
        name: '{{ $product['name'] }}',
        price: {{ $product['price'] }},
        image: '{{ asset($product['main_image_url']) }}'
    })"
    class="mt-2 w-full bg-gray-200 py-2 rounded hover:bg-gray-300"
>
    Ajouter au panier
</button>


                        </div>
                    </div>
                @endforeach

            </div>
        @endif

    </section>

</div>

@if(isset($pagination))
    <div class="flex justify-center gap-2 mt-8">
        @if($pagination['current_page'] > 1)
            <a href="{{ url('/catalogue?page=' . ($pagination['current_page'] - 1)) }}"
               class="px-4 py-2 bg-gray-200 rounded">
                ← Précédent
            </a>
        @endif

        @if($pagination['current_page'] < $pagination['last_page'])
            <a href="{{ url('/catalogue?page=' . ($pagination['current_page'] + 1)) }}"
               class="px-4 py-2 bg-orange-500 text-white rounded">
                Suivant →
            </a>
        @endif
    </div>
@endif


@endsection

@extends('layouts.app')

@section('title', 'Catalogue')

@section('content')

<div class="max-w-7xl mx-auto px-4 flex gap-6">

    <!-- COLONNE GAUCHE : CATÉGORIES -->
    <aside class="w-64 bg-white shadow rounded-lg">

        <!-- Titre -->
        <div class="bg-orange-500 text-white px-4 py-3 flex justify-between items-center rounded-t-lg">
            <span class="font-bold">Nos Catégories</span>
            <a href="#" class="text-sm underline">Voir</a>
        </div>

        <!-- Liste -->
        <ul class="space-y-2 text-sm">

    <li>
        <a href="/catalogue?q=coque"
           class="block hover:text-orange-600">
            📱 Coque iPhone 12 personnalisée
        </a>
    </li>

    <li>
        <a href="/catalogue?q=mug"
           class="block hover:text-orange-600">
            ☕ Mug blanc personnalisé
        </a>
    </li>

    <li>
        <a href="/catalogue?q=sticker"
           class="block hover:text-orange-600">
            🏷️ Sticker vinyle rectangle
        </a>
    </li>

    <li>
        <a href="/catalogue?q=tshirt-blanc"
           class="block hover:text-orange-600">
            👕 T-shirt blanc
        </a>
    </li>

    <li>
        <a href="/catalogue?q=tshirt-noir"
           class="block hover:text-orange-600">
            👕 T-shirt noir
        </a>
    </li>

    <li>
        <a href="/catalogue?q=tshirt-vert"
           class="block hover:text-orange-600">
            👕 T-shirt vert
        </a>
    </li>


            <li class="px-4 py-3 hover:bg-orange-50 cursor-pointer">
                ➕ Autres catégories
            </li>

        </ul>
    </aside>

    <!-- COLONNE DROITE : PRODUITS -->
    <section class="flex-1">

        @if (count($products) === 0)
            <p class="text-gray-600">Aucun produit disponible.</p>
        @else
            <div id="products-container" class="grid grid-cols-1 md:grid-cols-3 lg:grid-cols-4 gap-6">


                @foreach ($products as $product)
                    <div class="bg-white shadow rounded-lg overflow-hidden">

                        <img
                            src="{{ $product['image'] ?? 'https://via.placeholder.com/300x200' }}"
                            class="w-full h-40 object-cover"
                        >

                        <div class="p-4">
                            <h2 class="font-semibold">
                                {{ $product['name'] }}
                            </h2>

                            <div class="mt-2 font-bold text-orange-500">
                                {{ number_format($product['price'], 0, ',', ' ') }} FCFA
                            </div>

                            <a href="{{ route('product.details', $product['id']) }}"
                               class="mt-3 block text-center bg-orange-500 text-white py-2 rounded hover:bg-orange-600">
                                Voir détails
                            </a>
                        </div>
                    </div>
                @endforeach

            </div>
        @endif

    </section>

</div>

<script>
document.addEventListener("DOMContentLoaded", function () {
    const input = document.getElementById("search-input");
    const container = document.getElementById("products-container");

    if (!input) return;

    let timeout = null;

    input.addEventListener("keyup", function () {
        clearTimeout(timeout);

        timeout = setTimeout(() => {
            const query = input.value;

            fetch(`/catalogue?q=${encodeURIComponent(query)}`)
                .then(res => res.text())
                .then(html => {
                    const parser = new DOMParser();
                    const doc = parser.parseFromString(html, "text/html");
                    const newProducts = doc.querySelector("#products-container");

                    if (newProducts) {
                        container.innerHTML = newProducts.innerHTML;
                    }
                });
        }, 300); // délai pour éviter trop de requêtes
    });
});
</script>


@endsection



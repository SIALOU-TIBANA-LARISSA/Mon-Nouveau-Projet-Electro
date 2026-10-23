@extends('layouts.app')

@section('title', 'Catalogue')

@section('content')

@php
use Illuminate\Support\Str;

$imageMap = [
    'Boîte à bijoux' => '/images/products/boite-à-bijoux.avif',
    'Cadre photo' => '/images/products/cadre-photo.avif',
    'Coque iPhone 13 Pro' => '/images/products/Coque-iphone-13-pro.avif',
    'Décoration de Noël personnalisée' => '/images/products/deco-noel.avif',
    'Mug Blanc Personnalisé' => '/images/products/mug-blanc.avif',
    'Mug Noir Personnalisé' => '/images/products/mug-noir.avif',
    'Outils de bureau personnalisés' => '/images/products/outils-bureau.avif',
    'Puzzle personnalisé' => '/images/products/puzzle.avif',
    'Sapin de Noël décoratif personnalisé' => '/images/products/sapin-noel.avif',
    'Sticker Vinyle Rectangle' => '/images/products/sticker-vinyle-rectangle.avif',
    'Sticker Vinyle Rond' => '/images/products/sticker-vinyle-rond.avif',
    'Trophée personnalisé en plexiglass' => '/images/products/trophee.avif',
    'Vase décoratif' => '/images/products/vase.avif',
];
@endphp



<div class="max-w-7xl mx-auto px-2 sm:px-4">
    <div class="flex flex-col lg:flex-row gap-6">



<!-- ================= MENU À GAUCHE ================= -->

<!-- Bouton catégories mobile -->
<button id="categoriesBtn"
    class="lg:hidden bg-orange-500 text-white px-4 py-2 rounded mb-4">
    📂 Catégories
</button>

<aside id="categoriesMenu"
    class="fixed
           left-0
           top-[var(--header-height)]
           w-72
           h-[calc(100vh-80px)]
           bg-white
           shadow-xl
           z-50
           flex flex-col

           transform -translate-x-full
           transition-transform duration-300

           lg:translate-x-0">


            <div class="bg-orange-500 text-white px-4 py-3 rounded-t-lg font-bold">
                Nos Catégories
            </div>

            <div class="flex-1 overflow-y-auto p-3 space-y-3">

               <!-- Groupe 1 -->
    <details class="group">
    <summary class="cursor-pointer font-semibold flex justify-between items-center">
        <a href="/catalogue?category=telephones-accessoires"
           class="hover:text-orange-500">
            📱 Téléphones & accessoires
        </a>
        <span class="group-open:rotate-180">▼</span>
    </summary>

    <ul class="ml-4 mt-2 space-y-1 text-gray-700">
        <li>
            <a href="/catalogue?category=coques-telephone"
               class="hover:text-orange-500">
                Coques
            </a>
        </li>
        <li>
            <a href="/catalogue?category=stickers"
               class="hover:text-orange-500">
                Stickers
            </a>
        </li>
    </ul>
</details>


                <!-- Groupe 2 -->
                <details class="group">
                    <summary class="cursor-pointer font-semibold flex justify-between items-center">
                     <a href="/catalogue?category=cadeaux-personnalises"
                      class="hover:text-orange-500">
                       🎁 Cadeaux personnalisés
                     </a>
                     <span class="group-open:rotate-180">▼</span>
                    </summary>

                    <ul class="ml-4 mt-2 space-y-1 text-gray-700">
    <li>
        <a href="/catalogue?category=cadeaux-personnalises"
           class="hover:text-orange-500">
           Mugs
        </a>
    </li>
    <li>
        <a href="/catalogue?category=cadeaux-personnalises"
           class="hover:text-orange-500">
           Boîtes à bijoux
        </a>
    </li>
    <li>
        <a href="/catalogue?category=cadeaux-personnalises"
           class="hover:text-orange-500">
           Puzzle personnalisé
        </a>
    </li>
<li>
    <a href="/catalogue?category=cadeaux-personnalises"
       class="hover:text-orange-500">
       Trophée personnalisé
    </a>
</li>
<li>
    <a href="/catalogue?category=cadeaux-personnalises"
       class="hover:text-orange-500">
       Boucles d’oreilles africaines
    </a>
</li>
    <li>
    <a href="/catalogue?category=cadeaux-personnalises"
       class="hover:text-orange-500">
       Porte-clés personnalisé en bois
    </a>
</li>
<li>
    <a href="/catalogue?category=cadeaux-personnalises"
       class="hover:text-orange-500">
       Lampe LED personnalisée
    </a>
</li>

<li>
    <a href="/catalogue?category=cadeaux-personnalises"
       class="hover:text-orange-500">
       Couronne
    </a>
</li>
  
</ul>
 </details>

                <!-- Groupe 3 -->
                <details class="group">
    <summary class="cursor-pointer font-semibold flex justify-between items-center">
        <a href="/catalogue?category=maison-deco"
           class="hover:text-orange-500">
            🏠 Maison & déco
        </a>
        <span class="group-open:rotate-180">▼</span>
    </summary>

    <ul class="ml-4 mt-2 space-y-1 text-gray-700">
        <li>
            <a href="/catalogue?category=maison-deco"
               class="hover:text-orange-500">
                Cadres photo
            </a>
        </li>
        <li>
            <a href="/catalogue?category=maison-deco"
               class="hover:text-orange-500">
                Sapin de Noël décoratif personnalisé
            </a>
        </li>
        <li>
            <a href="/catalogue?category=maison-deco"
               class="hover:text-orange-500">
                Vase décoratif
            </a>
        </li>
        <li>
            <a href="/catalogue?category=maison-deco"
               class="hover:text-orange-500">
                Décoration de Noël personnalisée
            </a>
        </li>
       <li>
            <a href="/catalogue?category=maison-deco"
               class="hover:text-orange-500">
                Support téléphone en bois personnalisé
            </a>
        </li>
        <li>
            <a href="/catalogue?category=maison-deco"
               class="hover:text-orange-500">
                Plaque murale personnalisée en bois
            </a>
        </li>
        <li>
            <a href="/catalogue?category=maison-deco"
               class="hover:text-orange-500">
                Bustes personnalisés imprimés en 3D
            </a>
        </li>
    </ul>
</details>


                <!-- Groupe 4 -->
                <details class="group">
    <summary class="cursor-pointer font-semibold flex justify-between items-center">
        <a href="/catalogue?category=bureau-papeterie"
           class="hover:text-orange-500">
            ✍️ Bureau & papeterie
        </a>
        <span class="group-open:rotate-180">▼</span>
    </summary>

    <ul class="ml-4 mt-2 space-y-1 text-gray-700">
        <li>
            <a href="/catalogue?category=bureau-papeterie"
               class="hover:text-orange-500">
                Tapis de souris
            </a>
        </li>
        <li>
            <a href="/catalogue?category=bureau-papeterie"
               class="hover:text-orange-500">
                Outils de bureau personnalisés en contreplaqué
            </a>
        </li>
    </ul>
</details>

                <a href="/catalogue"
                 class="block text-gray-400 pt-2 border-t text-sm hover:text-orange-500">
                  + Autres catégories
                </a>
            </div>
        </aside>

        <div id="menuOverlay"
     class="fixed inset-0 bg-black/40 hidden z-30 lg:hidden">
</div>

    <!-- PRODUITS À DROITE -->
    <section class="flex-1 w-full lg:ml-72">

    
<!-- 🔍 BARRE DE RECHERCHE AJAX -->
<div class="mb-6 flex gap-2 relative">

    <span class="absolute left-4 top-1/2 -translate-y-1/2 text-gray-400">
        🔍
    </span>

    <input
        type="text"
        id="search-input"
        placeholder="Rechercher un produit..."
        class="flex-1 border border-gray-300 rounded-full pl-12 pr-4 py-2
               focus:outline-none focus:ring-2 focus:ring-orange-500"
    >

</div>
        
        @if ($products->isEmpty())


            <p class="text-gray-600">Aucun produit disponible.</p>
        @else
            <div id="products-container" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 w-full">


                @foreach ($products as $product)

    <div class="relative bg-white shadow rounded-lg overflow-hidden flex flex-col">

    <form action="{{ route('product.favorite', $product->id) }}" method="POST"
class="absolute top-2 right-2 z-20">
@csrf

<button class="favorite-btn text-2xl bg-white rounded-full w-9 h-9 flex items-center justify-center shadow hover:scale-110 transition">

@if(auth()->check() && auth()->user()->favorites->contains('product_id', $product->id))
❤️
@else
🤍
@endif

</button>

</form>

     @if($product->svg_path || $product->stl_path || $product->dxf_path)
    <span class="absolute top-2 left-2 bg-orange-500 text-white text-xs px-2 py-1 rounded">
        ✨ Personnalisable
    </span>
    @endif
    
    @if($product->promo_price && $product->promo_price < $product->price)

@php
$reduction = round((($product->price - $product->promo_price) / $product->price) * 100);
@endphp

<span class="absolute top-10 left-2 bg-red-500 text-white text-xs px-2 py-1 rounded z-10">
🔥 -{{ $reduction }}%
</span>

@endif

    @if($product->created_at->diffInDays(now()) < 7)
<span class="absolute top-12 right-2 bg-green-500 text-white text-xs px-2 py-1 rounded z-10">
    🆕
</span>
@endif
        
    <!-- IMAGE -->
<div class="w-full h-40 md:h-48 flex items-center justify-center bg-gray-50">
    <a href="{{ route('product.details', $product['id']) }}">
        <img
            src="{{ $product->main_image_url
            ? asset(ltrim($product->main_image_url, '/'))
            : asset('images/products/default.avif') }}"
            class="w-44 h-44 object-cover rounded-full border border-gray-200 shadow hover:scale-105 transition duration-300 cursor-pointer""
            alt="{{ $product->name }}"
        >
    </a>
</div>

        <!-- CONTENU -->
        <div class="p-4">
            <h2 class="font-semibold text-sm">
                {{ $product['name'] }}
            </h2>

            <div class="flex items-center text-sm mt-1">
    <span class="text-yellow-400">
        @for ($i = 1; $i <= 5; $i++)
            @if ($i <= ($product->rating ?? 4))
                ★
            @else
                ☆
            @endif
        @endfor
    </span>

    <span class="text-gray-500 text-xs ml-2">
        ({{ $product->reviews_count ?? 12 }} avis)
    </span>
</div>

            @if($product->promo_price && $product->promo_price < $product->price)

<div class="mt-2">
    <span class="text-gray-400 line-through text-sm">
        {{ number_format($product->price, 0, ',', ' ') }} FCFA
    </span>

    <div class="text-red-600 font-bold">
        {{ number_format($product->promo_price, 0, ',', ' ') }} FCFA
    </div>
</div>

@else

<div class="mt-2 font-bold text-orange-500">
    {{ number_format($product->price, 0, ',', ' ') }} FCFA
</div>

@endif

<div class="text-xs mt-1">
<span class="text-green-600">✔ Disponible sur commande</span>
</div>


            <a href="{{ route('product.details', $product['id']) }}"
               class="mt-3 block text-center bg-orange-500 text-white py-2 rounded-full hover:bg-orange-600">
                Voir détails
            </a>

            <button
    class="add-to-cart mt-2 w-full bg-gray-200 py-2 rounded-full hover:bg-gray-300"
    data-id="{{ $product->id }}">
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

<script>
document.addEventListener("DOMContentLoaded", function() {

    const btn = document.getElementById("categoriesBtn");
    const menu = document.getElementById("categoriesMenu");
    const overlay = document.getElementById("menuOverlay");

    if (!btn || !menu || !overlay) return;

    btn.addEventListener("click", function() {
        menu.classList.remove("-translate-x-full");
        overlay.classList.remove("hidden");
    });

    overlay.addEventListener("click", function() {
        menu.classList.add("-translate-x-full");
        overlay.classList.add("hidden");
    });

});
</script>

@endsection

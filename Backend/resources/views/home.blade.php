@extends('layouts.app')

@section('title', 'Accueil')

@section('content')

<!-- ================= HERO ================= -->
<section class="bg-orange-50 py-20 text-center relative overflow-hidden">

<!-- IMAGES FLOTTANTES (ARRIÈRE-PLAN) -->
<div class="floating-images">

    <img src="{{ asset('images/products/deco-noel.png') }}" class="float float-1">
    <img src="{{ asset('images/products/vase.png') }}" class="float float-2">
    <img src="{{ asset('images/products/presentoir-bijoux.png') }}" class="float float-3">
    <img src="{{ asset('images/products/mug-blanc.png') }}" class="float float-4">
    <img src="{{ asset('images/products/sticker-vinyle-rond.png') }}" class="float float-5">
     <img src="{{ asset('images/products/coque-iphone-15-pro.png') }}" class="float float-6">
</div>



    <h1 id="hero-title" class="text-4xl md:text-5xl font-bold mb-4 relative z-10">
        Modélisation & impression sur mesure
    </h1>

    <p id="hero-text" class="text-lg text-gray-600 mb-8 max-w-2xl mx-auto relative z-10">
        Produits modélisés et imprimés sur mesure : vases , coques, goodies et bien plus, pour particuliers et entreprises.
    </p>

    <a href="/catalogue"
   class="inline-block bg-orange-500 text-white font-semibold px-5 py-2 rounded-full shadow
          transition transform duration-300
          hover:bg-orange-600 hover:scale-105
          active:scale-95 cursor-pointer relative z-10">
    Voir le catalogue
</a>


<!-- SECTION SLIDER PROMOTION -->
<div class="mt-12">
    <div class="max-w-4xl mx-auto">

        <div id="promoCarousel"
             class="carousel slide"
             data-bs-ride="carousel"
             data-bs-interval="4000">

        <div class="carousel-inner">
            <div class="carousel-item active">
                <img src="{{ asset('images/slider/slide1.avif') }}" class="slider-img" alt="Boite à bijoux">
            </div>

            <div class="carousel-item">
                <img src="{{ asset('images/slider/slide2.avif') }}" class="slider-img" alt="Décoration Noël">
            </div>

            <div class="carousel-item">
                <img src="{{ asset('images/slider/slide3.avif') }}" class="slider-img" alt="Trophée personnalisé">
            </div>

            <div class="carousel-item">
                <img src="{{ asset('images/slider/slide4.avif') }}" class="slider-img" alt="Vase décoratif">
            </div>

            <div class="carousel-item">
                <img src="{{ asset('images/slider/slide5.avif') }}" class="slider-img" alt="Puzzle personnalisé">
            </div>

            <div class="carousel-item">
                <img src="{{ asset('images/slider/slide6.avif') }}" class="slider-img" alt="Vase décoratif">
            </div>

        </div>

        <!-- Flèches -->
        <button class="carousel-control-prev" type="button" data-bs-target="#promoCarousel" data-bs-slide="prev">
            <span class="carousel-control-prev-icon"></span>
        </button>

        <button class="carousel-control-next" type="button" data-bs-target="#promoCarousel" data-bs-slide="next">
            <span class="carousel-control-next-icon"></span>
        </button>

    </div>
</div>
</section>

<!-- FIN SLIDER -->


<!-- ================= PRODUITS VEDETTES ================= -->
<section class="px-6 py-16">

    <h2 class="text-2xl font-bold text-center mb-12">
        Nos produits en vedette
    </h2>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-8 max-w-7xl mx-auto px-4">

        <!-- ===== LIGNE 1 : PRODUITS ===== -->

 <a href="{{ route('produit.slug', 'mug-blanc-personnalise') }}" 
   class="block">

    <div class="bg-white rounded-xl shadow-md p-4 text-center
        transition-all duration-500
        hover:shadow-2xl hover:-translate-y-2 hover:bg-orange-50">

        <div class="overflow-hidden rounded-lg mb-4">
            <img src="{{ asset('images/featured/mug-personnalise.avif') }}"
                 class="h-48 mx-auto transition-transform duration-500 hover:scale-110">
        </div>

        <h3 class="font-semibold hover:text-orange-500 transition-colors duration-300">
            Mug personnalisé
        </h3>

        <p class="text-orange-500 font-bold mb-3">
            3 500 FCFA
        </p>

        <!-- Bouton visible mais discret -->
        <span class="inline-block bg-orange-500 text-white px-4 py-2 rounded-full text-sm
                     opacity-90 hover:opacity-100 transition">
            Voir le produit
        </span>

    </div>

</a>

<a href="{{ route('produit.slug', 'coque-iphone-15-pro') }}" 
   class="block">

    <div class="bg-white rounded-xl shadow-md p-4 text-center
        transition-all duration-500
        hover:shadow-2xl hover:-translate-y-2 hover:bg-orange-50">

        <div class="overflow-hidden rounded-lg mb-4">
            <img src="{{ asset('images/featured/coque.avif') }}"
                 class="h-48 mx-auto transition-transform duration-500 hover:scale-110">
        </div>

        <h3 class="font-semibold hover:text-orange-500 transition-colors duration-300">
            Coque iPhone
        </h3>

        <p class="text-orange-500 font-bold mb-3">
            6 000 FCFA
        </p>

        <span class="inline-block bg-orange-500 text-white px-4 py-2 rounded-full text-sm
                     opacity-90 hover:opacity-100 transition">
            Voir le produit
        </span>

    </div>

</a>

<a href="{{ route('produit.slug', 'cadre-photo') }}" 
   class="block">

    <div class="bg-white rounded-xl shadow-md p-4 text-center
        transition-all duration-500
        hover:shadow-2xl hover:-translate-y-2 hover:bg-orange-50">

        <div class="overflow-hidden rounded-lg mb-4">
            <img src="{{ asset('images/featured/cadre.avif') }}"
                 class="h-48 mx-auto transition-transform duration-500 hover:scale-110">
        </div>

        <h3 class="font-semibold hover:text-orange-500 transition-colors duration-300">
            Cadre-photo
        </h3>

        <p class="text-orange-500 font-bold mb-3">
            4 000 FCFA
        </p>

        <span class="inline-block bg-orange-500 text-white px-4 py-2 rounded-full text-sm
                     opacity-90 hover:opacity-100 transition">
            Voir le produit
        </span>

    </div>

</a>

        <!-- ===== LIGNE 2 : CARTES ===== -->

        <div class="bg-white rounded-xl shadow p-8 text-center mt-10
            transition transform duration-300
            hover:-translate-y-2 hover:shadow-xl
            active:scale-95 cursor-pointer">

            <div class="text-3xl mb-4">⚡</div>
            <h3 class="font-bold text-lg mb-2">Rapide & efficace</h3>
            <p class="text-gray-600">
                Production rapide avec un suivi clair de vos commandes.
            </p>
        </div>

        <div class="bg-white rounded-xl shadow p-8 text-center mt-10
            transition transform duration-300
            hover:-translate-y-2 hover:shadow-xl
            active:scale-95 cursor-pointer">

            <div class="text-3xl mb-4">🎨</div>
            <h3 class="font-bold text-lg mb-2">Personnalisation totale</h3>
            <p class="text-gray-600">
                Ajoutez textes, logos ou visuels selon vos besoins.
            </p>
        </div>

        <div class="bg-white rounded-xl shadow p-8 text-center mt-10
            transition transform duration-300
            hover:-translate-y-2 hover:shadow-xl
            active:scale-95 cursor-pointer">

            <div class="text-3xl mb-4">🚚</div>
            <h3 class="font-bold text-lg mb-2">Livraison fiable</h3>
            <p class="text-gray-600">
                Livraison sécurisée partout, pour particuliers et entreprises.
            </p>
        </div>

    </div>

</section>

<style>
/* === IMAGES FLOTTANTES (FORCÉ) === */

.floating-images {
    position: absolute;
    inset: 0;
    z-index: 0;
    pointer-events: none;
}

.float {
    position: absolute;
    width: 110px !important;     /* taille visible */
    height: auto !important;
    opacity: 1 !important;       /* couleur normale */
    filter: drop-shadow(0 15px 25px rgba(0,0,0,0.25));
    animation: floatSlow 8s ease-in-out infinite;
}


.float-1 { top: 8%; left: 5%; }
.float-2 { bottom: 12%; left: 8%; }
.float-3 { top: 15%; right: 8%; }
.float-4 { bottom: 10%; right: 15%; }
.float-5 { top: 50%; right: 38%; width: 120px !important; }
.float-6 { top: 5%; left: 40%; width: 130px !important; }



@keyframes floatSlow {
    0% {
        transform: translateY(0) rotate(0deg);
    }
    25% {
        transform: translateY(-12px) rotate(-2deg);
    }
    50% {
        transform: translateY(-24px) rotate(2deg);
    }
    75% {
        transform: translateY(-12px) rotate(-1deg);
    }
    100% {
        transform: translateY(0) rotate(0deg);
    }
}


@media (max-width: 640px) {
    .floating-images { display: none; }
}
</style>

<style>
.carousel-inner {
    height: 380px;
    overflow: hidden;
    background: transparent;
}

.carousel-item {
    height: 380px;
}

.slider-img {
    height: 100%;
    width: 100%;
    object-fit: contain;
    background: transparent;
}

@media (max-width: 768px) {
    .carousel-inner,
    .carousel-item {
        height: 220px;
    }
}
</style>



@endsection

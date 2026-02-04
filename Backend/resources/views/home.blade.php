@extends('layouts.app')

@section('title', 'Accueil')

@section('content')

<!-- ================= HERO ================= -->
<section class="bg-orange-50 py-20 text-center relative overflow-hidden">

<!-- IMAGES FLOTTANTES (ARRIÈRE-PLAN) -->
<div class="floating-images">

    <img src="{{ asset('images/products/deco-noel.avif') }}" class="float float-1">
    <img src="{{ asset('images/products/vase.avif') }}" class="float float-2">
    <img src="{{ asset('images/products/boite-a-bijoux.avif') }}" class="float float-3">
    <img src="{{ asset('images/products/mug-blanc.avif') }}" class="float float-4">
    <img src="{{ asset('images/products/sticker-vinyle-rond.avif') }}" class="float float-5">
     <img src="{{ asset('images/products/coque-iphone-15-pro.avif') }}" class="float float-6">

</div>



    <h1 id="hero-title" class="text-4xl md:text-5xl font-bold mb-4 relative z-10">
        Modélisation & impression sur mesure
    </h1>

    <p id="hero-text" class="text-lg text-gray-600 mb-8 max-w-2xl mx-auto relative z-10">
        Produits modélisés et imprimés sur mesure : vases , coques, goodies et bien plus, pour particuliers et entreprises.
    </p>

    <a href="/catalogue"
   class="inline-block bg-orange-500 text-white font-semibold px-8 py-4 rounded-lg shadow
          transition transform duration-300
          hover:bg-orange-600 hover:scale-105
          active:scale-95 cursor-pointer relative z-10">
    Voir le catalogue
</a>


</section>

<!-- ================= PRODUITS VEDETTES ================= -->
<section class="py-16 bg-white">

    <h2 class="text-2xl font-bold text-center mb-10">
        Nos produits en vedette
    </h2>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 max-w-5xl mx-auto px-4">

        <div class="bg-white rounded-lg shadow p-4 text-center
            transition transform duration-300
            hover:-translate-y-2 hover:shadow-xl
            active:scale-95 cursor-pointer">

            <img src="{{ asset('images/featured/mug-personnalise.avif') }}" class="h-48 mx-auto mb-4">
            <h3 class="font-semibold">Mug personnalisé</h3>
            <p class="text-orange-500 font-bold">3 500 FCFA</p>
        </div>

        <div class="bg-white rounded-lg shadow p-4 text-center
            transition transform duration-300
            hover:-translate-y-2 hover:shadow-xl
            active:scale-95 cursor-pointer">

            <img src="{{ asset('images/featured/coque.avif') }}" class="h-48 mx-auto mb-4">
            <h3 class="font-semibold">Coque iPhone</h3>
            <p class="text-orange-500 font-bold">6 000 FCFA</p>
        </div>

        <div class="bg-white rounded-lg shadow p-4 text-center
            transition transform duration-300
            hover:-translate-y-2 hover:shadow-xl
            active:scale-95 cursor-pointer">

            <img src="{{ asset('images/featured/cadre.avif') }}" class="h-48 mx-auto mb-4">
            <h3 class="font-semibold">Cadre-photo</h3>
            <p class="text-orange-500 font-bold">4 000 FCFA</p>
        </div>

    </div>

</section>

<!-- ================= CARTES AVANTAGES ================= -->
<section class="bg-gray-100 py-16">

    <div class="grid grid-cols-1 md:grid-cols-3 gap-8 max-w-7xl mx-auto px-4">

        <div class="bg-white rounded-xl shadow p-8 text-center
            transition transform duration-300
            hover:-translate-y-2 hover:shadow-xl
            active:scale-95 cursor-pointer">

            <div class="text-3xl mb-4">⚡</div>
            <h3 class="font-bold text-lg mb-2">Rapide & efficace</h3>
            <p class="text-gray-600">
                Production rapide avec un suivi clair de vos commandes.
            </p>
        </div>

        <div class="bg-white rounded-xl shadow p-8 text-center
            transition transform duration-300
            hover:-translate-y-2 hover:shadow-xl
            active:scale-95 cursor-pointer">

            <div class="text-3xl mb-4">🎨</div>
            <h3 class="font-bold text-lg mb-2">Personnalisation totale</h3>
            <p class="text-gray-600">
                Ajoutez textes, logos ou visuels selon vos besoins.
            </p>
        </div>

        <div class="bg-white rounded-xl shadow p-8 text-center
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
    width: 38px !important;      /* taille équilibrée */
    height: auto !important;
    opacity: 0.9 !important;     /* couleurs visibles */
    filter: blur(0.4px);         /* effet arrière-plan */
    mix-blend-mode: multiply;    /* fusion avec la bannière */
    animation: floatSlow 20s ease-in-out infinite;
}


/* positions */
.float-1 { top: 10%; left: 6%; }
.float-2 { bottom: 15%; left: 12%; }
.float-3 { top: 18%; right: 10%; }
.float-4 { bottom: 12%; right: 18%; }
.float-5 { top: 55%; right: 40%; width: 46px !important; }
.float-6 { top: 15%; right: 5%; width: 50px !important; }

@keyframes floatSlow {
    0% { transform: translateY(0); }
    50% { transform: translateY(-12px); }
    100% { transform: translateY(0); }
}

@media (max-width: 640px) {
    .floating-images { display: none; }
}
</style>




@endsection

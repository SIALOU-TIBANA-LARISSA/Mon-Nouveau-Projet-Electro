@extends('layouts.app')

@section('title', 'Accueil')

@section('content')

<!-- ================= HERO ================= -->
<section class="bg-orange-50 py-20 text-center">

    <h1 id="hero-title" class="text-4xl md:text-5xl font-bold mb-4">
        Personnalisation sur mesure & Impression
    </h1>

    <p id="hero-text" class="text-lg text-gray-600 mb-8 max-w-2xl mx-auto">
        Créez des produits uniques : mugs, coques, textiles et goodies personnalisés
        pour vos cadeaux, événements et entreprises.
    </p>

    <a href="/catalogue"
   class="inline-block bg-orange-500 text-white font-semibold px-8 py-4 rounded-lg shadow
          transition transform duration-300
          hover:bg-orange-600 hover:scale-105
          active:scale-95 cursor-pointer">
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

@endsection


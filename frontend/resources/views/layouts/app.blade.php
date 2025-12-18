<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title') - Electro V2</title>

    <!-- Tailwind CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-100 text-gray-900">

<!-- ================= HEADER UNIQUE ================= -->
<header class="bg-white shadow">

    <div class="max-w-7xl mx-auto px-6 py-4 flex items-center justify-between gap-6">

        <!-- Logo -->
        <a href="/" class="text-2xl font-bold text-orange-500">
            HELECTRO
        </a>

        <!-- BARRE DE RECHERCHE LIVE -->
<div class="flex-1 mx-6">
    <input
        type="text"
        id="search-input"
        placeholder="Rechercher un produit, une marque..."
        class="w-full border border-gray-300 rounded px-4 py-2
               focus:outline-none focus:ring-2 focus:ring-orange-500"
    >
</div>



        <!-- Navigation principale -->
        <nav class="flex items-center gap-6 font-medium">

            <a href="/" class="hover:text-orange-600">Accueil</a>
            <a href="/catalogue" class="hover:text-orange-600">Catalogue</a>
            <a href="/panier" class="hover:text-orange-600">Panier</a>

            <!-- Menu Se connecter -->
            <div class="relative group">
                <button class="flex items-center gap-1 hover:text-orange-600">
                    👤 Se connecter
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M19 9l-7 7-7-7" />
                    </svg>
                </button>

                <div class="absolute right-0 mt-2 w-64 bg-white shadow-lg rounded-lg p-4
                            hidden group-hover:block z-50">

                    <a href="/connexion"
                       class="block w-full text-center bg-orange-500 text-white py-2 rounded mb-3 font-semibold hover:bg-orange-600">
                        SE CONNECTER
                    </a>

                    <a href="/inscription"
                       class="block w-full text-center border border-gray-300 py-2 rounded mb-4 font-semibold hover:bg-gray-100">
                        CRÉER UN COMPTE
                    </a>

                    <hr class="mb-3">

                    <a href="#" class="block py-2 hover:text-orange-600">👤 Votre compte</a>
                    <a href="#" class="block py-2 hover:text-orange-600">🛒 Vos commandes</a>
                    <a href="#" class="block py-2 hover:text-orange-600">❤️ Liste d’envies</a>
                </div>
            </div>

        </nav>
    </div>
</header>
<!-- ================= FIN HEADER ================= -->

<!-- Messages flash -->
@if(session('success'))
    <div class="bg-green-200 text-green-800 p-3 mb-4 rounded text-center">
        {{ session('success') }}
    </div>
@endif

@if(session('error'))
    <div class="bg-red-200 text-red-800 p-3 mb-4 rounded text-center">
        {{ session('error') }}
    </div>
@endif

<!-- Contenu -->
<main class="max-w-7xl mx-auto py-8 px-4">
    @yield('content')
</main>

<footer class="text-center py-4 text-gray-500">
    © 2025 Electro V2
</footer>

<script src="/js/cart.js"></script>
<script src="/js/search.js"></script>

</body>
</html>

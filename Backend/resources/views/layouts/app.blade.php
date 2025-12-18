<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title') - Electro V2</title>

    <!-- Tailwind depuis CDN (simple et rapide) -->
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-100 text-gray-900">

    <!-- Barre de navigation simple -->
    <nav class="bg-white shadow px-6 py-4 flex justify-between">
        <div class="text-2xl font-bold text-indigo-600">Electro V2</div>
        <div class="space-x-4">
            <a href="/" class="hover:text-indigo-500">Accueil</a>
            <a href="/catalogue" class="hover:text-indigo-500">Catalogue</a>
        </div>
    </nav>

    <!-- Contenu des pages -->
    <main class="container mx-auto py-8">
        @yield('content')
    </main>

    <footer class="text-center py-4 text-gray-500">
        © 2025 Electro V2 — Laravel Blade
    </footer>

</body>
</html>


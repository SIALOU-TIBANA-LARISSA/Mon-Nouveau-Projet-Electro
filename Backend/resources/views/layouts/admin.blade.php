<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>@yield('title', 'Admin - Back Office')</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@3/dist/tailwind.min.css" rel="stylesheet">
</head>

<body class="bg-gray-100 min-h-screen flex">

    <!-- SIDEBAR -->
    <aside class="w-64 bg-gray-900 text-white p-6">
        <h2 class="text-xl font-bold mb-6">🛠 Admin Panel</h2>

        <nav class="space-y-4">
            <a href="{{ route('admin.dashboard') }}" class="block hover:text-orange-400">
                📊 Dashboard
            </a>

            <a href="{{ route('admin.products') }}" class="block hover:text-orange-400">
                📦 Produits
            </a>

            <a href="{{ route('admin.orders') }}" class="block hover:text-orange-400">
                🧾 Commandes
            </a>

            <a href="{{ route('admin.users') }}" class="block hover:text-orange-400">
                👤 Utilisateurs
            </a>

</a>

        </nav>
    </aside>

    <!-- CONTENU -->
    <main class="flex-1 p-8">
        @yield('content')
    </main>

</body>
</html>

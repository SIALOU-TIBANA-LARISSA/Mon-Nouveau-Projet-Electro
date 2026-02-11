<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>@yield('title', 'Admin - Back Office')</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-100 min-h-screen flex">

    <!-- SIDEBAR -->
    <aside class="w-64 bg-gray-900 text-white flex flex-col">
        <div class="p-6 border-b border-gray-700">
            <h2 class="text-xl font-bold tracking-wide">🛠 Admin Panel</h2>
            <p class="text-sm text-gray-400 mt-1">Electro V2</p>
        </div>

        <nav class="flex-1 p-6 space-y-2">
            <a href="{{ route('admin.dashboard') }}"
               class="flex items-center gap-3 px-4 py-3 rounded hover:bg-gray-800 transition">
                📊 <span>Dashboard</span>
            </a>

            <a href="{{ route('admin.products') }}"
               class="flex items-center gap-3 px-4 py-3 rounded hover:bg-gray-800 transition">
                📦 <span>Produits</span>
            </a>

            <a href="{{ route('admin.orders') }}"
               class="flex items-center gap-3 px-4 py-3 rounded hover:bg-gray-800 transition">
                🧾 <span>Commandes</span>
            </a>

            <a href="{{ route('admin.users') }}"
               class="flex items-center gap-3 px-4 py-3 rounded hover:bg-gray-800 transition">
                👤 <span>Utilisateurs</span>
            </a>
        </nav>

        <div class="p-6 border-t border-gray-700 text-sm text-gray-400">
            © {{ date('Y') }} Electro
        </div>
    </aside>

    <!-- CONTENU -->
    <main class="flex-1 p-8 overflow-y-auto">
        @yield('content')
    </main>

</body>
</html>

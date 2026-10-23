<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>@yield('title', 'Admin - Back Office')</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-100">

    <!-- SIDEBAR FIXE -->
    <aside class="fixed left-0 top-0 h-screen w-64 bg-gray-900 text-white flex flex-col">

        <div class="p-6 border-b border-gray-700">
            <h2 class="text-xl font-bold tracking-wide">🛠 Admin Panel</h2>
            <p class="text-sm text-gray-400 mt-1">H-Créa & Design</p>
        </div>

        <nav class="flex-1 p-6 space-y-2 overflow-y-auto">
        <a href="{{ route('admin.dashboard') }}"
   class="relative flex items-center gap-3 px-4 py-3 rounded transition
   {{ request()->routeIs('admin.dashboard') 
        ? 'bg-indigo-600 text-white' 
        : 'hover:bg-gray-800' }}">

    {{-- Barre lumineuse --}}
    @if(request()->routeIs('admin.dashboard'))
        <span class="absolute left-0 top-0 h-full w-1 bg-yellow-400 rounded-r"></span>
    @endif

    📊 <span>Dashboard</span>
</a>

            <a href="{{ route('admin.products') }}"
   class="relative flex items-center gap-3 px-4 py-3 rounded transition
   {{ request()->routeIs('admin.products*') 
        ? 'bg-indigo-600 text-white' 
        : 'hover:bg-gray-800' }}">

    @if(request()->routeIs('admin.products*'))
        <span class="absolute left-0 top-0 h-full w-1 bg-yellow-400 rounded-r"></span>
    @endif

    📦 <span>Produits</span>
</a>

            <a href="{{ route('admin.orders') }}"
   class="relative flex items-center gap-3 px-4 py-3 rounded transition
   {{ request()->routeIs('admin.orders*') 
        ? 'bg-indigo-600 text-white' 
        : 'hover:bg-gray-800' }}">

    @if(request()->routeIs('admin.orders*'))
        <span class="absolute left-0 top-0 h-full w-1 bg-yellow-400 rounded-r"></span>
    @endif

    🧾 <span>Commandes</span>
</a>

            <a href="{{ route('admin.users') }}"
   class="relative flex items-center gap-3 px-4 py-3 rounded transition
   {{ request()->routeIs('admin.users*') 
        ? 'bg-indigo-600 text-white' 
        : 'hover:bg-gray-800' }}">

    @if(request()->routeIs('admin.users*'))
        <span class="absolute left-0 top-0 h-full w-1 bg-yellow-400 rounded-r"></span>
    @endif

    👤 <span>Utilisateurs</span>
</a>
        </nav>

        <div class="p-6 border-t border-gray-700 text-sm text-gray-400">
            © {{ date('Y') }} Electro
        </div>

    </aside>


    <!-- CONTENU PRINCIPAL -->
    <main class="ml-64 h-screen overflow-y-auto p-8">

        @if(session('success') || session('error'))
        <div id="flash-message"
             class="p-3 mb-4 rounded text-white transition-opacity duration-500
             {{ session('success') ? 'bg-green-500' : 'bg-red-500' }}">
             
            {{ session('success') ?? session('error') }}
        </div>

        <script>
            setTimeout(() => {
                const msg = document.getElementById('flash-message');
                if (msg) {
                    msg.style.opacity = '0';
                    setTimeout(() => msg.remove(), 500);
                }
            }, 3000);
        </script>
        @endif

        @yield('content')

    </main>

</body>
</html>
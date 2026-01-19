@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto px-4 py-8">

    <div class="grid grid-cols-1 md:grid-cols-4 gap-6">

        <!-- COLONNE GAUCHE : MENU COMPTE -->
        <aside class="bg-white rounded-lg shadow p-4 md:col-span-1">
            <h2 class="font-bold text-gray-700 mb-4">Votre compte</h2>

            <ul class="space-y-3 text-sm">
                <li class="font-semibold text-orange-600">👤 Votre compte</li>
                <li>
                    <a href="/orders" class="text-gray-600 hover:text-orange-500">
                        📦 Vos commandes
                    </a>
                </li>
                <li class="text-gray-400 cursor-not-allowed">
                    ✉️ Boîte de réception
                </li>
                <li class="text-gray-400 cursor-not-allowed">
                    ⭐ Favoris
                </li>
                <li class="text-gray-400 cursor-not-allowed">
                    📍 Adresses
                </li>
            </ul>

            <button
                id="logoutBtnAccount"
                class="mt-6 w-full bg-gray-100 text-sm py-2 rounded hover:bg-gray-200">
                🚪 Se déconnecter
            </button>
        </aside>

        <!-- COLONNE DROITE : CONTENU -->
        <section class="md:col-span-3 space-y-6">

            <!-- BIENVENUE -->
            <div class="bg-white rounded-lg shadow p-6">
                <h1 class="text-2xl font-bold text-gray-800">
                    Bienvenue, <span id="userName" class="text-orange-600"></span>
                </h1>
                <p class="text-sm text-gray-500">
                    Gérez vos informations personnelles et vos commandes
                </p>
            </div>

            <!-- INFOS PERSONNELLES -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                <div class="bg-white rounded-lg shadow p-6">
                    <h3 class="font-semibold text-gray-700 mb-2">
                        Informations personnelles
                    </h3>
                    <p class="text-gray-800 font-medium" id="userNameBlock"></p>
                    <p class="text-gray-500 text-sm" id="userEmail"></p>
                </div>

                <div class="bg-white rounded-lg shadow p-6">
                    <h3 class="font-semibold text-gray-700 mb-2">
                        Préférences
                    </h3>
                    <p class="text-gray-500 text-sm">
                        Les paramètres de communication seront bientôt disponibles.
                    </p>
                </div>

            </div>

            <!-- ACTIONS RAPIDES -->
            <div class="bg-white rounded-lg shadow p-6">
                <a href="/orders"
                   class="inline-block bg-orange-500 text-white px-5 py-2 rounded hover:bg-orange-600">
                    📦 Voir mes commandes
                </a>
            </div>

        </section>

    </div>
</div>

<script>
document.addEventListener("DOMContentLoaded", () => {
    const user = JSON.parse(localStorage.getItem("user"));

    if (!user) {
        window.location.href = "/login";
        return;
    }

    document.getElementById("userName").textContent = user.name;
    document.getElementById("userNameBlock").textContent = user.name;
    document.getElementById("userEmail").textContent = user.email;
});

// Déconnexion
document.getElementById("logoutBtnAccount").addEventListener("click", () => {
    localStorage.removeItem("user");
    localStorage.removeItem("auth_token");
    window.location.href = "/";
});
</script>
@endsection



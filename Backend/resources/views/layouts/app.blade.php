<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>H-ELECTRO — Impression & personnalisation</title>

    <script src="https://cdn.tailwindcss.com"></script>

    <meta name="csrf-token" content="{{ csrf_token() }}">

<style>
/* ===== LOADER ===== */
#loader {
    position: fixed;
    inset: 0;
    background: #FFEFD6; /* couleur gris très clair */
    display: flex;
    align-items: center;
    justify-content: center;
    z-index: 9999;
}

.loader-content {
    text-align: center;
}

.loader-logo {
    width: 90px;          /* taille du logo */
    margin-bottom: 20px;
}

/* SPINNER */
.spinner {
    width: 40px;
    height: 40px;
    border: 4px solid #f3f3f3;
    border-top: 4px solid #f97316; /* orange */
    border-radius: 50%;
    animation: spin 1s linear infinite;
}

@keyframes spin {
    to {
        transform: rotate(360deg);
    }
}
</style>


</head>
<body class="bg-gray-100 text-base md:text-lg">

    <!-- LOADER -->
    <div id="loader">
        <div class="loader-content">
            <img src="{{ asset('images/logo.avif') }}" alt="Logo" class="loader-logo">
            <div class="spinner"></div>
        </div>
    </div>


<header class="bg-white shadow">
    <div class="max-w-7xl mx-auto px-4 py-3 flex justify-between items-center">

        <!-- LOGO -->
        <span class="text-xl font-bold text-orange-600">
          H-ELECTRO
        </span>
        <span class="block text-sm text-gray-500">
           Impression & personnalisation
         </span>


        <!-- MENU PRINCIPAL -->
        <nav class="flex items-center gap-6 text-sm font-semibold">

            <a href="/" class="hover:text-orange-500">Accueil</a>

            <a href="/catalogue" class="hover:text-orange-500">Catalogue</a>

            <a href="/cart" class="hover:text-orange-500">🛒 Panier</a>
            <a href="/contact" class="hover:text-orange-500">Contact</a>



            <!-- UTILISATEUR NON CONNECTÉ -->
@guest
<div id="guestMenu" class="relative">

    <button
        id="loginToggle"
        class="bg-orange-500 text-white px-4 py-2 rounded hover:bg-orange-600">
        Se connecter
    </button>

    <div
        id="loginMenu"
        class="absolute right-0 mt-2 w-48 bg-white shadow rounded hidden z-50">

        <a href="/login" class="block px-4 py-2 hover:bg-orange-50">
            Se connecter
        </a>

        <a href="/register" class="block px-4 py-2 hover:bg-orange-50">
            Créer un compte
        </a>
    </div>

</div>
@endguest
 

<!-- UTILISATEUR CONNECTÉ (via localStorage) -->
<div id="userMenu" class="relative hidden relative group">

    <button class="flex items-center gap-2 hover:text-orange-500">
        👤 <span id="userName"></span>
    </button>

    <div id="userDropdown" class="absolute right-0 mt-2 w-56 bg-white shadow rounded hidden z-50">

        <a href="/account" class="block px-4 py-2 hover:bg-orange-50">
            Votre compte
        </a>

        <a href="/my-orders"
   class="block px-4 py-2 hover:bg-orange-50">
    Vos commandes
</a>


        <button
            id="logoutBtn"
            class="w-full text-left px-4 py-2 hover:bg-orange-50 text-red-600">
            Se déconnecter
        </button>
    </div>

</div>

        </nav>

    </div>
</header>


<main class="py-6">
    @yield('content')
</main>

<script>
document.addEventListener("DOMContentLoaded", () => {
    const input = document.getElementById("search-input");
    const container = document.getElementById("products-container");

    if (!input || !container) return;

    let timeout = null;

    input.addEventListener("keyup", () => {
        clearTimeout(timeout);
        const query = input.value.trim();

        if (query.length < 1) {
            return;
        }

        timeout = setTimeout(() => {
            fetch(`/api/products/search?q=${encodeURIComponent(query)}`)


                .then(res => res.json())
                .then(response => {

                    const products = response.data;

                    container.innerHTML = "";

                    if (!products || products.length === 0) {
                        container.innerHTML = `
                            <p class="text-gray-500 col-span-full">
                                Aucun produit trouvé
                            </p>`;
                        return;
                    }

                    products.forEach(product => {
                        container.innerHTML += `
    <div class="bg-white shadow rounded-lg overflow-hidden">
            <img
             src="${product.main_image_url}"
             class="w-full h-40 object-cover"
             alt="${product.name}"
             >

        <div class="p-4">
            <h2 class="font-semibold text-sm">
                ${product.name}
            </h2>

            <div class="mt-2 font-bold text-orange-500">
                ${Number(product.price).toLocaleString()} FCFA
            </div>

            <a href="/products/${product.id}"
               class="mt-3 block text-center bg-orange-500 text-white py-2 rounded hover:bg-orange-600">
                Voir détails
            </a>

            <button
                class="mt-2 w-full bg-gray-200 py-2 rounded hover:bg-gray-300 add-to-cart"
                data-id="${product.id}"
                data-name="${product.name}"
                data-price="${product.price}"
                data-image="${product.main_image_url}">
                Ajouter au panier
            </button>
        </div>
    </div>
`;

});

                            
                })
                .catch(err => {
                    console.error("Erreur recherche :", err);
                });
        }, 300);
    });
});
</script>


<!-- ========================= -->
<!-- 1️⃣ PANIER (DOIT ÊTRE 1ER) -->
<!-- ========================= -->
<script src="/js/cart.js"></script>


<!-- ========================= -->
<!-- 2️⃣ MENU CONNEXION -->
<!-- ========================= -->
<script>
document.addEventListener('click', function (e) {
    const toggle = document.getElementById('loginToggle');
    const menu = document.getElementById('loginMenu');

    if (!toggle || !menu) return;

    if (toggle.contains(e.target)) {
        menu.classList.toggle('hidden');
        return;
    }

    if (!menu.contains(e.target)) {
        menu.classList.add('hidden');
    }
});
</script>

<!-- ========================= -->
<!-- 3️⃣ LOGOUT -->
<!-- ========================= -->
<script>
document.addEventListener('click', function (e) {
    if (!e.target.matches('#logoutBtn')) return;

    const token = localStorage.getItem('auth_token');

    localStorage.removeItem('auth_token');
    localStorage.removeItem('user');

    if (token) {
        fetch('/api/auth/logout', {
            method: 'POST',
            headers: {
                'Authorization': 'Bearer ' + token,
                'Accept': 'application/json'
            }
        }).catch(() => {});
    }

    window.location.href = '/';
});
</script>

<script>
document.addEventListener("DOMContentLoaded", () => {
    const user = JSON.parse(localStorage.getItem("user"));

    const guestMenu = document.getElementById("guestMenu");
    const userMenu  = document.getElementById("userMenu");
    const userName  = document.getElementById("userName");
    const dropdown  = document.getElementById("userDropdown");

    if (user && userMenu && userName) {
        userName.textContent = user.name;
        userMenu.classList.remove("hidden");
        if (guestMenu) guestMenu.classList.add("hidden");
    }

    // Toggle menu au clic sur "Client Test"
    userMenu?.querySelector("button")?.addEventListener("click", () => {
        dropdown.classList.toggle("hidden");
    });

    // Fermer si clic ailleurs
    document.addEventListener("click", (e) => {
        if (!userMenu.contains(e.target)) {
            dropdown.classList.add("hidden");
        }
    });
});
</script>

<script>
document.addEventListener("DOMContentLoaded", () => {
    const user = localStorage.getItem("user");

    const protectedPages = ["/account", "/my-orders"];

    const currentPath = window.location.pathname;

    if (protectedPages.includes(currentPath) && !user) {
        window.location.href = "/login";
    }
});
</script>

<script>
document.addEventListener("DOMContentLoaded", () => {

    function typeWriter(element, speed) {
        const text = element.textContent;
        element.textContent = "";
        let i = 0;

        function write() {
            if (i < text.length) {
                element.textContent += text.charAt(i);
                i++;
                setTimeout(write, speed);
            }
        }

        write();
    }

    const title = document.getElementById("hero-title");
    const text  = document.getElementById("hero-text");

    if (title) {
        typeWriter(title, 80);

        setTimeout(() => {
            if (text) typeWriter(text, 30);
        }, 1200);
    }

});
</script>

<script>
window.addEventListener("load", function () {
    const loader = document.getElementById("loader");

    // Si ce n'est PAS la page d'accueil, on cache immédiatement
    if (window.location.pathname !== "/") {
        if (loader) loader.style.display = "none";
        return;
    }

    // Animation uniquement sur la page d'accueil
    setTimeout(() => {
        if (loader) {
            loader.style.opacity = "0";
            loader.style.transition = "opacity 0.5s ease";
            setTimeout(() => {
                loader.style.display = "none";
            }, 500);
        }
    }, 2000); // durée du loader accueil
});
</script>


</body>
</html>

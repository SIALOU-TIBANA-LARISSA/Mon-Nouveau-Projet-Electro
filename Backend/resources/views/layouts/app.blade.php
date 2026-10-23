<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>H-Créa & Design — Impression & personnalisation</title>

    <script src="https://cdn.tailwindcss.com"></script>

    <meta name="csrf-token" content="{{ csrf_token() }}">
    <!-- Bootstrap CSS -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

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
/* Empêche le débordement horizontal */
html, body {
    overflow-x: hidden;
}

</style>


</head>
<body class="bg-white text-[19px] sm:text-[17px] md:text-lg">

@php
$cartCount = 0;

if(auth()->check()) {
    $cart = \App\Models\Cart::where('user_id', auth()->id())
        ->with('items')
        ->first();

    if($cart) {
        $cartCount = $cart->items->sum('quantity');
    }
}
@endphp
    <!-- LOADER -->
    <div id="loader">
        <div class="loader-content">
            <img src="{{ asset('images/logo.avif') }}?v=2" alt="Logo" class="loader-logo">

            <div class="spinner"></div>
        </div>
    </div>


<header id="siteHeader" class="fixed top-0 left-0 w-full z-50 bg-white border-b border-gray-200">

    <div class="max-w-7xl mx-auto px-4 py-2 flex flex-col md:flex-row md:items-center md:justify-between">
        <!-- LOGO -->
        <div class="flex justify-between items-center w-full md:w-auto">

    <div>
        <span class="text-base md:text-xl font-bold text-orange-600">
            H-Créa & Design
        </span>
        <div class="text-xs text-gray-500">
            Impression & personnalisation
        </div>
    </div>

    <!-- Bouton Catégories mobile -->
    <button id="hamburgerBtn"
    class="block lg:hidden text-3xl text-orange-600
           transition-transform duration-300">
    <span id="hamburgerIcon">☰</span>
</button>

</div>


        <!-- MENU PRINCIPAL -->
        <nav id="mainMenu"
     class="hidden lg:flex items-center gap-4 text-xs md:text-sm font-semibold">

            <a href="/" class="hover:text-orange-500">Accueil</a>

            <a href="/catalogue" class="hover:text-orange-500">Catalogue</a> 

 <a href="/cart" class="relative inline-flex items-center gap-2 hover:text-orange-500">
    <span class="text-lg">🛒</span>
    <span>Panier</span>

    <span id="cart-badge"
          class="ml-1 bg-green-500 text-white text-xs px-2 py-0.5 rounded-full"
          style="{{ $cartCount > 0 ? '' : 'display:none;' }}">
        {{ $cartCount }}
    </span>
</a>
            <a href="/contact" class="hover:text-orange-500">Contact</a>


            @guest
<div id="guestMenu" class="relative">
    <button
        id="loginToggle"
        class="bg-orange-500 text-white px-4 py-2 rounded hover:bg-orange-600">
        Se connecter
    </button>

    <div
        id="loginMenu"
        class="absolute right-0 mt-2 w-48 bg-white shadow rounded hidden z-[9999]">

        <a href="/login" class="block px-4 py-2 hover:bg-orange-50">
            Se connecter
        </a>

        <a href="/register" class="block px-4 py-2 hover:bg-orange-50">
            Créer un compte
        </a>
    </div>
</div>
@endguest


@auth
<div id="userMenu" class="relative">
    <button id="userToggle" class="flex items-center gap-2 hover:text-orange-500 py-2">
        👤 {{ auth()->user()->name }}
    </button>

    <div id="userDropdown"
        class="absolute right-0 mt-2 w-48 bg-white shadow rounded hidden z-[9999]">

        <a href="/account" class="block px-4 py-2 hover:bg-orange-50">
            Votre compte
        </a>

        <a href="/my-orders" class="block px-4 py-2 hover:bg-orange-50">
            Vos commandes
        </a>

        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit"
                class="w-full text-left px-4 py-2 hover:bg-orange-50 text-red-600">
                Se déconnecter
            </button>
        </form>
    </div>
</div>
@endauth
</div>

        </nav>

    </div>
</header>

<!-- MENU MOBILE PRINCIPAL -->
<div id="mobileMainMenu"
     class="flex flex-col bg-white shadow-md p-4 lg:hidden fixed top-[70px] left-0 w-72 h-[calc(100vh-70px)] z-40
            transform -translate-x-full transition-transform duration-300">

    <a href="/" 
   class="menu-item py-2 border-b opacity-0 -translate-x-3 transition-all duration-300">
   Accueil
</a>

<a href="/catalogue" 
   class="menu-item py-2 border-b opacity-0 -translate-x-3 transition-all duration-300">
   Catalogue
</a>

<a href="/cart" 
   class="menu-item py-2 border-b flex items-center justify-between opacity-0 -translate-x-3 transition-all duration-300">

    <span>🛒 Panier</span>

    <span id="mobile-cart-badge"
          class="bg-green-500 text-white text-xs px-2 py-0.5 rounded-full"
          style="{{ $cartCount > 0 ? '' : 'display:none;' }}">
        {{ $cartCount }}
    </span>
</a>

<a href="/contact" 
   class="menu-item py-2 opacity-0 -translate-x-3 transition-all duration-300">
   Contact
</a>

    {{-- ICI TU COLLES LE CODE --}}

    @guest
    <div class="border-t pt-2">
        <button id="mobileLoginToggle"
            class="w-full text-left py-2 text-orange-600 font-semibold">
            Se connecter
        </button>

        <div id="mobileLoginMenu" class="hidden pl-4">
            <a href="/login" class="block py-2">Se connecter</a>
            <a href="/register" class="block py-2">Créer un compte</a>
        </div>
    </div>
    @endguest

    @auth
    <div class="border-t pt-2">
        <button id="mobileUserToggle"
            class="w-full text-left py-2 font-semibold">
            👤 {{ auth()->user()->name }}
        </button>

        <div id="mobileUserMenu" class="hidden pl-4">
            <a href="/account" class="block py-2">Votre compte</a>
            <a href="/my-orders" class="block py-2">Vos commandes</a>

            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit"
                    class="w-full text-left py-2 text-red-600">
                    Se déconnecter
                </button>
            </form>
        </div>
    </div>
    @endauth

</div>

</div>

<div id="mobileOverlay"
     class="fixed inset-0 bg-black/40 z-30 lg:hidden
            opacity-0 pointer-events-none
            transition-opacity duration-300">
</div>

<main id="siteContent">
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

<script>
window.showCartMessage = function () {
    const msg = document.getElementById('cart-message');
    if (!msg) return;

    msg.style.display = 'block';

    setTimeout(() => {
        msg.style.display = 'none';
    }, 2000);
};
</script>


<!-- ========================= -->
<!-- 1️⃣ PANIER (DOIT ÊTRE 1ER) -->
<!-- ========================= -->
<script src="{{ asset('js/cart.js') }}?v={{ time() }}"></script>



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

<div id="cart-message"
     style="display:none;
            position:fixed;
            top:20px;
            right:20px;
            background:#22c55e;  
            color:white;
            padding:12px 18px;
            border-radius:8px;
            z-index:9999;
            font-weight:600;">
    Produit ajouté au panier avec succès ✅
</div>

<!-- Bootstrap JS (obligatoire pour le carousel) -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

<!-- ================= FOOTER ================= -->
<footer class="bg-gray-100 text-gray-800 mt-8">

    <!-- ===== SECTION HAUTE ===== -->
    <div class="max-w-7xl mx-auto px-6 pt-10 pb-8 grid grid-cols-1 md:grid-cols-3 gap-10 items-start">

        <!-- Logo + Description -->
        <div>
            <img src="{{ asset('images/logo.avif') }}?v=2"
                 alt="Logo H-Créa"
                 class="h-32 mb-4">

            <p class="text-sm leading-relaxed">
                Spécialiste en modélisation & impression 3D sur mesure.
                Solutions personnalisées pour particuliers et entreprises.
            </p>
        </div>

       <!-- Nos Produits -->
<div>
    <h3 class="text-gray-900 font-semibold mb-6">Nos Produits</h3>

    <div class="grid grid-cols-2 gap-8 text-sm text-gray-700">

        <!-- Colonne 1 -->
        <div class="space-y-2">
            <p>Mug</p>
            <p>Vases</p>
            <p>Trophée</p>
            <p>Veilleuses</p>
            <p>Boite à Bijoux</p>
            <p>Présentoir Bijoux</p>
            <p>Déco Noël</p>
        </div>

        <!-- Colonne 2 -->
        <div class="space-y-2">
            <p>Coque Téléphone</p>
            <p>Cadre photo</p>
            <p>Support d'ordinateur</p>
            <p>Stickers Vinyle</p>
            <p>Puzzle</p>
            <p>Sapin de Noël</p>
            <p>Outils de Bureau</p>
        </div>

    </div>
</div>

        <!-- Contact -->
        <div>
            <h3 class="text-gray-900 font-semibold mb-4">Contact</h3>

            <p class="text-sm mb-2">📍 Abidjan, Côte d’Ivoire</p>
            <p class="text-sm mb-3">📧 fabcrea@h-fablab.org</p>

            <p class="text-sm mb-3 leading-relaxed">
                📍 Bingerville Akouay Santai,<br>
                Derrière le Jardin Botanique<br>
                Non loin de la cité De LACELLE
            </p>

            <a href="tel:+2250586414545"
               class="block text-sm mb-2 hover:text-orange-500 transition">
                📞 +225 05 86 41 45 45
            </a>

            <a href="tel:+2250584208080"
               class="block text-sm mb-4 hover:text-orange-500 transition">
                📞 +225 05 84 20 80 80
            </a>

        </div>

    </div>

    <!-- ===== PAIEMENTS ===== -->
    <div class="max-w-7xl mx-auto px-6 pb-8">

        <h4 class="text-center text-gray-800 text-xl font-semibold mb-4">
            Nos Moyens de Paiement
        </h4>

        <div class="flex justify-center items-center flex-wrap gap-6">

            <img src="{{ asset('images/payments/Orange-Money-logo.jpg') }}"
                 alt="Orange Money"
                 class="h-12 object-contain transition hover:scale-110">

            <img src="{{ asset('images/payments/MTN.jpg') }}"
                 alt="MTN Money"
                 class="h-12 object-contain transition hover:scale-110">

            <img src="{{ asset('images/payments/Moov.png') }}"
                 alt="Moov Money"
                 class="h-12 object-contain transition hover:scale-110">

            <img src="{{ asset('images/payments/Wave.jpg') }}"
                 alt="Wave"
                 class="h-12 object-contain transition hover:scale-110">

            <img src="{{ asset('images/payments/MasterCard.jpg') }}"
                 alt="MasterCard"
                 class="h-12 object-contain transition hover:scale-110">

        </div>

    </div>

    <!-- ===== RÉSEAUX + COPYRIGHT ===== -->
    <div class="py-6 text-center">

        <div class="flex justify-center space-x-6 mb-4">

<a href="https://www.facebook.com/himprimerie" 
   target="_blank"
   class="bg-gray-800 p-3 rounded-full hover:bg-orange-500 transition">
   <i class="fab fa-facebook-f text-white"></i>
</a>

<a href="#" class="bg-gray-800 p-3 rounded-full hover:bg-orange-500 transition">
<i class="fab fa-instagram text-white"></i>
</a>

<a href="#" class="bg-gray-800 p-3 rounded-full hover:bg-orange-500 transition">
<i class="fab fa-linkedin-in text-white"></i>
</a>

</div>

        <p class="text-gray-500 text-sm">
            © {{ date('Y') }} H-Créa & Design. Tous droits réservés.
        </p>

    </div>

</footer>

<script>
function adjustLayout() {
    const header = document.getElementById('siteHeader');
    const content = document.getElementById('siteContent');

    if (!header || !content) return;

    const headerHeight = header.offsetHeight;
    content.style.marginTop = headerHeight + "px";
}

window.addEventListener("load", adjustLayout);
window.addEventListener("resize", adjustLayout);
</script>

<script>
document.addEventListener("DOMContentLoaded", function () {

    const userToggle = document.getElementById("userToggle");
    const userDropdown = document.getElementById("userDropdown");

    if (userToggle && userDropdown) {
        userToggle.addEventListener("click", function (e) {
            e.stopPropagation();
            userDropdown.classList.toggle("hidden");
        });

        document.addEventListener("click", function (e) {
            if (!userToggle.contains(e.target) && !userDropdown.contains(e.target)) {
                userDropdown.classList.add("hidden");
            }
        });
    }

});
</script>

<script>
document.addEventListener("DOMContentLoaded", function () {

    const btn = document.getElementById("hamburgerBtn");
    const icon = document.getElementById("hamburgerIcon");
    const mobileMenu = document.getElementById("mobileMainMenu");
    const overlay = document.getElementById("mobileOverlay");

    if (!btn || !mobileMenu || !overlay || !icon) return;

    btn.addEventListener("click", function () {

        const isOpen = !mobileMenu.classList.contains("-translate-x-full");

        mobileMenu.classList.toggle("-translate-x-full");

        overlay.classList.toggle("opacity-0");
        overlay.classList.toggle("pointer-events-none");

        // Change icône ☰ ↔ ✖
        icon.textContent = isOpen ? "☰" : "✖";
    });

    overlay.addEventListener("click", function () {

        mobileMenu.classList.add("-translate-x-full");
        overlay.classList.add("opacity-0");
        overlay.classList.add("pointer-events-none");

        icon.textContent = "☰";
    });

});
</script>
<script>
document.addEventListener("DOMContentLoaded", function () {

    const btn = document.getElementById("hamburgerBtn");
    const mobileMenu = document.getElementById("mobileMainMenu");
    const menuItems = document.querySelectorAll("#mobileMainMenu .menu-item");

    if (!btn || !mobileMenu) return;

    btn.addEventListener("click", function () {

        if (!mobileMenu.classList.contains("-translate-x-full")) {

            menuItems.forEach((item, index) => {
                setTimeout(() => {
                    item.classList.remove("opacity-0", "-translate-x-3");
                }, index * 100);
            });

        } else {

            menuItems.forEach(item => {
                item.classList.add("opacity-0", "-translate-x-3");
            });

        }

    });

});
</script>
<script>
document.addEventListener("DOMContentLoaded", function () {

    const loginToggle = document.getElementById("mobileLoginToggle");
    const loginMenu = document.getElementById("mobileLoginMenu");

    if (loginToggle && loginMenu) {
        loginToggle.addEventListener("click", function () {
            loginMenu.classList.toggle("hidden");
        });
    }

    const userToggle = document.getElementById("mobileUserToggle");
    const userMenu = document.getElementById("mobileUserMenu");

    if (userToggle && userMenu) {
        userToggle.addEventListener("click", function () {
            userMenu.classList.toggle("hidden");
        });
    }

});
</script>
</body>
</html>

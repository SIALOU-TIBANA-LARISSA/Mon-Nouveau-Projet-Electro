// ===============================
// GESTION DU PANIER (LocalStorage)
// ===============================

const CART_KEY = "cart";

/* --------- UTILITAIRES --------- */

function getCart() {
    return JSON.parse(localStorage.getItem(CART_KEY)) || [];
}

function saveCart(cart) {
    localStorage.setItem(CART_KEY, JSON.stringify(cart));
}

/* --------- AJOUT PANIER --------- */

function addToCart(product) {
    let cart = getCart();

    const existing = cart.find(item => item.id == product.id);

    if (existing) {
        existing.quantity += 1;
    } else {
        cart.push({
            id: product.id,
            name: product.name,
            price: product.price,
            quantity: 1,
            image: product.image
        });
    }

    saveCart(cart);

    // ✅ MESSAGE DE CONFIRMATION
    if (typeof showCartMessage === "function") {
        showCartMessage();
    }
}


/* --------- SUPPRESSION --------- */

function removeFromCart(id) {
    let cart = getCart().filter(item => item.id != id);
    saveCart(cart);
    location.reload();
}

/* --------- QUANTITÉ --------- */

function increaseQuantity(id) {
    let cart = getCart();

    cart.forEach(item => {
        if (item.id == id) {
            item.quantity++;
        }
    });

    saveCart(cart);
    location.reload();
}

function decreaseQuantity(id) {
    let cart = getCart();

    cart.forEach(item => {
        if (item.id == id && item.quantity > 1) {
            item.quantity--;
        }
    });

    saveCart(cart);
    location.reload();
}

/* --------- VIDER PANIER --------- */

function clearCart() {
    localStorage.removeItem(CART_KEY);
    location.reload();
}
// ===============================
// DÉLÉGATION POUR BOUTONS AJAX
// ===============================

document.addEventListener("click", function (e) {
    const btn = e.target.closest(".add-to-cart");
    if (!btn) return;

    const product = {
        id: btn.dataset.id,
        name: btn.dataset.name,
        price: Number(btn.dataset.price),
        image: btn.dataset.image
    };

    addToCart(product);
});


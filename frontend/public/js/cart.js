// =============================
// PANIER LOCALSTORAGE (CLEAN)
// =============================

// Récupérer le panier
function getCart() {
    return JSON.parse(localStorage.getItem("cart")) || [];
}

// Sauvegarder le panier
function saveCart(cart) {
    localStorage.setItem("cart", JSON.stringify(cart));
}

// Ajouter au panier
function addToCart(product) {
    let cart = getCart();
    let item = cart.find(i => i.id === product.id);

    if (item) {
        item.quantity += 1;
    } else {
        cart.push({
            id: product.id,
            name: product.name,
            unit_price: product.price,
            quantity: 1,
            image: product.image
        });
    }

    saveCart(cart);
    
    //alert("Produit ajouté au panier !");
}

// Supprimer un produit
function removeFromCart(productId) {
    let cart = getCart().filter(item => item.id !== productId);
    saveCart(cart);
    location.reload();
}

// ➕ Augmenter la quantité
function increaseQuantity(productId) {
    let cart = getCart();
    let item = cart.find(i => i.id === productId);

    if (item) {
        item.quantity++;
        saveCart(cart);
        location.reload();
    }
}

// ➖ Diminuer la quantité
function decreaseQuantity(productId) {
    let cart = getCart();
    let item = cart.find(i => i.id === productId);

    if (item && item.quantity > 1) {
        item.quantity--;
        saveCart(cart);
        location.reload();
    }
}

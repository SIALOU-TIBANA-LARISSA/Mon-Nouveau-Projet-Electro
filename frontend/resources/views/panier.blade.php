@extends('layouts.app')

@section('title', 'Mon Panier')

@section('content')
<div class="max-w-4xl mx-auto bg-white p-6 shadow rounded">

    <h1 class="text-3xl font-bold mb-6">Mon Panier</h1>

    <div id="cart-items"></div>

    <div id="cart-total" class="text-right text-2xl font-bold mt-6">
        Total : 0 FCFA
    </div>

    <div class="mt-6 text-right">
        <a href="/checkout"
           class="bg-indigo-600 text-white px-6 py-3 rounded hover:bg-orange-600">
           Passer à la commande
        </a>
    </div>

</div>

<script src="/js/cart.js"></script>

<script>
    function displayCart() {
        let cart = getCart();
        let container = document.getElementById("cart-items");

        if (cart.length === 0) {
            container.innerHTML = "<p class='text-gray-500'>Votre panier est vide.</p>";
            return;
        }

        container.innerHTML = cart.map(item => `
            <div class="flex items-center justify-between border-b py-4">
                
                <div>
                    <h2 class="text-lg font-semibold">${item.name}</h2>
                    <p>${item.unit_price.toLocaleString()} FCFA</p>
                </div>

                <div class="flex items-center space-x-3">

                    <button onclick="updateQuantity(${item.id}, ${item.quantity - 1})"
                            class="px-2 bg-gray-300 rounded">-</button>

                    <span>${item.quantity}</span>

                    <button onclick="updateQuantity(${item.id}, ${item.quantity + 1})"
                            class="px-2 bg-gray-300 rounded">+</button>

                    <button onclick="removeFromCart(${item.id})"
                            class="bg-red-500 text-white px-3 py-1 rounded">
                        Supprimer
                    </button>
                </div>
            </div>
        `).join("");

        updateTotal();
    }

    function updateTotal() {
        let cart = getCart();
        let total = cart.reduce((sum, item) => sum + item.unit_price * item.quantity, 0);

        document.getElementById("cart-total").innerHTML =
            "Total : " + total.toLocaleString() + " FCFA";
    }

    displayCart();
</script>

@endsection

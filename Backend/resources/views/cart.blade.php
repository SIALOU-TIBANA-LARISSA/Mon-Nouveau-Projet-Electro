@extends('layouts.app')

@section('title', 'Mon Panier')

@section('content')

<div class="max-w-4xl mx-auto mt-10 bg-white shadow p-6 rounded-lg">

    <h1 class="text-3xl font-bold mb-6">🛒 Mon Panier</h1>

    <!-- CONTENU DU PANIER -->
    <div id="cart-items"></div>

    <!-- PANIER VIDE -->
    <div id="cart-empty" class="text-gray-500 text-center py-10 hidden">
        Votre panier est vide.
    </div>

    <!-- TOTAL -->
    <div id="cart-total" class="text-right text-2xl font-bold mt-6 hidden">
        Total : <span id="total-amount">0</span> FCFA
    </div>

    <!-- BOUTON COMMANDE -->
    <div class="text-right mt-6">
        <a href="/checkout"
           id="checkout-btn"
           class="bg-orange-500 text-white px-6 py-3 rounded font-semibold
                  hover:bg-orange-600 transition hidden">
            Passer à la commande
        </a>
    </div>

</div>

{{-- cart.js DOIT être chargé UNE SEULE FOIS dans app.blade.php --}}
<script>
document.addEventListener("DOMContentLoaded", loadCart);

function loadCart() {

    let cart = getCart(); // vient de cart.js

    let container = document.getElementById("cart-items");
    let emptyMessage = document.getElementById("cart-empty");
    let totalContainer = document.getElementById("cart-total");
    let checkoutBtn = document.getElementById("checkout-btn");

    container.innerHTML = "";

    // 🔹 PANIER VIDE
    if (cart.length === 0) {
        emptyMessage.classList.remove("hidden");
        totalContainer.classList.add("hidden");
        checkoutBtn.classList.add("hidden");
        return;
    }

    emptyMessage.classList.add("hidden");

    let total = 0;

    cart.forEach(item => {

        const price = Number(item.price) || 0;
        total += price * item.quantity;

        container.innerHTML += `
            <div class="flex items-center justify-between border-b py-4">

                <div class="flex items-center gap-4">
                    <img src="${item.image}" class="w-16 h-16 rounded shadow" alt="">
                    <div>
                        <p class="font-bold">${item.name}</p>
                        <p class="text-gray-600">${price.toLocaleString()} FCFA</p>
                    </div>
                </div>

                <div class="flex items-center gap-4">

                    <div class="flex items-center gap-2">
                        <button
                            onclick="decreaseQuantity('${item.id}')"
                            class="bg-gray-200 px-3 py-1 rounded hover:bg-gray-300 font-bold"
                        >−</button>

                        <span class="font-bold">${item.quantity}</span>

                        <button
                            onclick="increaseQuantity('${item.id}')"
                            class="bg-gray-200 px-3 py-1 rounded hover:bg-gray-300 font-bold"
                        >+</button>
                    </div>

                    <button
                        onclick="removeFromCart('${item.id}')"
                        class="text-red-600 hover:text-red-800 font-bold"
                    >
                        X
                    </button>

                </div>
            </div>
        `;
    });

    document.getElementById("total-amount").innerText = total.toLocaleString();
    totalContainer.classList.remove("hidden");
    checkoutBtn.classList.remove("hidden");
}
</script>

@endsection

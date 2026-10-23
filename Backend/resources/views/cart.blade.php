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
@endsection


{{-- cart.js DOIT être chargé UNE SEULE FOIS dans app.blade.php --}}
<script>
document.addEventListener("DOMContentLoaded", loadCart);

function loadCart() {

    let container = document.getElementById("cart-items");

    // 🔥 IMPORTANT : si on n'est pas sur la page panier, on arrête
    if (!container) return;

    fetch('/cart-data', {
        credentials: 'same-origin'
    })
    .then(res => {
        if (!res.ok) throw new Error();
        return res.json();
    })
    .then(data => {

        let container = document.getElementById("cart-items");
        let emptyMessage = document.getElementById("cart-empty");
        let totalContainer = document.getElementById("cart-total");
        let checkoutBtn = document.getElementById("checkout-btn");

        container.innerHTML = "";

        if (!data.items || data.items.length === 0) {
            emptyMessage.classList.remove("hidden");
            totalContainer.classList.add("hidden");
            checkoutBtn.classList.add("hidden");
            return;
        }

        emptyMessage.classList.add("hidden");

        let total = 0;

        data.items.forEach(item => {

            const price = Number(item.unit_price);
            total += price * item.quantity;

            container.innerHTML += `
                <div class="flex items-center justify-between border-b py-4">

                    <div class="flex items-center gap-4">
                        <img src="${item.product.main_image_url}" 
                             class="w-16 h-16 rounded shadow" alt="">
                        <div>
                            <p class="font-bold">${item.product.name}</p>
                            <p class="text-gray-600">${price.toLocaleString()} FCFA</p>
                        </div>
                    </div>

                    <div class="flex items-center gap-4">

                        <div class="flex items-center gap-3">

    <button onclick="updateQuantity(${item.id}, -1)"
            class="px-2 bg-gray-200 rounded">-</button>

    <span class="font-bold">${item.quantity}</span>

    <button onclick="updateQuantity(${item.id}, 1)"
            class="px-2 bg-gray-200 rounded">+</button>

    <button onclick="removeItem(${item.id})"
            class="text-red-500 font-bold ml-4">X</button>

</div>

                    </div>
                </div>
            `;
        });

        document.getElementById("total-amount").innerText = total.toLocaleString();
        totalContainer.classList.remove("hidden");
        checkoutBtn.classList.remove("hidden");

    })
    .catch(() => {
        document.getElementById("cart-empty").classList.remove("hidden");
    });
}

function updateQuantity(itemId, change) {

    fetch(`/cart-update/${itemId}`, {
        method: 'PUT',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
        },
        body: JSON.stringify({ change: change })
    })
    .then(res => res.json())
    .then(() => loadCart());
}

function removeItem(itemId) {

    fetch(`/cart-remove/${itemId}`, {
        method: 'DELETE',
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
        }
    })
    .then(res => res.json())
    .then(() => loadCart());
}
</script>

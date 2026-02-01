@extends('layouts.app')

@section('title', 'Checkout')

@section('content')

<div class="max-w-xl mx-auto mt-10 bg-white shadow p-6 rounded-lg">

    <h1 class="text-3xl font-bold mb-6">🧾 Finaliser la commande</h1>

    <form id="checkoutForm" onsubmit="sendOrder(event)">

        <div class="mb-4">
            <label>Nom complet</label>
            <input id="name" type="text" class="border p-2 w-full" required>
        </div>

        <div class="mb-4">
            <label>Email</label>
            <input id="email" type="email" class="border p-2 w-full" required>
        </div>

        <div class="mb-4">
            <label>Téléphone</label>
            <input id="phone" type="text" class="border p-2 w-full" required>
        </div>

        <div class="mb-4">
            <label>Adresse</label>
            <textarea id="address" class="border p-2 w-full" required></textarea>
        </div>

        <button type="submit"
            class="bg-orange-500 text-white px-6 py-3 rounded w-full hover:bg-orange-600">
            Confirmer la commande
        </button>

    </form>

</div>

<script>
function sendOrder(event) {
    event.preventDefault();

    const fullName = document.getElementById("name").value.trim();
    const parts = fullName.split(" ");

    const orderData = {
        firstname: parts[0] ?? "",
        lastname: parts.slice(1).join(" ") ?? "",
        email: document.getElementById("email").value,
        phone: document.getElementById("phone").value,
        address: document.getElementById("address").value,
        cart: (JSON.parse(localStorage.getItem("cart")) || []).map(item => ({
            id: item.id,
            quantity: item.quantity,
            unit_price: item.price
        }))
    };

    if (orderData.cart.length === 0) {
        alert("Votre panier est vide");
        return;
    }

    fetch("/api/checkout", {
        method: "POST",
        headers: {
            "Content-Type": "application/json",
            "X-CSRF-TOKEN": document
                .querySelector('meta[name="csrf-token"]')
                ?.content
        },
        body: JSON.stringify(orderData)
    })
    .then(res => {
        if (!res.ok) throw new Error("Erreur serveur");
        return res.json();
    })

    .then((data) => {
    console.log("Commande OK :", data);

    // vider le panier
    localStorage.removeItem("cart");

    // ✅ REDIRECTION VISUELLE (OBLIGATOIRE)
    window.location.href = "/merci";
});

}
</script>


@endsection

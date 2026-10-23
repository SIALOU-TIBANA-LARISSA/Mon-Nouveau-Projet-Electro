@extends('layouts.app')

@section('title', 'Checkout')

@section('content')

<div class="max-w-3xl mx-auto mt-10 bg-white shadow p-6 rounded-lg">

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

     <div class="mb-4">
    <label>Pays / Région</label>
    <select id="country" class="border p-2 w-full" required>
        <option value="">Sélectionner un pays</option>
        <option value="Côte d'Ivoire">Côte d'Ivoire</option>
        <option value="Ghana">Ghana</option>
        <option value="Sénégal">Sénégal</option>
    </select>
</div>

<div class="mb-4">
    <label>Ville</label>
    <input id="city" type="text" class="border p-2 w-full" required>
</div>

<div class="mb-4">
    <label>Mode d'expédition</label>
    <select id="shipping_method" class="border p-2 w-full" required>
        <option value="Standard">Livraison Standard (48h)</option>
        <option value="Express">Livraison Express (24h)</option>
    </select>
</div>

<div class="mb-4">
    <label>Type de livraison</label>
    <select id="delivery_type" class="border p-2 w-full" required>
        <option value="Domicile">À domicile</option>
        <option value="Point relais">Point relais</option>
    </select>
</div>

        <button type="submit"
            class="bg-orange-500 text-white px-6 py-3 rounded w-full hover:bg-orange-600">
            Confirmer la commande
        </button>
    
    </form>

     <!-- Moyens de paiement (logos) -->
<div class="mt-6">
    <h4 class="font-semibold mb-3">Moyens de Paiement </h4>

    <div class="flex flex-wrap items-center gap-4">

        <img src="{{ asset('images/payments/Orange-Money-logo.jpg') }}"
             alt="Orange Money"
             class="h-8 object-contain">

        <img src="{{ asset('images/payments/MTN.jpg') }}"
             alt="MTN Money"
             class="h-8 object-contain">

        <img src="{{ asset('images/payments/Moov.png') }}"
             alt="Moov Money"
             class="h-8 object-contain">

        <img src="{{ asset('images/payments/Wave.jpg') }}"
             alt="Wave"
             class="h-12 object-contain">

        <img src="{{ asset('images/payments/MasterCard.jpg') }}"
            alt="MasterCard"
            class="h-8 object-contain transition hover:scale-110">

    </div>
</div>

</div>

<script>
async function sendOrder(event) {
    event.preventDefault();

    const fullName = document.getElementById("name").value.trim();
    const parts = fullName.split(" ");

    // 🔥 On récupère le panier depuis le backend
    const cartResponse = await fetch('/cart-data',
    {
    credentials: "include"
});
    const cartData = await cartResponse.json();

    if (!cartData || !cartData.items || cartData.items.length === 0) {
        alert("Votre panier est vide");
        return;
    }

    const orderData = {
        firstname: parts[0] ?? "",
        lastname: parts.slice(1).join(" ") ?? "",
        email: document.getElementById("email").value,
        phone: document.getElementById("phone").value,
        address: document.getElementById("address").value,
        country: document.getElementById("country").value,
        city: document.getElementById("city").value,
        shipping_method: document.getElementById("shipping_method").value,
        delivery_type: document.getElementById("delivery_type").value,
        cart: cartData.items
    };

    const response = await fetch("/checkout", {
        method: "POST",
        headers: {
            "Content-Type": "application/json",
            "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]')?.content
        },
        credentials: "include", // 🔥 IMPORTANT
        body: JSON.stringify(orderData)
    });

    if (!response.ok) {
    alert("Erreur serveur");
    return;
}

// 🔥 Vider panier en base
await fetch('/cart-clear', {
    method: 'DELETE',
    credentials: "include", // 🔥 IMPORTANT
    headers: {
        "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]')?.content
    }
});

window.location.href = "/merci";
}
</script>

@endsection

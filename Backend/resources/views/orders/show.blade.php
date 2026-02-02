@extends('layouts.app')

@section('content')
<div class="max-w-5xl mx-auto px-4 py-8">
    <h1 class="text-2xl font-bold mb-6">📦 Détails de la commande</h1>

    <div id="orderDetails">
        <p>Chargement de la commande...</p>
    </div>

    <a href="/my-orders" class="inline-block mt-6 text-orange-500 hover:underline">
        ← Retour à mes commandes
    </a>
</div>

<script>
document.addEventListener("DOMContentLoaded", async () => {
    const token = localStorage.getItem("auth_token");
    if (!token) {
        window.location.href = "/login";
        return;
    }

    const orderId = window.location.pathname.split('/').pop();
    const container = document.getElementById("orderDetails");

    try {
        const res = await fetch(`/api/orders/${orderId}`, {
            headers: {
                "Authorization": "Bearer " + token,
                "Accept": "application/json"
            }
        });

        if (!res.ok) {
            throw new Error("Commande introuvable");
        }

        const order = await res.json();

        container.innerHTML = `
            <div class="bg-white border rounded-lg p-6 mb-4">
                <p><strong>Commande :</strong> #${order.id}</p>
                <p><strong>Date :</strong> ${order.created_at.substring(0,10)}</p>
                <p><strong>Total :</strong> 
                    <span class="text-orange-500 font-bold">
                        ${order.total_amount} FCFA
                    </span>
                </p>
                <p><strong>Statut :</strong> ${order.status}</p>
            </div>

            <h2 class="text-xl font-semibold mb-3">🛍 Produits commandés</h2>

            ${order.items.map(item => `
                <div class="flex gap-4 items-center bg-gray-50 p-4 rounded mb-3">
                    <img src="${item.product.main_image_url}"
                         class="w-20 h-20 object-cover rounded">
                    <div>
                        <p class="font-semibold">${item.product.name}</p>
                        <p>Quantité : ${item.quantity}</p>
                        <p>Prix : ${item.price} FCFA</p>
                    </div>
                </div>
            `).join('')}
        `;
    } catch (e) {
        container.innerHTML = `
            <p class="text-red-500">
                Impossible d’afficher cette commande.
            </p>
        `;
    }
});
</script>
@endsection

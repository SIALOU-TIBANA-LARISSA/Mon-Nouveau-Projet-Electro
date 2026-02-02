@extends('layouts.app')

@section('content')
<div class="max-w-5xl mx-auto px-4 py-8">

    <h1 class="text-2xl font-bold mb-6">📦 Détails de la commande</h1>

    <div id="orderDetails" class="space-y-4">
        <p class="text-gray-500">Chargement des détails...</p>
    </div>

    <a href="/my-orders"
       class="inline-block mt-6 text-orange-500 hover:underline">
        ← Retour à mes commandes
    </a>

</div>

<script>
document.addEventListener("DOMContentLoaded", async () => {

    // 🔐 Token API
    const token = localStorage.getItem("auth_token");
    if (!token) {
        window.location.href = "/login";
        return;
    }

    // 🔑 ID commande depuis l'URL
    const params = new URLSearchParams(window.location.search);
    const orderId = params.get("id");

    const container = document.getElementById("orderDetails");

    if (!orderId) {
        container.innerHTML =
            "<p class='text-red-500'>Commande introuvable.</p>";
        return;
    }

    try {
        const response = await fetch(`/api/orders/${orderId}`, {
            headers: {
                "Authorization": "Bearer " + token,
                "Accept": "application/json"
            }
        });

        if (!response.ok) {
            throw new Error("Erreur API");
        }

        const order = await response.json();

        let html = `
            <div class="bg-white border rounded-lg p-6">
                <p><strong>Commande :</strong> #${order.id}</p>
                <p><strong>Date :</strong> ${order.created_at.substring(0, 10)}</p>
                <p>
                    <strong>Total :</strong>
                    <span class="text-orange-500 font-bold">
                        ${order.total_amount} FCFA
                    </span>
                </p>
                <p><strong>Statut :</strong> ${order.status}</p>
            </div>

            <h2 class="text-xl font-semibold mt-6 mb-4">
                🛍 Produits commandés
            </h2>
        `;

        if (!order.items || order.items.length === 0) {
            html += "<p class='text-gray-500'>Aucun produit trouvé.</p>";
        } else {
            order.items.forEach(item => {
                html += `
                    <div class="flex gap-4 items-center bg-gray-50 p-4 rounded">
                        <img
                            src="${item.product.main_image_url}"
                            class="w-20 h-20 object-cover rounded"
                            alt="${item.product.name}"
                        >

                        <div>
                            <p class="font-semibold">${item.product.name}</p>
                            <p>Quantité : ${item.quantity}</p>
                            <p>Prix : ${item.price} FCFA</p>
                        </div>
                    </div>
                `;
            });
        }

        container.innerHTML = html;

    } catch (error) {
        container.innerHTML =
            "<p class='text-red-500'>Impossible de charger les détails de la commande.</p>";
        console.error(error);
    }
});
</script>
@endsection

@extends('layouts.app')

@section('content')
<div class="max-w-5xl mx-auto px-4">
    <h1 class="text-2xl font-bold mb-6">📦 Vos commandes</h1>

    <div id="ordersContainer"></div>
</div>

<script>
document.addEventListener("DOMContentLoaded", async () => {
    const token = localStorage.getItem("auth_token");
    if (!token) {
        window.location.href = "/login";
        return;
    }

    const res = await fetch("/api/orders", {
        headers: {
            "Authorization": "Bearer " + token,
            "Accept": "application/json"
        }
    });

    const orders = await res.json();
    const container = document.getElementById("ordersContainer");

    if (!orders.length) {
        container.innerHTML = "<p>Aucune commande.</p>";
        return;
    }

    orders.forEach(order => {
        container.innerHTML += `
            <div class="bg-white shadow rounded p-5 mb-4">
                <h2 class="font-bold">Commande #${order.id}</h2>
                <p>${order.created_at.substring(0,10)}</p>
                <p class="font-bold text-orange-500">${order.total_amount} FCFA</p>
                <span>${order.status}</span>

                <div class="mt-3">
                    <a href="{{ route('orders.show', $order->id) }}"
   class="inline-block bg-orange-500 text-white px-4 py-2 rounded hover:bg-orange-600">
    Voir les détails
</a>

                </div>
            </div>
        `;
    });
});
</script>
@endsection

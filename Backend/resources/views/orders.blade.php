@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto px-4 py-8">

    <h1 class="text-2xl font-bold mb-6">📦 Vos commandes</h1>

    <div id="ordersContainer" class="space-y-4">
        <p class="text-gray-500">Chargement de vos commandes...</p>
    </div>

</div>

<script>
document.addEventListener("DOMContentLoaded", async () => {
    const container = document.getElementById("ordersContainer");
    const token = localStorage.getItem("auth_token");

    if (!token) {
        window.location.href = "/login";
        return;
    }

    try {
        const response = await fetch("/api/orders", {
            headers: {
                "Authorization": "Bearer " + token,
                "Accept": "application/json"
            }
        });

        const orders = await response.json();
        container.innerHTML = "";

        if (!orders || orders.length === 0) {
            container.innerHTML = `
                <div class="bg-white p-6 rounded shadow text-gray-600">
                    Vous n’avez encore passé aucune commande.
                </div>
            `;
            return;
        }

        orders.forEach(order => {
            container.innerHTML += `
                <div class="bg-white p-6 rounded shadow flex justify-between items-center">
                    <div>
                        <p class="font-semibold">Commande #${order.id}</p>
                        <p class="text-sm text-gray-500">
                            ${new Date(order.created_at).toLocaleDateString()}
                        </p>
                    </div>

                    <div class="text-right">
                        <p class="font-bold text-orange-500">
                            ${Number(order.total_amount).toLocaleString()} FCFA
                        </p>
                        <span class="text-sm px-3 py-1 rounded bg-gray-100">
                            ${order.status ?? 'En cours'}
                        </span>
                    </div>
                </div>
            `;
        });

    } catch (e) {
        container.innerHTML = `
            <div class="bg-red-50 text-red-600 p-4 rounded">
                Impossible de charger les commandes.
            </div>
        `;
    }
});
</script>
@endsection


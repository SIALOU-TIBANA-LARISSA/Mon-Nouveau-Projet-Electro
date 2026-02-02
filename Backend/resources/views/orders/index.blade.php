@extends('layouts.app')

@section('content')
<div class="max-w-5xl mx-auto px-4">
    <h1 class="text-2xl font-bold mb-6">📦 Vos commandes</h1>

    <div id="ordersContainer">
        <p>Chargement des commandes...</p>
    </div>
</div>

<script>
document.addEventListener("DOMContentLoaded", async () => {
    const token = localStorage.getItem("auth_token");

    if (!token) {
        window.location.href = "/login";
        return;
    }

    try {
        const res = await fetch("/api/orders", {
            headers: {
                "Authorization": "Bearer " + token,
                "Accept": "application/json"
            }
        });

        const orders = await res.json();
        const container = document.getElementById("ordersContainer");
        container.innerHTML = "";

        if (!orders.length) {
    container.innerHTML = `
        <div class="bg-white border rounded-lg p-8 text-center">
            <p class="text-gray-600 mb-4">
                Vous n’avez encore passé aucune commande.
            </p>

            <a href="/catalogue"
               class="inline-block bg-orange-500 text-white px-6 py-2 rounded hover:bg-orange-600">
                Découvrir nos produits
            </a>
        </div>
    `;
    return;
}


        orders.forEach(order => {
            container.innerHTML += `
                <div class="bg-white shadow rounded p-5 mb-4">
                    <h2 class="font-bold">Commande #${order.id}</h2>
                    <p>${order.created_at.substring(0,10)}</p>
                    <p class="font-bold text-orange-500">${order.total_amount} FCFA</p>
                    <span class="inline-block px-3 py-1 rounded-full text-sm font-semibold ${
                     order.status === 'pending' ? 'bg-yellow-100 text-yellow-800' :
                     order.status === 'paid' ? 'bg-blue-100 text-blue-800' :
                     order.status === 'processing' ? 'bg-purple-100 text-purple-800' :
                     order.status === 'completed' ? 'bg-green-100 text-green-800' :
                     order.status === 'cancelled' ? 'bg-red-100 text-red-800' :
                     'bg-gray-100 text-gray-800'
                    }">
                     ${order.status}
                    </span>
                    <div class="mt-3">
                     <a href="/order-detail?id=${order.id}"
                       class="text-orange-500 font-medium hover:underline">
                        Voir les détails →
                     </a>

                    </div>

                </div>
            `;
        });
    } catch (e) {
        document.getElementById("ordersContainer").innerHTML =
            "<p class='text-red-500'>Erreur lors du chargement des commandes.</p>";
    }
});
</script>
@endsection

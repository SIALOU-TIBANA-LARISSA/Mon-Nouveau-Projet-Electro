@extends('layouts.app')

@section('content')
<div class="max-w-5xl mx-auto px-4 py-8">
    <h1 class="text-2xl font-bold mb-6">📍 Mes adresses</h1>

    <div id="addressContainer">
        <p>Chargement des adresses...</p>
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
        const res = await fetch("/api/addresses", {
            headers: {
                "Authorization": "Bearer " + token,
                "Accept": "application/json"
            }
        });

        const data = await res.json();
        const container = document.getElementById("addressContainer");
        container.innerHTML = "";

        if (!data || data.length === 0) {
            container.innerHTML = `
                <div class="bg-white border rounded-lg p-6 text-center">
                    <p class="text-gray-600 mb-4">
                        Aucune adresse enregistrée.
                    </p>

                    <a href="#" class="inline-block bg-orange-500 text-white px-6 py-2 rounded hover:bg-orange-600">
                        Ajouter une adresse
                    </a>
                </div>
            `;
            return;
        }

        data.forEach(address => {
            container.innerHTML += `
                <div class="bg-white border rounded-lg p-6 mb-4">
                    <p class="font-semibold">${address.full_name}</p>
                    <p>${address.street}</p>
                    <p>${address.city}</p>
                    <p>${address.phone}</p>

                    <div class="mt-4">
                        <a href="#" class="text-orange-500 hover:underline">
                            ✏️ Modifier
                        </a>
                    </div>
                </div>
            `;
        });

    } catch (e) {
        document.getElementById("addressContainer").innerHTML =
            "<p class='text-red-500'>Erreur lors du chargement des adresses.</p>";
    }
});
</script>
@endsection


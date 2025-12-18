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
        class="bg-indigo-600 text-white px-6 py-3 rounded">
        Confirmer la commande
    </button>

</form>

<script src="/js/cart.js"></script>

document.addEventListener("DOMContentLoaded", () => {
    const input = document.getElementById("searchInput");
    const container = document.getElementById("productsContainer");

    if (!input || !container) return;

    let timeout = null;

    input.addEventListener("keyup", () => {
        clearTimeout(timeout);

        timeout = setTimeout(() => {
            const query = input.value;

            fetch(`http://127.0.0.1:8001/api/products?q=${encodeURIComponent(query)}`)
                .then(res => res.json())
                .then(products => {
                    container.innerHTML = "";

                    if (products.length === 0) {
                        container.innerHTML = "<p class='text-gray-500'>Aucun produit trouvé</p>";
                        return;
                    }

                    products.forEach(product => {
                        container.innerHTML += `
                            <div class="bg-white shadow rounded-lg overflow-hidden">
                                <img src="${product.image ?? 'https://via.placeholder.com/300x200'}"
                                     class="w-full h-40 object-cover">

                                <div class="p-4">
                                    <h2 class="font-semibold">${product.name}</h2>
                                    <p class="text-gray-500 text-sm">
                                        ${(product.description ?? '').substring(0, 60)}...
                                    </p>
                                    <div class="mt-2 font-bold text-orange-500">
                                        ${Number(product.price).toLocaleString()} FCFA
                                    </div>
                                </div>
                            </div>
                        `;
                    });
                });
        }, 300); // anti-spam (debounce)
    });
});

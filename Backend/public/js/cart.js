document.addEventListener("click", function (e) {

    const btn = e.target.closest(".add-to-cart");
    if (!btn) return;

    fetch('/cart-add', {
        method: 'POST',
        credentials: 'include',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document
                .querySelector('meta[name="csrf-token"]')
                .content
        },
        body: JSON.stringify({
            product_id: btn.dataset.id,
            quantity: 1
        })
    })
    .then(res => res.json())
    .then(() => {

        // MESSAGE VERT
        if (typeof showCartMessage === "function") {
            showCartMessage();
        }

        // MISE À JOUR BADGE
        return fetch('/cart-data');
    })
    .then(res => res.json())
    .then(data => {

        let total = 0;

        if (data.items) {
            data.items.forEach(item => {
                total += item.quantity;
            });
        }

        const badge = document.getElementById('cart-badge');
const mobileBadge = document.getElementById('mobile-cart-badge');

if (badge) {
    badge.innerText = total;
    badge.style.display = total > 0 ? 'inline-block' : 'none';
}

if (mobileBadge) {
    mobileBadge.innerText = total;
    mobileBadge.style.display = total > 0 ? 'inline-block' : 'none';
}

    })
    .catch(err => console.error("ERREUR JS :", err));

});
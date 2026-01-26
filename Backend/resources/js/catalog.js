fetch('/api/products')
  .then(response => response.json())
  .then(products => {
    console.log(products);

    const container = document.getElementById('products-container');

    if (!container) return;

    if (products.length === 0) {
      container.innerHTML = '<p>Aucun produit disponible</p>';
      return;
    }

    let html = '';
    products.forEach(product => {
      html += `
        <div class="product">
          <h3>${product.name}</h3>
          <p>${product.price} FCFA</p>
        </div>
      `;
    });

    container.innerHTML = html;
  })
  .catch(error => {
    console.error('Erreur chargement produits:', error);
  });

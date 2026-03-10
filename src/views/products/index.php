<script>
  const minPriceInput = document.getElementById('min-price');
  const maxPriceInput = document.getElementById('max-price');
  const listProducts = document.getElementById('list-products');

  // Función para actualizar la URL sin recargar la página
  function updateUrl() {
    const url = new URL(window.location.href);
    const minPrice = minPriceInput.value;
    const maxPrice = maxPriceInput.value;

    if (minPrice) {
      url.searchParams.set('min_price', minPrice);
    } else {
      url.searchParams.delete('min_price');
    }

    if (maxPrice) {
      url.searchParams.set('max_price', maxPrice);
    } else {
      url.searchParams.delete('max_price');
    }

    window.history.replaceState(null, '', url.toString());
  }

  // Inicializar valores de los inputs desde la URL
  const searchParams = new URLSearchParams(window.location.search);
  minPriceInput.value = searchParams.get('min_price') || '';
  maxPriceInput.value = searchParams.get('max_price') || '';

  async function onFocusInputOut(event) {
    updateUrl(); // Actualizamos la URL primero
    const baseUrl = new URL(window.location.href);
    try {
      const json = await fetch(`/api/products?${baseUrl.searchParams.toString()}`).then(res => {
        console.log('response:', res);
        return res.json();
      });
      listProducts.innerHTML = ''; // Limpiar la lista actual
      json.forEach(item => {
        const card = document.createElement('div');
        card.classList.add('card');
        card.innerHTML = `
            <img src="${item.image_url || '/placeholder.jpg'}" alt="${item.name}">
            <h3>${item.name}</h3>
            <p>${item.description}</p>
            <p>$${item.price}</p>
          `;
        // BUG FIX: El append debe estar DENTRO del loop
        listProducts.appendChild(card);
      });
    } catch (e) {
      console.error('Error fetching products:', e);
    }
  }

  // Añadir listeners
  minPriceInput.addEventListener('change', updateUrl);
  maxPriceInput.addEventListener('change', updateUrl);
  minPriceInput.addEventListener('focusout', onFocusInputOut);
  maxPriceInput.addEventListener('focusout', onFocusInputOut);
</script>


<style>
  .list-products {
    height: 100%;
    padding-block: 1rem;
    display: flex;
    flex-wrap: wrap;
    gap: 1rem;
  }
</style>

<div class="list-products" id="list-products">
  <?php

  use App\Controllers\ProductController;

  $productsController = new ProductController($conn);
  $products = [];

  if (isset($_GET['category']))
    $products = $productsController->getProductsByCategory($_GET['category']);
  elseif (isset($_GET['search']))
    $products = $productsController->getProductsBySearch($_GET['search']);
  else
    $products = $productsController->getAllProducts(0, 30);

  foreach ($products as $item): ?>
    <?php include __DIR__ . '/../components/Card.php' ?>
  <?php endforeach; ?>
</div>
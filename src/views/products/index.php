<script>
  const minPriceInput = document.getElementById('min-price');
  const maxPriceInput = document.getElementById('max-price');

  minPriceInput.value = new URLSearchParams(window.location.search).get('min_price') || '';
  maxPriceInput.value = new URLSearchParams(window.location.search).get('max_price') || '';

  minPriceInput.addEventListener('change', () => {
    const minPrice = minPriceInput.value;
    const maxPrice = maxPriceInput.value;
    let url = new URL(window.location.href);
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
  });

  maxPriceInput.addEventListener('change', () => {
    const minPrice = minPriceInput.value;
    const maxPrice = maxPriceInput.value;
    let url = new URL(window.location.href);
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
  });

  async function onFocusInputOut(event) {
    console.log('focus out', event.target.id);
    const baseUrl = new URL(window.location.href);
    try {
      const json = await fetch(`/api/products?${baseUrl.searchParams.toString()}`).then(res => {
        console.log('response:', res);
        return res.json();
      });
      const listProducts = document.getElementById('list-products');
      listProducts.innerHTML = '';
      json.forEach(item => {
        const card = document.createElement('div');
        card.classList.add('card');
        card.innerHTML = `
            <img src="${item.image_url}" alt="${item.name}">
            <h3>${item.name}</h3>
            <p>${item.description}</p>
            <p>$${item.price}</p>
          `;
      });
      listProducts.appendChild(card);
    } catch (e) {
      console.error('Error fetching products:', e);
    }
  }

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
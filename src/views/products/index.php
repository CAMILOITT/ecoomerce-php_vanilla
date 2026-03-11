<style>
  .list-products {
    height: 100%;
    padding-block: 1rem;
    display: flex;
    flex-wrap: wrap;
    gap: clamp(.5rem, 1vw, 1rem) clamp(.2rem, 1vw, 1rem);
  }

  .card {
    background: var(--color-card-bg);
    border-radius: var(--border-xl);
    padding: clamp(.5rem, 1vw, 1rem);
    width: clamp(150px, 15vw, 240px);
    aspect-ratio: 5/7;
    position: relative;
    display: flex;
    flex-direction: column;
    justify-content: space-between;
    box-shadow: var(--shadow-soft);
    transition: all 0.3s ease;
    cursor: pointer;

    &:hover {
      transform: translateY(-5px);
      box-shadow: var(--shadow-hover);
    }
  }

  .card-link {
    display: flex;
    flex-direction: column;
    height: 100%;
    color: inherit;
  }

  .img-container {
    position: relative;
    border-radius: var(--border-l);
    width: 100%;
    aspect-ratio: 1/1;
    display: flex;
    align-items: center;
    justify-content: center;
    margin-bottom: 12px;
    padding: 1rem;
  }

  .card:nth-child(4n+1) .img-container {
    background: var(--color-pastel-orange);
  }

  .card:nth-child(4n+2) .img-container {
    background: var(--color-pastel-red);
  }

  .card:nth-child(4n+3) .img-container {
    background: var(--color-pastel-green);
  }

  .card:nth-child(4n+4) .img-container {
    background: var(--color-pastel-purple);
  }

  .card-img {
    width: 100%;
    height: 100%;
    object-fit: contain;
    filter: drop-shadow(0 10px 15px rgba(0, 0, 0, 0.1));
    transform: scale(1.1);
    transition: transform 0.3s ease;
  }

  .card:hover .card-img {
    transform: scale(1.15);
  }

  .item-discount {
    position: absolute;
    top: 12px;
    left: 12px;
    background: rgba(255, 255, 255, 0.9);
    color: var(--color-text);
    font-size: 0.75rem;
    font-weight: 700;
    padding: 4px 8px;
    border-radius: var(--pill);
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.05);
    z-index: 1;
  }

  .card-info {
    text-align: center;
    margin-bottom: auto;
  }

  .item-name {
    font-weight: 700;
    font-size: 1.1rem;
    color: var(--color-text);
    margin-bottom: 4px;
  }

  .item-description {
    font-size: 0.85rem;
    color: var(--color-text-muted);
    display: block;
    margin-bottom: 8px;
  }

  .card-footer {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-top: auto;
    padding-top: 10px;
  }

  .item-price {
    font-weight: 700;
    font-size: 1.2rem;
    color: var(--color-text);
  }

  .item-action-btn {
    background: white;
    border: 1px solid #EAEAEA;
    width: 32px;
    height: 32px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    color: var(--color-text);
    font-weight: bold;
    transition: all 0.2s ease;
    cursor: pointer;
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.02);
    padding: 0;

    &:hover {
      background: var(--color-primary);
      color: white;
      border-color: var(--color-primary);
    }
  }

  @media (width <=768px) {
    .item-price {
      font-size: 1rem;
    }

    .item-action-btn {
      width: 28px;
      height: 28px;
    }
  }
</style>

<div class="list-products" id="list-products">
  <?php

  use App\Controllers\ProductController;

  $productsController = new ProductController($conn);
  $products = [];

  if (isset($_GET['category']))
    $products = $productsController->getByCategory($_GET['category']);
  elseif (isset($_GET['search']))
    $products = $productsController->getBySearch($_GET['search']);
  else
    $products = $productsController->getAll(0, 30);

  foreach ($products as $item): ?>
    <?php include __DIR__ . '/../components/Card.php' ?>
  <?php endforeach; ?>
</div>

<script>
  const minPriceInput = document.querySelector("#min-price")
  const maxPriceInput = document.querySelector("#max-price")
  const listProducts = document.querySelector("#list-products")

  function updateUrl() {
    const url = new URL(window.location.href)
    const minPrice = minPriceInput.value
    let maxPrice = maxPriceInput.value

    if (maxPriceInput.value < minPrice) {
      maxPrice = minPrice + 1
      maxPrice.value = maxPrice
    }

    if (minPrice) url.searchParams.set("min_price", minPrice)
    else url.searchParams.delete("min_price")

    if (maxPrice) url.searchParams.set("max_price", maxPrice)
    else url.searchParams.delete("max_price")

    window.history.replaceState(null, "", url.toString())
  }

  const searchParams = new URLSearchParams(window.location.search)
  minPriceInput.value = searchParams.get("min_price") || ""
  maxPriceInput.value = searchParams.get("max_price") || ""

  async function onFocusInputOut(event) {
    updateUrl()
    const baseUrl = new URL(window.location.href)
    try {
      const json = await fetch(
        `/api/v1/products?${baseUrl.searchParams.toString()}`,
      ).then(res => res.json())
      console.log(json)

      listProducts.innerHTML = ""
      json.forEach(item => {
        const card = document.createElement("div")
        card.classList.add("card")
        card.innerHTML = `
        <a href="/products/${item.id}>" class="card-link">
          <div class="img-container">
            <img src="${item.image_url || "/placeholder.jpg"}" alt="${item.name}" class="card-img">
          </div>
          <div class="card-info">
            <p class="item-name">${item.name}</p>
            <span class="item-description">${item.description}</span>
          </div>
        </a>
        <div class="card-footer">
          <span class="item-price">$${item.unit_price}</span>
          <button class="item-action-btn" aria-label="Add to cart">
            <?php include 'assets/svg/icons/more.svg' ?>
          </button>
        </div>
      `
        listProducts.appendChild(card)
      })
    } catch (e) {
      console.error("Error fetching products:", e)
    }
  }

  minPriceInput.addEventListener("change", updateUrl)
  maxPriceInput.addEventListener("change", updateUrl)
  minPriceInput.addEventListener("focusout", onFocusInputOut)
  maxPriceInput.addEventListener("focusout", onFocusInputOut)
</script>
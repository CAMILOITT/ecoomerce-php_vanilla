<?php

declare(strict_types=1);

use App\Controllers\ShoppingCart;
use App\Model\ProductModel;

$productId = (int) array_pop(explode('/', $_SERVER['REQUEST_URI'])) ?? 0;
$product = (new ProductModel($conn))->getById($productId);
$quantity = (new ShoppingCart($conn));
?>

<style>
  main {
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    gap: 2rem;
    padding: 3rem clamp(.1rem, 1vw, 2rem);
  }

  .product {
    display: flex;
    flex-wrap: wrap;
    gap: 2rem;
    background: var(--color-card-bg);
    padding: clamp(1rem, 3vw, 2rem) clamp(1rem, 2vw, 2rem);
    margin: clamp(1rem, 2vw, 2rem);
    border-radius: var(--border-xl);
    box-shadow: var(--shadow-soft);

    .product-info {
      display: flex;
      flex-direction: column;
      justify-content: space-between;
      gap: .5lh;
    }
  }
</style>

<main>
  <div class="product">
    <img src="<?= $product['image_url'] ?>" alt="imagen del producto <?= $product['name'] ?>" class="product-img">
    <div class="product-info">
      <h3 class=""><?= $product['name'] ?></h3>
      <p class=""><?= $product['description'] ?></p>
      <p class="">$ <?= $product['unit_price'] ?></p>
      <div class="">
        <?= $product['name'] ?>....
      </div>
    </div>
  </div>
  <?php include __DIR__ . '/../../components/GridCardsRandoms.php' ?>

</main>
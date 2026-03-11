<?php

declare(strict_types=1);

use App\Model\ProductModel;

$productsController = new ProductModel($conn);
$products = $productsController->getRandom(10);
?>

<style>
  .products-carousel {
    display: flex;
    flex-wrap: wrap;
    align-items: center;
    justify-content: center;
    gap: 1.5rem;
    margin: 1rem 0.5rem 2rem;

    &::-webkit-scrollbar {
      display: none;
    }

    &>* {
      scroll-snap-align: start;
    }
  }

  @media (width <=375px) {
    .products-carousel {
      gap: .25rem;
    }
  }
</style>

<div class="products-carousel">
  <?php foreach ($products as $item): ?>
    <?php include __DIR__ . '/Card.php' ?>
  <?php endforeach; ?>
</div>
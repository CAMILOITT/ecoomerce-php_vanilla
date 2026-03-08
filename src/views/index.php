<style>
  .products-section {
    padding: 1rem 0 3rem 0;
  }
  
  .products-carousel {
    display: flex;
    gap: 1.5rem;
    align-items: stretch;
    overflow-x: auto;
    padding: 1rem 0.5rem 2rem 0.5rem;
    scroll-snap-type: x mandatory;
    scroll-behavior: smooth;
    -ms-overflow-style: none;
    scrollbar-width: none;
  }
  
  .products-carousel::-webkit-scrollbar {
    display: none;
  }
  
  .products-carousel > * {
      scroll-snap-align: start;
  }
</style>

<main>
  <?php include_once __DIR__ . '/components/Banner.php' ?>
  
  <section class="products-section">
    <div class="products-carousel">
      <?php

      use App\Controllers\ProductController;

      $productsController = new ProductController($conn);
      $products = $productsController->getRandomProducts(10);
      foreach ($products as $item): ?>
        <?php include __DIR__ . '/components/Card.php' ?>
      <?php endforeach; ?>
    </div>
  </section>
</main>
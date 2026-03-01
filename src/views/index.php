<main>
  <?php include_once __DIR__ . '/components/Banner.php' ?>
  <section>
    <div style="display: flex; gap: .8rem; align-items: center; overflow-y: scroll;">
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
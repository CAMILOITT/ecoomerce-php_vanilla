<style>
  .products-section {
    padding: 1rem 0;
  }

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

  /* main {
    border-radius: var(--border-xl);
    background: linear-gradient(180deg, var(--color-primary), transparent);

    margin: 1rem .5rem;
  } */
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
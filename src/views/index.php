<style>
  .products-section {
    padding: 1rem 0;
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
    <?php include __DIR__ . '/components/GridCardsRandoms.php' ?>
  </section>
</main>
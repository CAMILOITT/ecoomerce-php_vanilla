<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="/global.css">
  <title>Inicio - minimarket</title>
</head>

<style>
  body {
    display: flex;
    flex-direction: column;
    min-height: 100vh;

  }
</style>

<body>
  <?php include_once __DIR__ . '/components/Header.php' ?>
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
  <?php include_once __DIR__ . '/components/Footer.php' ?>
</body>

</html>
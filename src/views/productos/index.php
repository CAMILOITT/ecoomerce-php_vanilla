<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>lista de productos</title>
  <link rel="stylesheet" href="/global.css">
</head>

<style>
  main {
    display: flex;
    gap: 1rem;

    .list-products {
      display: grid;
      grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
      gap: 1rem;
      overflow-y: scroll;
      width: 100%;
    }
  }
</style>

<body>
  <?php include_once __DIR__ . '/../components/Header.php' ?>
  <main>
    <?php include_once __DIR__ . '/components/Filtro.php' ?>
    <div class="list-products">
      <?php

      use App\Controllers\ProductController;

      $productsController = new ProductController($conn);
      $products = $productsController->getAllProducts(0, 30);
      foreach ($products as $item):  ?>
        <?php include __DIR__ . '/../components/Card.php' ?>
      <?php endforeach; ?>
    </div>
  </main>
  <?php include_once __DIR__ . '/../components/Footer.php' ?>
</body>

</html>
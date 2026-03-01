<?php

use App\Controllers\ProductController;

$products = (new ProductController($conn))->getAllProducts(0, 10);
?>

<main>
  <h1>Productos</h1>
  <a href="/admin/products/create" class="btn">Crear nuevo producto</a>
  <div class="product-list">

    <?php $data = $products;
    include __DIR__ . '/../components/tableModified.php' ?>

  </div>
</main>
<?php

use App\Controllers\ProductController;

$products = (new ProductController($conn))->getAllProducts(0, 10);
$titleHeader = "Productos";
$descriptionHeader = "Administra los productos de tu tienda. Agrega, edita o elimina productos para mantener tu catálogo actualizado.";
?>

<main>
  <?php include __DIR__ . '/../components/header.php'; ?>
  <div class="product-list">

    <?php $data = $products;
    include __DIR__ . '/../components/tableModified.php' ?>

  </div>
</main>
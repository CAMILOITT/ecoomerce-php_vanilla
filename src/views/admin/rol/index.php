<?php

use App\Controllers\ProductController;

$products = (new ProductController($conn))->getAllProducts(0, 10);
$titleHeader = "Roles";
$descriptionHeader = "Administra los roles de tu tienda. Agrega, edita o elimina roles para gestionar los permisos de los usuarios.";
?>

<main>
  <?php include __DIR__ . '/../components/header.php'; ?>
  <div class="product-list">
    <?php $data = $products;
    include __DIR__ . '/../components/tableModified.php' ?>
  </div>
</main>
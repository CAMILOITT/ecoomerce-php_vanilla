<?php

use App\Model\ProductModel;

$products = (new ProductModel($conn))->getAll(0, 10);
$titleHeader = "Productos";
$descriptionHeader = "Administra los productos de tu tienda. Agrega, edita o elimina productos para mantener tu catálogo actualizado.";
?>

<?php include __DIR__ . '/../components/header.php'; ?>
<div class="product-list">

  <?php $data = $products;
  include __DIR__ . '/../components/tableModified.php' ?>
</div>
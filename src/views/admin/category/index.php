<?php

use App\Controllers\CategoryController;

$products = (new CategoryController($conn))->getAll(0, 10);
$titleHeader = "Categorías";
$descriptionHeader = "Administra las categorías de tu tienda. Agrega, edita o elimina categorías para organizar tus productos de manera efectiva.";

?>

<?php include __DIR__ . '/../components/header.php'; ?>
<div class="product-list">
  <?php $data = $products;
  include __DIR__ . '/../components/tableModified.php' ?>
</div>
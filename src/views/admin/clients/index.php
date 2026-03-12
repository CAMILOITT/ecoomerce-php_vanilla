<?php

use App\Model\ProductModel;

$products = (new ProductModel($conn))->getAll(0, 10);
$titleHeader = "Clientes";
$descriptionHeader = "Administra los clientes de tu tienda. Agrega, edita o elimina clientes para mantener un registro preciso de tu base de datos.";
?>

<?php include __DIR__ . '/../components/header.php'; ?>
<div class="product-list">
  <?php $data = $products;
  include __DIR__ . '/../components/tableModified.php' ?>
</div>
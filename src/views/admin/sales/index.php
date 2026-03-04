<?php

use App\Controllers\SalesController;

$orders = (new SalesController($conn))->getAll(0, 10);
$titleHeader = "Ventas";
$descriptionHeader = "Administra las ventas de tu tienda. Agrega, edita o elimina ventas para mantener un registro preciso de las transacciones.";
?>

<main>
  <?php include __DIR__ . '/../components/header.php'; ?>

  <div class="product-list">

    <?php $data = $orders;
    include __DIR__ . '/../components/tableModified.php' ?>

  </div>
</main>
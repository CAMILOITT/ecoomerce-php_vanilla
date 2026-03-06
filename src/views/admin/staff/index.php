<?php

use App\Controllers\StaffController;

$staff = (new StaffController($conn))->getAll(0, 10);
$titleHeader = "Personal";
$descriptionHeader = "Administra el personal de tu tienda. Agrega, edita o elimina empleados para mantener un equipo eficiente.";
?>

<?php include __DIR__ . '/../components/header.php'; ?>
<div class="product-list">
  <?php $data = $staff;
  include __DIR__ . '/../components/tableModified.php' ?>
</div>
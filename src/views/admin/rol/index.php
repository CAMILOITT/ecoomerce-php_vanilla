<?php

use App\Controllers\RolController;

$roles = (new RolController($conn))->getAll(0, 10);
$titleHeader = "Roles";
$descriptionHeader = "Administra los roles de tu tienda. Agrega, edita o elimina roles para gestionar los permisos de los usuarios.";
?>

<?php include __DIR__ . '/../components/header.php'; ?>
<div class="product-list">
  <?php $data = $roles;
  include __DIR__ . '/../components/tableModified.php' ?>
</div>
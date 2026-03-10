<?php

declare(strict_types=1);

use App\Controllers\CustomerController;

if (!$_SESSION['id']) {
  header('Location: /session');
  exit();
}

$customerController = new CustomerController($conn);
$user = $customerController->getInformation($_SESSION['id']);
$history = $customerController->getPurchaseHistoryByCustomerId($_SESSION['id']);
?>

<style>
  main {
    display: flex;
    flex-direction: column;
    align-items: center;
    padding: 1rem;
    gap: 1rem;
  }
</style>

<main>
  <?php include_once __DIR__ . '/components/Profile.php' ?>
  <?php include_once __DIR__ . '/components/TableHistory.php' ?>
</main>
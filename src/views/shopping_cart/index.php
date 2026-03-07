<?php

declare(strict_types=1);

use App\Controllers\ShoppingCart;

// session_start();

$_SESSION['customer_id'] = 1;

$products = (new ShoppingCart($conn))->getAllProductsByCustomerId($_SESSION['customer_id']);
?>

<style>
  .shopping-cart {
    display: flex;
    flex-direction: column;
    gap: 1rem;
    width: 100%;
    justify-content: center;
    align-items: center;
  }
</style>

<h1>Carrito de Compras</h1>
<div class="shopping-cart">
  <?php if (count($products) > 0): ?>
    <?php foreach ($products as $product): ?>
      <?php include_once __DIR__ . '/components/itemShop.php'; ?>
    <?php endforeach; ?>
  <?php else: ?>
    <p>Bienvenido a tu carrito de compras</p>
  <?php endif; ?>
</div>
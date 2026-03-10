<?php

declare(strict_types=1);

use App\Controllers\ShoppingCart;

if (isset($_SESSION['customer_id']))
  $products = (new ShoppingCart($conn))->getAllProductsByCustomerId($_SESSION['customer_id']);

?>

<style>
  h1 {
    margin: 2rem 1rem 3rem;
  }

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

<?php if (isset($_SESSION['customer_id'])): ?>
  <div class="shopping-cart">
    <?php if (count($products) > 0): ?>
      <?php foreach ($products as $product): ?>
        <?php include_once __DIR__ . '/components/itemShop.php'; ?>
      <?php endforeach; ?>
    <?php else: ?>
      <p>Bienvenido a tu carrito de compras</p>
    <?php endif; ?>
  </div>

<?php else: ?>
  <div class="shopping-cart">
    <p>Bienvenido a tu carrito de compras</p>
  </div>
<?php endif; ?>
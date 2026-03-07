<?php

declare(strict_types=1);

use App\Controllers\ShoppingCart;
use App\Model\ProductModel;

$productId = (int) array_pop(explode('/', $_SERVER['REQUEST_URI'])) ?? 0;
$product = (new ProductModel($conn))->getById($productId);
$quantity = (new ShoppingCart($conn));
?>


<main>
  <div>
    <img src="<?= '.' . $product['image_url'] ?>" alt="imagen del producto <?= $product['name'] ?>">
    <div>
      <h3><?= $product['name'] ?></h3>
      <p><?= $product['description'] ?></p>
      <p>$ <?= $product['unit_price'] ?></p>
      <div>
        <?= $product['name'] ?>....
      </div>
    </div>
  </div>

</main>
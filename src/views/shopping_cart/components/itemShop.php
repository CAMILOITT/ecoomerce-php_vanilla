<style>
  .item-shop {
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding: 1rem .6rem;
    border-bottom: 1px solid #ccc;
    background: white;
    width: clamp(280px, 90%, 500px);
    border-radius: var(--border-l);
    flex-wrap: wrap;
    justify-content: center;
    gap: 1.5rem;

    .item-info {
      display: flex;
      align-items: center;
      gap: 2rem;
    }

    .item-quantity {
      display: flex;
      align-items: center;
      gap: 10px;

      p {
        text-align: center;
      }
    }
  }
</style>

<div class="item-shop" data-id="<?= $product['id'] ?>" data-quantity="<?= $product['amount'] ?>">
  <div class="item-info">
    <img src="path/to/product/image.jpg" alt="Producto 1" class="item-img">
    <div class="item-details">
      <h3><?= $product['name'] ?></h3>
      <p>Precio: $<?= $product['price'] ?></p>
      <div class="item-quantity">
        <button class="item-quantity-btn item-less">-</button>
        <p>Cantidad: <?= $product['amount'] ?></p>
        <button class="item-quantity-btn item-add">+</button>
      </div>
    </div>
  </div>
  <button class="item-delete">Eliminar</button>
</div>
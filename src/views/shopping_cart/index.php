<?php

declare(strict_types=1);

use App\Controllers\ShoppingCart;

$products = [];
if (isset($_SESSION['id']))
  $products = (new ShoppingCart($conn))->getAllProductsByCustomerId($_SESSION['id']);

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

  .btn-login {
    display: inline-block;
    padding: 0.75rem 1.5rem;
    background-color: var(--color-primary);
    color: white;
    text-decoration: none;
    border-radius: var(--border-l);
    font-weight: 700;
    transition: background-color 0.3s ease;

    &:hover {
      color: white;
      background: var(--color-primary-dark);
    }
  }
</style>

<h1>Carrito de Compras</h1>

<?php if (isset($_SESSION['id'])): ?>
  <div class="shopping-cart">
    <?php if (count($products) > 0): ?>
      <?php foreach ($products as $product): ?>
        <?php include_once __DIR__ . '/components/itemShop.php'; ?>
      <?php endforeach; ?>
    <?php else: ?>
      <p>Aun no has agregado productos al carrito.</p>
    <?php endif; ?>
  </div>


<?php else: ?>
  <div class="shopping-cart">
    <p>Bienvenido a tu carrito de compras</p>
    <p>Para agregar y ver productos debes iniciar sesión</p>
    <a href="/session" class="btn-login">Iniciar sesión</a>
  </div>
<?php endif; ?>

<script>
  const containerItems = document.querySelector('.shopping-cart')

  function removeItem(productId) {
    fetch(`/api/v1/shopping_cart/${productId}`, {
      method: 'DELETE'
    }).then(() => location.reload());
  }

  function lessItem(productId, currentQuantity) {
    fetch(`/api/v1/shopping_cart/${productId}`, {
      method: 'PUT',
      body: JSON.stringify({
        quantity: currentQuantity - 1
      }),
      headers: {
        'Content-Type': 'application/json'
      }
    }).then(() => location.reload())
  }

  function addItems(productId, currentQuantity) {
    fetch(`/api/v1/shopping_cart/${productId}`, {
      method: 'PUT',
      body: JSON.stringify({
        quantity: currentQuantity + 1
      }),
      headers: {
        'Content-Type': 'application/json'
      }
    }).then(() => location.reload())
  }

  containerItems.addEventListener('click', (e) => {
    const card = e.target.closest('.item-shop');
    if (!card) return

    const btn = e.target.closest('button')
    if (!btn) return

    const productId = card.dataset.id;
    const currentQuantity = parseInt(card.dataset.quantity || "0");

    if (btn.classList.contains('item-delete')) {
      removeItem(productId)
      return
    }

    if (btn.classList.contains('item-less')) {
      if (currentQuantity <= 1) return;
      lessItem(productId, currentQuantity)
      return
    }

    if (btn.classList.contains('item-add')) {
      addItems(productId, currentQuantity)
      return
    }
  })
</script>
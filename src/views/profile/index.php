<?php

declare(strict_types=1);

use App\Controllers\CustomerController;

if (!isset($_SESSION['customer_id'])) {
  header('Location: /session');
  exit;
}

$customerController = new CustomerController($conn);
$user = $customerController->getInformation($_SESSION['customer_id']);
$history = $customerController->getPurchaseHistoryByCustomerId($_SESSION['customer_id']);
?>

<main>
  <style>
    main {
      display: flex;
      flex-direction: column;
      align-items: center;
      padding: 1rem;

      .perfil {
        width: 100%;
        max-width: 600px;
        background: var(--color-bg);
        border-radius: var(--border-m);
        padding: 1rem;
        display: flex;
        gap: 1rem;
      }

      .perfil-info {
        display: flex;
        gap: 1rem;
        align-items: center;

        img {
          width: 100px;
          height: 100px;
          border-radius: 50%;
          object-fit: cover;
          background: red;
        }

        .info-data {
          display: flex;
          flex-direction: column;

        }
      }
    }
  </style>
  <a href="/" id='back-link'> <- </a>
      <script>
        const backLink = document.getElementById('back-link');
        backLink.addEventListener('click', (e) => {
          e.preventDefault();
          if (window.history.length > 1) {
            window.history.back();
          } else {
            window.location.href = '/';
          }
        });
      </script>
      <div class="perfil">
        <div class="perfil-info">
          <img src="/assets/images/user.png" alt="<?= "foto de perfil de {$user['name']}" ?>">
          <div class="info-data">
            <p>Nombre: </br> <?= $user['name'] ?></p>
            <p>dni:</br> <?= $user['dni'] ?></p>
            <p>tipo de documento:</br> <?= $user['type_document'] ?></p>
          </div>
        </div>

        <div>
          <p>Email: <?= $user['email'] ?></p>
          <p>Dirección: <?= $user['address'] ?></p>
          <p>Teléfono: <?= $user['phone'] ?></p>
        </div>
      </div>
      <div>
        <h3>Mis compras</h3>
        <?php if (empty($history)) : ?>
          <p>Aquí puedes ver el historial de tus compras realizadas en nuestro minimarket. Revisa los detalles de cada compra, incluyendo los productos adquiridos, fechas y montos. ¡Gracias por ser parte de nuestra comunidad de compradores!</p>
        <?php else : ?>
          <table>
            <!-- poner el historial de compras y un detalle de cada compra -->
            <thead>
              <tr>
                <th>ID</th>
                <th>Atendido por</th>
                <th>Fecha</th>
                <th>Total</th>
                <th>Más Información</th>
              </tr>
            </thead>
            <tbody>
              <?php foreach ($history as $purchase) : ?>
                <tr>
                  <td><?= $purchase['id'] ?></td>
                  <td><?= $purchase['name'] . ' ' . $purchase['lastname'] ?></td>
                  <td><?= $purchase['bill_date'] ?></td>
                  <td><?= $purchase['total'] ?></td>
                  <td><button>Ver</button></td>
                </tr>
              <?php endforeach; ?>
            </tbody>
          </table>
        <?php endif; ?>
      </div>
</main>
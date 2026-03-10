<style>
  .history {
    width: 100%;
    display: flex;
    flex-direction: column;
    align-items: center;
  }

  .table-info {
    width: 100%;
    display: flex;
    justify-content: center;
    align-items: center;
    padding: 2rem;
  }

  .container-table {
    width: 100%;
  }

  .table {
    width: 100%;
    border-collapse: collapse;
    margin: 1rem .5rem;

    tr {

      td,
      th {
        padding: .3rem .5rem;
        outline: 1px solid red;
      }
    }

    tbody {

      tr {
        &:hover {
          background-color: #f0f0f0;
        }

        td {
          text-align: center;
        }
      }
    }
  }
</style>

<div class="history">
  <h2>Mis compras</h2>
  <?php if (empty($history)) : ?>
    <p>Aquí puedes ver el historial de tus compras realizadas en nuestro minimarket. Revisa los detalles de cada compra, incluyendo los productos adquiridos, fechas y montos. ¡Gracias por ser parte de nuestra comunidad de compradores!</p>
  <?php else : ?>
    <?php
    $dialogContentPath = isset($dialogContentPath) ? $dialogContentPath : __DIR__ . '/DialogContent.php';
    ob_start();
    include $dialogContentPath;
    $dialogContent = ob_get_clean();
    include_once __DIR__ . '../../../components/Dialog.php'
    ?>

    <div class="container-table">
      <table class="table" id='table-modified'>
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
              <td><button data-id="<?= $purchase['id'] ?>">Ver</button></td>
            </tr>
          <?php endforeach; ?>
        </tbody>
      </table>
    </div>

  <?php endif; ?>
</div>


<script>
  const dialog = document.querySelector('dialog');
  const table = document.querySelector('#table-modified');

  table.addEventListener('click', async (event) => {
    if (event.target.tagName === 'BUTTON' && event.target.dataset.id) {
      const saleId = event.target.dataset.id;

      try {
        const response = await fetch(`/api/v1/sale/${saleId}`);
        if (!response.ok) {
          throw new Error('Network response was not ok');
        }
        const saleData = await response.json();

        const saleTotalEl = dialog.querySelector('#sale-total');
        const saleProductsTbody = dialog.querySelector('#sale-products tbody');

        saleTotalEl.textContent = saleData.total;

        saleProductsTbody.innerHTML = '';

        saleData.details.forEach(product => {
          const row = document.createElement('tr');
          row.innerHTML = `
            <td>${product.name}</td>
            <td>${product.quantity}</td>
            <td>${product.unit_price}</td>
          `;
          saleProductsTbody.appendChild(row);
        });

        dialog.showModal();
      } catch (error) {
        console.error('There has been a problem with your fetch operation:', error);
        // Optionally, show an error message to the user in the dialog
        dialog.querySelector('#sale-details').innerHTML = '<p>Error al cargar los detalles de la compra.</p>';
        dialog.showModal();
      }
    }
  });
</script>
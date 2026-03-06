<style>
  .table-info {
    width: 100%;
    display: flex;
    justify-content: center;
    align-items: center;
    padding: 2rem;
  }

  .container-table {
    width: 100%;
    /* display: flex;
    justify-content: center; */
    overflow: scroll;
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

  .dialog-editar {
    width: clamp(300px, 80%, 70vw);
    border-radius: var(--border-l);

    &::backdrop {
      background-color: rgba(0, 0, 0, 0.5);
    }

    .form-editar {
      width: 100%;
      display: grid;
      grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
      gap: 1rem;
      padding: 1rem;

      label {
        font-weight: bold;
      }

      input {
        padding: 0.5rem;
        border: 1px solid #ccc;
        border-radius: 4px;
      }

      .btn-save {
        grid-column: span 2;
        /* 
        padding: 0.5rem 1rem;
        background-color: var(--primary);
        color: white;
        border: none;
        border-radius: 4px;
        cursor: pointer; */
      }
    }
  }
</style>

<?php if (count($data) > 0): ?>
  <dialog class="dialog-editar">
    <form method='dialog'>
      <button>close</button>
    </form>
    <form class="form-editar">
      <?php foreach ($data[0] as $key => $value): ?>
        <label for="<?= $key ?>"><?= $key ?>:</label>
        <input type="text" id="<?= $key ?>" name="<?= $key ?>" value="<?= $value ?>">
      <?php endforeach; ?>
      <button type="submit" class='btn-save'>Guardar</button>
    </form>
  </dialog>

  <div class="container-table">

    <table class="table" id='table-modified'>
      <thead>
        <tr>

          <?php
          foreach (array_keys($data[0]) as $key):
          ?>
            <th><?= $key ?></th>
          <?php endforeach; ?>
          <th>Acciones</th>
        </tr>
      </thead>
      <tbody>
        <?php
        foreach ($data as $item):
        ?>
          <tr>
            <?php
            foreach ($item as $value):
            ?>
              <td><?= $value ?? 0 ?></td>
            <?php endforeach; ?>
            <td><button>Editar</button></td>
          </tr>
        <?php endforeach; ?>
      </tbody>

    </table>
  </div>

  <script>
    const dialog = document.querySelector('dialog');
    const buttons = document.querySelectorAll('button');
    const table = document.querySelector('#table-modified');

    table.addEventListener('click', (event) => {
      if (event.target.tagName === 'BUTTON') {
        const row = event.target.closest('tr');
        const cells = row.querySelectorAll('td');
        const form = dialog.querySelector('form');

        cells.forEach((cell, index) => {
          const input = form.elements[index];
          if (input) {
            input.value = cell.textContent.trim();
          }
        });

        dialog.showModal();
      }
    });
  </script>

<?php else: ?>
  <div class="table-info">
    <h2>
      No hay datos para mostrar.
    </h2>
  </div>
<?php endif; ?>
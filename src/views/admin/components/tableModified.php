<style>
  .table {
    width: 100%;
    border-collapse: collapse;
    margin: 2rem;
  }
</style>

<div class="modified-table"></div>

<table class="table">
  <thead>
    <?php
    foreach (array_keys($data[0]) as $key):
    ?>
      <th><?= $key ?></th>
    <?php endforeach; ?>
    <th>Acciones</th>
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
<div class="modified-table"></div>

<table>
  <thead>
    <?php
    foreach (array_keys($data[0]) as $key):
    ?>
      <th><?= htmlspecialchars($key) ?></th>
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
          <td><?= htmlspecialchars($value) ?></td>
        <?php endforeach; ?>
        <td><button>Editar</button></td>
      </tr>
    <?php endforeach; ?>
  </tbody>

</table>
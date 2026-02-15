<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>lista de productos</title>
</head>

<body>
  <?php include_once __DIR__ . '/../components/Header.php' ?>
  <main>
    <?php include_once __DIR__ . '/components/Filtro.php' ?>
    <div>
      <?php include_once __DIR__ . '/../components/Card.php' ?>
    </div>
  </main>
  <?php include_once __DIR__ . '/../components/Footer.php' ?>
</body>

</html>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>lista de productos</title>
  <link rel="stylesheet" href="/global.css">
</head>

<style>
  main {
    display: flex;
    gap: 1rem;

  }
</style>

<body style="height: 100vh;">
  <?php include_once __DIR__ . '/../components/Header.php' ?>
  <main>
    <?php include_once __DIR__ . '/components/Filtro.php' ?>
    <?php include_once $path_content ?>
  </main>
  <?php include_once __DIR__ . '/../components/Footer.php' ?>
</body>

</html>
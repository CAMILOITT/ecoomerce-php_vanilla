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

    .list-products {
      display: grid;
      grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
      gap: 1rem;
      overflow-y: scroll;
      width: 100%;
    }
  }
</style>

<body style="height: 100vh;">
  <?php include_once __DIR__ . '/../../components/Header.php' ?>
  <?php include_once $path_content ?>
  <?php include_once __DIR__ . '/../../components/Footer.php' ?>
</body>

</html>
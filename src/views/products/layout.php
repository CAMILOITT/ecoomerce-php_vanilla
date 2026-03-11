<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>lista de productos</title>
  <link rel="stylesheet" href="/global.css">
</head>

<style>
  body {
    min-height: 100vh;
    display: flex;
    flex-direction: column;
    /* align-items: center; */
    justify-content: space-between;
  }

  main {
    display: flex;
    flex: auto;
    gap: 1rem;
    min-height: 100%;
    margin: 0 clamp(.5rem, 2vw, 3rem);
  }
</style>

<body>
  <?php include_once __DIR__ . '/../components/Header.php' ?>
  <main>
    <!-- <?php include_once __DIR__ . '/components/Filtro.php' ?> -->
    <?php include_once $path_content ?>
  </main>
  <?php include_once __DIR__ . '/../components/Footer.php' ?>
</body>

</html>
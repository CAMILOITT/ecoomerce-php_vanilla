<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="/global.css">
  <title>Inicio - minimarket</title>
</head>

<body>
  <?php include_once __DIR__ . '/components/Header.php' ?>
  <main>
    <?php include_once __DIR__ . '/components/Banner.php' ?>
    <section>
      <div style="display: flex; align-items: center; justify-content: space-between;">
        <h2>Productos mas populares
        </h2>
        <a style="background-color: red;" href="/productos?category=bebidas">Ir</a>
      </div>
      <div>
        <!-- peticion para mostrar una lista de prodcutos -->
        <?php include_once __DIR__ . '/components/Card.php' ?>
      </div>
    </section>
  </main>
  <?php include_once __DIR__ . '/components/Footer.php' ?>
</body>

</html>
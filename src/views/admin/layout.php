<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>admin - dashboard</title>
  <link rel="stylesheet" href="/global.css">
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>

<body>
  <?php include __DIR__ . '/components/aside.php'; ?>
  <main class="main">
    <?php include $path_content ?>
  </main>
</body>

</html>

<style>
  body {
    display: flex;
    position: relative;
  }

  .main {
    width: 100%;
    height: 100vh;
    overflow-y: scroll;
  }
</style>
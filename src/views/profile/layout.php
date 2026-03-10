<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="global.css">
  <title>Perfil de usuario - Minimarket</title>
</head>

<style>
  body {
    position: relative;
  }

  #back-link {
    position: absolute;
    top: .5rem;
    left: .5rem;
    text-decoration: none;
    background: var(--color-card-bg);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    width: 2.5rem;
    height: 2.5rem;
  }
</style>

<body>
  <a href="/" id='back-link'> <?php include 'assets/svg/icons/back.svg' ?></a>
  <script>
    const backLink = document.getElementById('back-link');
    backLink.addEventListener('click', (e) => {
      e.preventDefault();
      if (window.history.length > 1) {
        window.history.back();
      } else {
        window.location.href = '/';
      }
    });
  </script>
  <?php include_once $path_content ?>
</body>

</html>
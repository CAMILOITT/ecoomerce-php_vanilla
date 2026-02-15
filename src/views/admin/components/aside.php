<script>
  document.getElementById('close_session').addEventListener('click', function() {
    // Aquí puedes agregar la lógica para cerrar la sesión, como eliminar cookies o redirigir a una página de inicio de sesión
    alert('Sesión cerrada');
    // Por ejemplo, podrías redirigir al usuario a la página de inicio de sesión:
    // window.location.href = '/login.php';
  });
</script>

<aside class="aside-admin">
  <?php include __DIR__ . '/link_page.php' ?>
  <button id='close_session'>Cerrar sesión</button>
</aside>

<style>
  .aside-admin {
    width: 200px;
    height: 100vh;
    background-color: #f0f0f0;
    padding: 20px;
    box-sizing: border-box;
    display: flex;
    flex-direction: column;
    justify-content: space-between;
  }

  .list-page {
    list-style-type: none;
    padding: 0;
    margin: 0;
  }

  .link-page {
    display: block;
    padding: 10px;
    color: #333;
    text-decoration: none;
    border-radius: 4px;
    transition: background-color 0.3s ease;
  }

  .link-page:hover {
    background-color: #ddd;
  }
</style>
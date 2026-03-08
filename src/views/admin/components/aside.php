<style>
  .aside-admin {
    width: 150px;
    height: 100vh;
    /* position: sticky; */
    top: 0;
    right: 0;
    background-color: #f0f0f0;
    padding: 1rem .5rem;
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

<aside class="aside-admin">
  <?php include __DIR__ . '/link_page.php' ?>
  <button id='close_session'>Cerrar sesión</button>
</aside>


<script>
  document.getElementById('close_session').addEventListener('click', () => {
    fetch('/api/v1/logout', {
      method: 'POST',
      headers: {
        'Content-Type': 'application/json'
      }
    }).then(response => {
      if (response.ok) window.location.href = '/';
      else alert('Error al cerrar sesión. Por favor, inténtalo de nuevo.');
    }).catch(error => {
      console.error('Error:', error);
      alert('Error al cerrar sesión. Por favor, inténtalo de nuevo.');
    });
  })
</script>
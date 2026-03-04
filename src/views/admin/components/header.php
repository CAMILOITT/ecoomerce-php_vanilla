<style>
  .header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 20px;
    background-color: #f5f5f5;
  }
</style>
<header class="header">
  <div>
    <h1>
      <?= $titleHeader ?? 'Admin Dashboard' ?>
    </h1>
    <p><?= $descriptionHeader ?? 'Bienvenido al panel de administración' ?></p>
  </div>
  <button>Nuevo</button>
</header>
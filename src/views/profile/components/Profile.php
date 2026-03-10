<style>
  .perfil {
    width: 100%;
    max-width: 99vw;
    padding: 1rem;
    display: flex;
    gap: 1rem;
    flex-wrap: wrap;
    justify-content: center;
  }

  .perfil-info,
  .perfil-info-contacto {
    padding: 1rem clamp(1rem, 10vw, 2rem);
    background: var(--color-card-bg);
    border-radius: var(--border-m);
  }

  .perfil-info {
    display: flex;
    gap: 1rem;
    align-items: center;

    img {
      width: 100px;
      height: 100px;
      border-radius: 50%;
      object-fit: cover;
      background: red;
      aspect-ratio: 1/1;
    }

    .info-data {
      display: flex;
      flex-direction: column;

    }
  }

  .perfil-info-contacto {
    display: flex;
    flex-direction: column;
    gap: .5lh;
    justify-content: center;
  }
</style>

<div class="perfil">
  <div class="perfil-info">
    <img src="/assets/images/user.png" alt="<?= "foto de perfil de {$user['name']}" ?>">
    <div class="info-data">
      <p> <strong>Nombre:</strong> </br> <?= $user['name'] ?></p>
      <p> <strong>dni:</strong> </br> <?= $user['dni'] ?></p>
      <p> <strong>tipo de documento:</strong> </br> <?= $user['type_document'] ?></p>
    </div>
  </div>

  <div class="perfil-info-contacto">
    <p><strong>Email:</strong> <?= $user['email'] ?></p>
    <p><strong>Dirección:</strong> <?= $user['address'] ?></p>
    <p><strong>Teléfono:</strong> <?= $user['phone'] ?></p>
  </div>
</div>
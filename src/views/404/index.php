<style>
  .container-404 {
    display: flex;
    align-items: center;
    justify-content: center;
    min-height: calc(100vh - 200px);
    padding: 2rem;
  }

  .content-404 {
    text-align: center;
    animation: fadeIn 0.6s ease-in-out;
  }

  @keyframes fadeIn {
    from {
      opacity: 0;
      transform: translateY(-20px);
    }

    to {
      opacity: 1;
      transform: translateY(0);
    }
  }

  .error-code {
    font-size: clamp(6rem, 20vw, 15rem);
    font-weight: 700;
    background: linear-gradient(135deg, var(--color-primary) 0%, var(--color-primary-light) 100%);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    background-clip: text;
    margin: 0;
    line-height: 1;
  }

  .error-message {
    font-size: 1.5rem;
    color: var(--color-text);
    margin: 1.5rem 0;
    font-weight: 500;
  }

  .error-description {
    font-size: 1rem;
    color: var(--color-text-muted);
    margin: 1rem 0 2rem;
    max-width: 500px;
  }

  .btn-404 {
    background: linear-gradient(135deg, var(--color-primary) 0%, var(--color-primary-light) 100%);
    color: white;
    padding: 14px 32px;
    font-size: 1rem;
    font-weight: 600;
    border: none;
    border-radius: var(--pill);
    cursor: pointer;
    transition: all 0.3s ease;
    box-shadow: var(--shadow-soft);
    display: inline-block;
  }

  .btn-404:hover {
    transform: translateY(-2px);
    box-shadow: var(--shadow-hover);
  }

  .btn-404:active {
    transform: translateY(0);
  }

  @media (max-width: 768px) {
    .container-404 {
      min-height: calc(100vh - 180px);
      padding: 1.5rem;
    }

    .error-message {
      font-size: 1.25rem;
    }

    .error-description {
      font-size: 0.95rem;
    }

    .btn-404 {
      padding: 12px 28px;
      font-size: 0.95rem;
    }
  }
</style>

<main>
  <div class="container-404">
    <div class="content-404">
      <h1 class="error-code">404</h1>
      <h2 class="error-message">Página no encontrada</h2>
      <p class="error-description">
        La página que buscas no existe o ha sido removida.
      </p>
      <button class="btn-404" onclick="handleRedirect()">
        Volver atrás
      </button>
    </div>
  </div>
</main>

<script>
  function handleRedirect() {
    // Verificar si hay un referrer y si pertenece al mismo dominio
    const referrer = document.referrer;

    if (referrer && isSameDomain(referrer)) {
      // Ir a la página anterior
      window.history.back();
    } else {
      // Ir a la página de inicio
      window.location.href = '/';
    }
  }

  function isSameDomain(url) {
    try {
      const referrerUrl = new URL(url);
      const currentUrl = new URL(window.location.href);

      return referrerUrl.origin === currentUrl.origin;
    } catch (error) {
      // Si hay un error al parsear la URL, ir a inicio
      return false;
    }
  }
</script>
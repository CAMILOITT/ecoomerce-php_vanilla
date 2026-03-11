<style>
  .container-unauthorized {
    display: flex;
    align-items: center;
    justify-content: center;
    min-height: calc(100vh - 200px);
    padding: 2rem;
  }

  .content-unauthorized {
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
    background: linear-gradient(135deg, var(--color-error) 0%, #FF6B6B 100%);
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

  .btn-unauthorized {
    background: linear-gradient(135deg, var(--color-error) 0%, #FF6B6B 100%);
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

  .btn-unauthorized:hover {
    transform: translateY(-2px);
    box-shadow: 0 15px 35px rgba(233, 79, 55, 0.15);
  }

  .btn-unauthorized:active {
    transform: translateY(0);
  }

  @media (max-width: 768px) {
    .container-unauthorized {
      min-height: calc(100vh - 180px);
      padding: 1.5rem;
    }

    .error-message {
      font-size: 1.25rem;
    }

    .error-description {
      font-size: 0.95rem;
    }

    .btn-unauthorized {
      padding: 12px 28px;
      font-size: 0.95rem;
    }
  }
</style>

<main>
  <div class="container-unauthorized">
    <div class="content-unauthorized">
      <h1 class="error-code">403</h1>
      <h2 class="error-message">Acceso denegado</h2>
      <p class="error-description">
        No tienes permiso para acceder a esta página. Si crees que es un error, contacta con el administrador.
      </p>
      <button class="btn-unauthorized" onclick="handleRedirect()">
        Volver atrás
      </button>
    </div>
  </div>
</main>

<script>
  function handleRedirect() {
    const referrer = document.referrer;
    if (referrer && isSameDomain(referrer)) window.history.back();
    else window.location.href = '/';

  }

  function isSameDomain(url) {
    try {
      const referrerUrl = new URL(url);
      const currentUrl = new URL(window.location.href);
      return referrerUrl.origin === currentUrl.origin;
    } catch (error) {
      return false;
    }
  }
</script>
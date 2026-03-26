<style>
  .message-error {
    display: none;
    color: red;
    margin-bottom: 1rem;
    border: 1px solid red;
    padding: 0.5rem;
    background: rgba(255, 0, 0, .15);
    border-radius: 8px;
  }

  .message-success {
    display: none;
    color: green;
    margin-bottom: 1rem;
    border: 1px solid green;
    padding: 0.5rem;
    background: rgba(0, 255, 0, .15);
    border-radius: 8px;
  }

  .container {
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    background: white;
    color: black;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    padding: 24px;
    border-radius: var(--border-radius, 8px);
    width: 100%;
    max-width: 400px;
  }

  .title {
    font-size: 2rem;
    margin-bottom: 1.5rem;
  }

  .form {
    display: flex;
    flex-direction: column;
    width: 100%;
  }

  .form label {
    margin-bottom: 0.5rem;
    font-weight: bold;
  }

  .form input {
    padding: 10px;
    margin-bottom: 1.2rem;
    border: 1px solid #ccc;
    border-radius: 4px;
    font-size: 1rem;
  }

  .form button {
    padding: 12px;
    background-color: #007BFF;
    color: white;
    border: none;
    border-radius: 4px;
    cursor: pointer;
    font-size: 1rem;
    font-weight: bold;
    transition: background-color 0.2s;
  }

  .form button:hover {
    background-color: #0056b3;
  }

  .links {
    margin-top: 1.5rem;
    text-align: center;
  }

  .links a {
    color: #007BFF;
    text-decoration: none;
  }

  .links a:hover {
    text-decoration: underline;
  }
</style>

<div class="container">
  <h1 class="title">Crear cuenta</h1>
  <div id="error-alert" class="message-error"></div>
  <div id="success-alert" class="message-success"></div>
  
  <form id="register-form" class="form">
    <label for="name">Nombre:</label>
    <input type="text" id="name" name="name" required>

    <label for="lastname">Apellido:</label>
    <input type="text" id="lastname" name="lastname" required>

    <label for="dni">DNI / Cédula:</label>
    <input type="text" id="dni" name="dni" required maxlength="13">

    <label for="email">Correo electrónico:</label>
    <input type="email" id="email" name="email" required>

    <label for="password">Contraseña:</label>
    <input type="password" id="password" name="password" required minlength="6">

    <label for="confirm_password">Confirmar contraseña:</label>
    <input type="password" id="confirm_password" name="confirm_password" required minlength="6">

    <button type="submit">Registrarse</button>
  </form>

  <div class="links">
    ¿Ya tienes cuenta? <a href="/session">Inicia sesión</a>
  </div>
</div>

<script>
  const registerForm = document.getElementById('register-form');
  const errorAlert = document.getElementById('error-alert');
  const successAlert = document.getElementById('success-alert');

  registerForm.addEventListener('submit', async (event) => {
    event.preventDefault();
    errorAlert.style.display = 'none';
    successAlert.style.display = 'none';

    const formData = new FormData(registerForm);
    const data = Object.fromEntries(formData.entries());

    // Front-end validation for matching passwords
    if (data.password !== data.confirm_password) {
      errorAlert.textContent = 'Las contraseñas no coinciden';
      errorAlert.style.display = 'block';
      return;
    }

    try {
      const url = window.location.origin + '/session/register';
      const response = await fetch(url, {
        method: 'POST',
        headers: {
          'Content-Type': 'application/json'
        },
        body: JSON.stringify(data)
      });

      const result = await response.json();

      if (response.ok && result.data && result.data.success) {
        successAlert.textContent = '¡Cuenta creada con éxito! Redirigiendo...';
        successAlert.style.display = 'block';
        registerForm.reset();
        setTimeout(() => {
          window.location.href = '/session';
        }, 2000);
      } else {
        errorAlert.textContent = result.error || 'Error al registrarse. Por favor intenta de nuevo.';
        errorAlert.style.display = 'block';
      }
    } catch (error) {
      console.error('Error:', error);
      errorAlert.textContent = 'Ocurrió un error inesperado. Inténtalo de nuevo más tarde.';
      errorAlert.style.display = 'block';
    }
  });
</script>

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

  .container {
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    background: white;
    color: black;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    padding: 12px 18px;
    border-radius: var(--border-radius, 4px);
  }

  .title {
    font-size: 2rem;
    margin-bottom: 1rem;
  }

  .form {
    display: flex;
    flex-direction: column;
    width: 300px;
  }

  .form label {
    margin-bottom: 0.5rem;
  }

  .form input {
    padding: 0.5rem;
    margin-bottom: 1rem;
    border: 1px solid #ccc;
    border-radius: 4px;
  }

  .form button {
    padding: 0.5rem;
    background-color: #007BFF;
    color: white;
    border: none;
    border-radius: 4px;
    cursor: pointer;
  }

  .form button:hover {
    background-color: #0056b3;
  }
</style>


<div class="container">
  <h1 class="title">Iniciar session</h1>
  <div class="message-error">Usuario o Contraseña incorrecta</div>
  <form class="form">
    <label for="email">Correo electrónico:</label>
    <input type="email" id="email" name="email" required>
    <label for="password">Contraseña:</label>
    <input type="password" id="password" name="password" required>
    <button type="submit">Iniciar sesión</button>
  </form>
</div>

<script>
  const urls = window.location.origin + '/api/v1/login'
  console.log(urls);

  const form = document.querySelector('.form')
  form.addEventListener('submit', (event) => {
    event.preventDefault()
    console.log(urls);

    const dataInputs = new FormData(form)
    const data = Object.fromEntries(dataInputs.entries())
    const url = window.location.origin + '/api/v1/login'

    fetch(url, {
        method: "POST",
        headers: {
          'Content-Type': 'application/json'
        },
        body: JSON.stringify(data)
      }).then(response => {
        if (!response.ok) throw new Error('Erro al iniciar session');
        return response.json()
      })
      .then(res => {
        if (res.data.success) window.location.href = res.data.redirect
        else document.querySelector('.message-error').style.display = 'block'

      })
      .catch(error => {
        console.error('Error:', error);
        alert('Error al iniciar sesión. Por favor, inténtalo de nuevo.');
      })
  })
</script>
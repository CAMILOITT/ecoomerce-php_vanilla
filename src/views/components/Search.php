<style>
  .search {
    position: relative;
    flex: 1;
    max-width: 500px;
    margin: 0 2rem;

    &>input {
      width: 100%;
      padding: 14px 42px 14px 24px;
      background: #FFFFFF;
      border-radius: var(--pill);
      box-shadow: inset 0 2px 4px rgba(0, 0, 0, 0.02);
      font-size: 0.95rem;
    }

    &>input::placeholder {
      color: #A0A0A0;
    }

    &>input:focus {
      outline: 2px solid var(--color-primary-light);
      box-shadow: 0 0 0 4px rgba(240, 90, 40, 0.1);
    }

    &>button {
      position: absolute;
      right: 6px;
      top: 50%;
      transform: translateY(-50%);
      background: transparent;
      color: var(--color-text);
      padding: 8px;
      aspect-ratio: 1/1;
      display: flex;
      align-items: center;
      justify-content: center;
      border-radius: 50%;
    }

    &>button:hover {
      background: var(--color-bg-light);
    }

    &>button svg {
      width: 20px;
      height: 20px;
    }
  }
</style>

<div class="search" id="user-search">
  <input placeholder="Search for grocery, vegetable, spices..." type="search" name="input_search" id="input-search">
  <button id="btn-search"><?php include 'assets/svg/icons/search.svg' ?></button>
</div>

<script>
  const search = document.querySelector('#user-search')
  const btnSearch = document.querySelector('#btn-search')

  function searchProduct() {
    const input = search.querySelector('input')
    const value = input.value.trim()
    if (value) window.location.href = `/products?search=${value}`
  }

  search.addEventListener('click', (e) => {
    if (e.target.closest('button')) searchProduct()
  })

  search.addEventListener('keypress', (e) => {
    if (e.key === 'Enter') searchProduct()
  })
</script>
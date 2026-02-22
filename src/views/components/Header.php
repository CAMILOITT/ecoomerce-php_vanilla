<style>
  .header {
    background: var(--color-primary);
    color: var(--color-text);
    display: flex;
    padding: 12px 8px;
    align-items: center;
    justify-content: space-around;

    .logo {
      font-size: 1.4rem;
      display: flex;
      align-items: center;
      gap: .5rem;
      font-weight: bold;
    }

    .search {
      position: relative;

      &>input {
        padding-right: 20px;
        width: clamp(200px, 40vw, 500px);

        &:focus {
          outline: 2px solid var(--color-primary);
        }
      }

      &>button {
        position: absolute;
        right: 4px;
        border-radius: 4px;
        top: 50%;
        transform: translateY(-50%);
        background: var(--color-primary-light);
        color: var(--color-bg);
        padding: 3px 6px;
        aspect-ratio: 2/1;
      }
    }
  }

  @media (width <=590px) {
    .header {
      padding-inline: 4px;

    }


    .logo {
      gap: 0px;

      span {
        display: none;
        font-size: 1.5rem;
      }
    }
  }

  .menu-category,
  .menu-profile {
    position: relative;


    &:hover {

      .dropdown-category,
      .dropdown-profile {
        visibility: visible;
        opacity: 1;
        translate: 0 0;
        display: flex;
        opacity: 1;
        visibility: visible;

      }
    }

    svg {
      font-size: 1.5rem;
    }
  }

  .dropdown-category {
    left: 0;
  }

  .dropdown-profile {
    right: 0;
  }

  .dropdown-category,
  .dropdown-profile {
    position: absolute;
    background-color: var(--color-bg);
    border-radius: var(--border-l);
    padding: .5rem 1rem;
    font-size: small;
    display: flex;
    flex-direction: column;
    gap: .5rem;
    animation: animation-dropdown 200ms;
    opacity: 0;
    translate: 0 -10px;
    transition: all 200ms allow-discrete ease;
    opacity: 0;
    visibility: hidden;
    z-index: 2;

    /* https://youtube.com/shorts/QNxfHV4zlFA?si=g3or7yqhwlGXxleg */
    li {
      list-style: none;

      &:hover {
        background: var(--color-primary-light);
        border-radius: var(--border-s);
      }

      &>a {
        display: flex;
        gap: .3rem;
        width: 100%;
        padding: 4px 8px;
        font-weight: bold;
      }
    }
  }
</style>

<header class="header">
  <div class="logo">
    <div class="menu-category">
      <?php include_once 'assets/svg/icons/menu-deep.svg' ?>
      <div class="dropdown-category">
        <h3>Categoría</h3>
        <?php

        use App\Controllers\CategoryController;

        $categoryController = new CategoryController($conn);

        $allCategories = $categoryController->getAllCategories();
        $allSubcategories = $categoryController->getAllSubcategories();

        foreach ($allCategories as $category): ?>
          <div style="display: flex; gap: .3rem;">
            <h4><?= $category['name'] ?></h4>
            <ul>
              <!-- buscar las categorías disponibles -->
              <?php
              $listCategories = array_filter($allSubcategories, function ($item) use ($category) {
                return $item['parent_id'] === $category['id'];
              });
              foreach ($listCategories as $subcategory): ?>
                <li><a href="/productos?category=<?= $subcategory['name'] ?>"><?= $subcategory['name'] ?></a></li>
              <?php endforeach; ?>
            </ul>
          </div>
        <?php endforeach; ?>
      </div>
    </div>
    <?php include_once 'assets/svg/icons/shopping-cart.svg' ?>
    <span>MINIMARKET</span>
  </div>
  <div class="search" id="user-search">
    <input placeholder="buscar un producto..." type="search" name="input_search" id="input-search">
    <button id="btn-search"><?php include_once 'assets/svg/icons/search.svg' ?></button>
  </div>
  <div class="menu-profile">
    <?php include_once 'assets/svg/icons/profile.svg' ?>
    <ul class="dropdown-profile">
      <li>
        <a href="/shopping"><?php include_once 'assets/svg/icons/shopping-bag.svg' ?>carrito de compras</a>
      </li>
    </ul>
  </div>
</header>

<script>
  const search = document.querySelector('#user-search')
  const btnSearch = document.querySelector('#btn-search')

  function searchProduct() {
    const input = search.querySelector('input')
    const value = input.value.trim()
    if (value) window.location.href = `/productos?search=${value}`
  }

  console.log(search.closest('button'))
  search.addEventListener('click', (e) => {
    if (e.target.closest('button')) searchProduct()
  })

  search.addEventListener('keypress', (e) => {
    if (e.key === 'Enter') searchProduct()
  })
</script>
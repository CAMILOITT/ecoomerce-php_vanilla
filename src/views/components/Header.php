<style>
  .header {
    background: rgba(255, 255, 255, 0.4);
    /* backdrop-filter: blur(10px);
    -webkit-backdrop-filter: blur(10px); */
    color: var(--color-text);
    display: flex;
    padding: 16px 24px;
    align-items: center;
    justify-content: space-between;
    /* border-radius: var(--border-xl); */
    /* margin: 1rem 2rem; */
    /* box-shadow: var(--shadow-soft); */
  }

  .logo {
    font-size: 1.6rem;
    display: flex;
    align-items: center;
    gap: .8rem;
    font-weight: 700;
    color: var(--color-text);

    svg {
      width: 28px;
      height: 28px;
    }
  }

  .search {
    position: relative;
    flex: 1;
    max-width: 500px;
    margin: 0 2rem;

    &>input {
      width: 100%;
      padding: 14px 24px;
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

  .menu-category,
  .menu-profile {
    display: flex;
    align-items: center;
    justify-content: center;
    cursor: pointer;
    z-index: 2;
  }

  .menu-profile {
    background: var(--color-pastel-orange);
    padding: 8px;
    border-radius: 50%;
    transition: transform 0.2s ease;

    &:hover {
      transform: scale(1.05);
    }
  }

  .menu-category {
    background: #FFFFFF;
    padding: 10px;
    border-radius: var(--pill);
    box-shadow: var(--shadow-soft);
    transition: all 0.2s ease;

    &:hover {
      box-shadow: var(--shadow-hover);
    }
  }

  @media (max-width: 768px) {
    .header {
      padding: 12px;
      margin: 1rem;
      flex-wrap: wrap;
      gap: 1rem;
    }

    .search {
      order: 3;
      max-width: 100%;
      margin: 0;
    }

    .logo span {
      display: none;
    }
  }

  .menu-category,
  .menu-profile {
    position: relative;
  }

  .menu-category:hover .dropdown-category,
  .menu-profile:hover .dropdown-profile {
    opacity: 1;
    visibility: visible;
    transform: translateY(0);
  }

  .dropdown-category {
    left: 0;
    top: calc(100% + 10px);
  }

  .dropdown-profile {
    right: 0;
    top: calc(100% + 10px);
  }

  .dropdown-category,
  .dropdown-profile {
    position: absolute;
    background-color: var(--color-card-bg);
    border-radius: var(--border-l);
    padding: 1rem;
    font-size: 0.95rem;
    display: flex;
    flex-direction: column;
    gap: 0.8rem;
    box-shadow: var(--shadow-hover);
    min-width: 200px;

    opacity: 0;
    visibility: hidden;
    transform: translateY(-10px);
    transition: all 0.3s cubic-bezier(0.175, 0.885, 0.32, 1.275);
    z-index: 1;
  }

  .dropdown-category h3 {
    font-size: 1.1rem;
    margin-bottom: 0.5rem;
    color: var(--color-primary);
  }

  .dropdown-category h4 {
    font-size: 0.95rem;
    color: var(--color-text-muted);
  }

  .dropdown-category li,
  .dropdown-profile li {
    list-style: none;
  }

  .dropdown-category li a,
  .dropdown-profile li a {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    width: 100%;
    padding: 8px 12px;
    font-weight: 500;
    border-radius: var(--border-s);
    transition: background 0.2s ease;
  }

  .dropdown-category li a:hover,
  .dropdown-profile li a:hover {
    background: var(--color-bg-light);
    color: var(--color-primary);
  }
</style>

<header class="header">
  <div class="logo">
    <div class="menu-category">
      <?php include_once 'assets/svg/icons/menu-deep.svg' ?>
      <div class="dropdown-category">
        <h3>Categorías</h3>
        <?php

        use App\Controllers\CategoryController;

        $categoryController = new CategoryController($conn);

        $allCategories = $categoryController->getAllCategories();
        $allSubcategories = $categoryController->getAllSubcategories();

        foreach ($allCategories as $category): ?>
          <div style="display: flex; flex-direction: column; gap: .3rem; margin-bottom: 0.5rem;">
            <h4><?= $category['name'] ?></h4>
            <ul style="padding-left: 0;">
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
    <a href="/" style="display: flex; align-items: center; gap: 0.5rem;">
      <?php include_once 'assets/svg/icons/shopping-cart.svg' ?>
      <span>MINIMARKET</span>
    </a>
  </div>

  <div class="search" id="user-search">
    <input placeholder="Search for grocery, vegetable, spices..." type="search" name="input_search" id="input-search">
    <button id="btn-search"><?php include 'assets/svg/icons/search.svg' ?></button>
  </div>

  <div class="menu-profile">
    <?php include 'assets/svg/icons/profile.svg' ?>
    <ul class="dropdown-profile">
      <li>
        <a href="<?php echo '/profile' ?>"><?php include 'assets/svg/icons/profile.svg' ?> Mi Perfil</a>
      </li>
      <li>
        <a href="/shopping"><?php include_once 'assets/svg/icons/shopping-bag.svg' ?> Ver Carrito</a>
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

  search.addEventListener('click', (e) => {
    if (e.target.closest('button')) searchProduct()
  })

  search.addEventListener('keypress', (e) => {
    if (e.key === 'Enter') searchProduct()
  })
</script>
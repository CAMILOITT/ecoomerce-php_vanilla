<?php

declare(strict_types=1);

use App\Controllers\CategoryController;

$categoryController = new CategoryController($conn);

$allCategories = $categoryController->getAllCategories();
$allSubcategories = $categoryController->getAllSubcategories();
?>

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

    h3 {
      font-size: 1.1rem;
      margin-bottom: 0.5rem;
      color: var(--color-primary);
    }

    h4 {
      font-size: 0.95rem;
      color: var(--color-text-muted);
    }
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


    li {
      list-style: none;
    }

    a {
      display: flex;
      align-items: center;
      gap: 0.5rem;
      width: 100%;
      padding: 8px 12px;
      font-weight: 500;
      border-radius: var(--border-s);
      transition: background 0.2s ease;
    }

    a:hover {
      background: var(--color-bg-light);
      color: var(--color-primary);
    }
  }

  .container-category {
    display: flex;
  }

  .category {
    display: flex;
    flex-direction: column;

  }

  .subcategory {
    display: none;
    opacity: 0;
    transform: translateY(10px);
    transition: opacity 0.3s ease, transform 0.3s ease;
    visibility: hidden;

    &.active {
      display: flex;
      flex-direction: column;
      gap: 0.3rem;
      opacity: 1;
      transform: translateY(0);
      visibility: visible;
    }
  }

  .category {
    padding-left: 0;
    display: flex;
    flex-direction: column;
    gap: 0.3rem;
    margin-bottom: 0.5rem;
    min-width: 120px;
    border-right: 1px solid var(--color-bg-light);
    margin-right: 1rem;

    li {
      padding: 6px 12px;
      cursor: pointer;
      border-radius: var(--border-s);
      transition: background 0.2s ease;

      &:hover {
        background: var(--color-bg-light);
        color: var(--color-primary);
      }
    }
  }

  /* style="padding-left: 0;" */
  /* style="display: flex; flex-direction: column; gap: .3rem; margin-bottom: 0.5rem;" */
</style>

<header class="header">
  <div class="logo">
    <div class="menu-category">
      <?php include_once 'assets/svg/icons/menu-deep.svg' ?>
      <div class="dropdown-category">
        <h3>Categorías</h3>
        <div class="container-category">
          <ul class="category" style="--category-name:<?= $category['name'] ?>;">
            <?php foreach ($allCategories as $category): ?>
              <li>
                <?= $category['name'] ?>
              </li>
            <?php endforeach; ?>
          </ul>
          <?php foreach ($allCategories as $category): ?>
            <ul class="subcategory" data-category="<?= $category['name'] ?>">
              <?php
              $listCategories = array_filter($allSubcategories, function ($item) use ($category) {
                return $item['parent_id'] === $category['id'];
              });
              foreach ($listCategories as $subcategory): ?>
                <li><a href="/products?category=<?= $subcategory['name'] ?>"><?= $subcategory['name'] ?></a></li>
              <?php endforeach; ?>
            </ul>
          <?php endforeach; ?>
        </div>
        <script>
          const categories = document.querySelectorAll('.category li');
          const subcategories = document.querySelectorAll('.subcategory');
          categories.forEach((cat) => {
            cat.addEventListener('mouseenter', () => {
              const name = cat.innerHTML.trim();
              subcategories.forEach((sub) => {
                sub.classList.toggle(
                  'active',
                  sub.dataset.category === name
                );
              });
            });
          });
        </script>
      </div>
    </div>
    <a href="/" style="display: flex; align-items: center; gap: 0.5rem;">
      <?php include_once 'assets/svg/icons/shopping-cart.svg' ?>
      <span>MINIMARKET</span>
    </a>
  </div>
  <?php include 'Search.php' ?>
  <div class="menu-profile">
    <?php include 'assets/svg/icons/profile.svg' ?>
    <ul class="dropdown-profile">
      <li>
        <a href="<?php echo '/profile' ?>"><?php include 'assets/svg/icons/profile.svg' ?> Mi Perfil</a>
      </li>
      <li>
        <a href="/shopping_cart"><?php include_once 'assets/svg/icons/shopping-bag.svg' ?> Ver Carrito</a>
      </li>
    </ul>
  </div>
</header>
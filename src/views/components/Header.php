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

    .btn-interaction {
      display: flex;
      justify-content: center;
      gap: clamp(.5rem, .001vw, 2rem);
      font-size: 2rem;

      &>div {
        display: flex;
        align-items: center;
      }
    }
  }

  @media (width <=590px) {
    .header {
      padding-inline: 4px;
    }

    .logo {
      span {
        display: none;
        font-size: 1.5rem;
      }
    }
  }
</style>

<header class="header">
  <div class="logo">
    <div class="menu">
      <?php include_once 'assets/svg/icons/menu-deep.svg' ?>
    </div>
    <?php include_once 'assets/svg/icons/shopping-cart.svg' ?>
    <span>MINIMARKET</span>
  </div>
  <div class="search">
    <input placeholder="buscar un producto..." type="search" name="user_search" id="UserSearch">
    <button><?php include_once 'assets/svg/icons/search.svg' ?></button>
  </div>
  <div class="btn-interaction">
    <div><?php include_once 'assets/svg/icons/shopping-bag.svg' ?></div>
    <div><?php include_once 'assets/svg/icons/profile.svg' ?></div>
  </div>
</header>

<style>
  .aside {
    position: absolute;

  }
</style>

<aside class="aside">
  <h2>Categoría</h2>
  <ul>
    <li><a href="">bebidas</a></li>
    <li><a href="">comestibles</a></li>
  </ul>
</aside>

<script></script>
<style>
  .card {
    border-radius: var(--border-xl);
    padding: 12px 12px;
    width: 200px;
    aspect-ratio: 4/5;
    background-color: red;
    position: relative;
    display: flex;
    flex-direction: column;
    justify-content: space-between;

    .card-attr {
      position: absolute;
      top: 12px;
      display: flex;
      align-items: center;
      justify-content: space-between;
      width: calc(100% - 10px *2);
      background: red;
    }

    .card-link {
      display: flex;
      align-items: center;
      justify-content: center;
      flex-direction: column;
      text-align: center;

      .item-name {
        font-weight: bold;
      }

      .item-description {
        font-size: .8rem;
      }
    }

    .img-container {
      border-radius: var(--border-m);
      overflow: hidden;
      width: 180px;
      aspect-ratio: 1/1;
      display: flex;
      align-items: center;
      justify-content: center;

      .card-img {
        object-position: center;
        width: 100%;
        height: 100%;
        aspect-ratio: 1/1;
      }
    }

    .item_amount {
      display: flex;
      justify-content: space-around;
      align-items: center;
      gap: .5rem;
      font-weight: bold;
      margin-block-start: .5rem;

    }
  }
</style>

<div class="card">
  <a href="/products/<?= $item['id'] ?>" class="card-link">
    <div class="card-attr">
      <?php if ($item['discount'] > 0): ?>
        <span class="item-discount">discount</span>
      <?php endif; ?>

      <span class="item-price">
        <?= $item['unit_price']; ?>
      </span>
    </div>
    <div class="img-container">
      <img src="https://i.pinimg.com/736x/82/7c/44/827c44b706d30d9d432776fab3ee998c.jpg" alt="img fruta" class="card-img">
    </div>
    <div class="card-info">
      <p class="item-name"><?= $item['name']; ?></p>
      <span class="item-description"><?= $item['description']; ?></span>
    </div>
  </a>
  <div class="item_amount">
    <button class="item-rest">-</button>
    <span class="item_amount-total">0</span>
    <button class="item-add">+</button>
  </div>
</div>
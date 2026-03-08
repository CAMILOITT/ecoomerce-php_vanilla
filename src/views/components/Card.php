<style>
  .card {
    background: var(--color-card-bg);
    border-radius: var(--border-xl);
    padding: clamp(.5rem, 2%, 1rem);
    width: clamp(150px, 15vw, 240px);
    aspect-ratio: 5/7;
    position: relative;
    display: flex;
    flex-direction: column;
    justify-content: space-between;
    box-shadow: var(--shadow-soft);
    transition: all 0.3s ease;
    cursor: pointer;

    &:hover {
      transform: translateY(-5px);
      box-shadow: var(--shadow-hover);
    }
  }

  .card-link {
    display: flex;
    flex-direction: column;
    height: 100%;
    color: inherit;
  }

  .img-container {
    position: relative;
    border-radius: var(--border-l);
    width: 100%;
    aspect-ratio: 1/1;
    /* height: 160px; */
    display: flex;
    align-items: center;
    justify-content: center;
    margin-bottom: 12px;
    padding: 1rem;
  }

  .card:nth-child(4n+1) .img-container {
    background: var(--color-pastel-orange);
  }

  .card:nth-child(4n+2) .img-container {
    background: var(--color-pastel-red);
  }

  .card:nth-child(4n+3) .img-container {
    background: var(--color-pastel-green);
  }

  .card:nth-child(4n+4) .img-container {
    background: var(--color-pastel-purple);
  }

  .card-img {
    width: 100%;
    height: 100%;
    object-fit: contain;
    filter: drop-shadow(0 10px 15px rgba(0, 0, 0, 0.1));
    transform: scale(1.1);
    transition: transform 0.3s ease;
  }

  .card:hover .card-img {
    transform: scale(1.15);
  }

  .item-discount {
    position: absolute;
    top: 12px;
    left: 12px;
    background: rgba(255, 255, 255, 0.9);
    color: var(--color-text);
    font-size: 0.75rem;
    font-weight: 700;
    padding: 4px 8px;
    border-radius: var(--pill);
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.05);
    z-index: 1;
  }

  .card-info {
    text-align: center;
    margin-bottom: auto;
  }

  .item-name {
    font-weight: 700;
    font-size: 1.1rem;
    color: var(--color-text);
    margin-bottom: 4px;
  }

  .item-description {
    font-size: 0.85rem;
    color: var(--color-text-muted);
    display: block;
    margin-bottom: 8px;
  }

  .card-footer {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-top: auto;
    padding-top: 10px;
  }

  .item-price {
    font-weight: 700;
    font-size: 1.2rem;
    color: var(--color-text);
  }

  .item-action-btn {
    background: white;
    border: 1px solid #EAEAEA;
    width: 32px;
    height: 32px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    color: var(--color-text);
    font-weight: bold;
    transition: all 0.2s ease;
    cursor: pointer;
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.02);
    padding: 0;

    &:hover {
      background: var(--color-primary);
      color: white;
      border-color: var(--color-primary);
    }
  }

  @media (width <=768px) {

    .item-price {
      font-size: 1rem;
    }

    .item-action-btn {
      width: 28px;
      height: 28px;
    }
  }
</style>

<div class="card">
  <?php if (isset($item['discount']) && $item['discount'] > 0): ?>
    <span class="item-discount"><?= $item['discount'] ?>% off</span>
  <?php endif; ?>

  <a href="/products/<?= $item['id'] ?>" class="card-link">
    <div class="img-container">
      <img src="https://cdn-icons-png.flaticon.com/512/2909/2909805.png" alt="img fruta" class="card-img">
    </div>

    <div class="card-info">
      <p class="item-name"><?= htmlspecialchars($item['name']); ?></p>
      <span class="item-description"><?= htmlspecialchars($item['description']); ?></span>
    </div>
  </a>

  <div class="card-footer">
    <span class="item-price">$<?= number_format((float) ($item['unit_price'] ?? 0), 2); ?></span>

    <button class="item-action-btn" aria-label="Add to cart">
      <?php include 'assets/svg/icons/more.svg' ?>
    </button>
  </div>
</div>
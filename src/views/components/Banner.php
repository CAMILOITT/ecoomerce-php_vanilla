<style>
  .banner-container {
    display: flex;
    align-items: center;
    justify-content: center;
    position: relative;
    padding: 1.5rem 4rem;
    border-radius: var(--border-xl);
    flex-wrap: wrap;
    gap: 2rem;
    width: 100%;
    height: 100%;
    aspect-ratio: 16/9;

    img {
      max-width: 100%;
      height: auto;
      object-fit: contain;
      filter: drop-shadow(0 20px 30px rgba(0, 0, 0, 0.15));
      border-radius: var(--border-xl);
    }
  }

  .floating-badge {
    position: absolute;
    top: 20%;
    right: 5%;
    background: white;
    padding: 12px 20px;
    border-radius: var(--pill);
    box-shadow: var(--shadow-soft);
    display: flex;
    align-items: center;
    gap: 10px;
    animation: float 3s ease-in-out infinite;

    .badge-icon {
      font-size: 1.5rem;
    }

    .badge-text {
      display: flex;
      flex-direction: column;

      strong {
        color: var(--color-primary);
        font-size: 0.9rem;
      }

      span {
        font-size: 0.7rem;
        color: var(--color-text-muted);
      }
    }
  }

  @keyframes float {
    0% {
      transform: translateY(0px);
    }

    50% {
      transform: translateY(-10px);
    }

    100% {
      transform: translateY(0px);
    }
  }

  @media (max-width: 768px) {
    .banner-container {
      padding: 2rem 1rem;
      text-align: center;
    }

    .floating-badge {
      display: none;
    }
  }
</style>

<div class="banner-container">
  <img src="/assets/img/banner/banner.png" alt="Fresh Groceries Bag">

  <!-- <div class="floating-badge">
        <span class="badge-icon">🍆</span>
        <div class="badge-text">
            <strong>51% OFF!</strong>
            <span>Get up to 2 qty at $19</span>
        </div>
    </div> -->
</div>
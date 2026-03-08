<style>
  .banner-container {
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding: 3rem 4rem;
    margin-bottom: 3rem;
    background: transparent;
    border-radius: var(--border-xl);
    flex-wrap: wrap;
    gap: 2rem;
  }

  .banner-content {
    flex: 1;
    min-width: 300px;
    max-width: 500px;
    z-index: 1;
  }

  .banner-content h1 {
    font-size: clamp(3rem, 5vw, 4.5rem);
    line-height: 1.1;
    color: var(--color-text);
    margin-bottom: 1rem;
    font-weight: 700;
  }

  .banner-content p {
    font-size: 1.1rem;
    color: var(--color-text-muted);
    margin-bottom: 2.5rem;
    line-height: 1.5;
    max-width: 80%;
  }

  .btn-shop-now {
    display: inline-flex;
    align-items: center;
    gap: 1rem;
    background: var(--color-primary);
    color: white;
    padding: 10px 10px 10px 32px;
    border-radius: var(--pill);
    font-size: 1.1rem;
    font-weight: 600;
    box-shadow: 0 8px 20px rgba(240, 90, 40, 0.3);
    transition: all 0.3s ease;
    text-decoration: none;
  }

  .btn-shop-now:hover {
    transform: translateY(-2px);
    box-shadow: 0 12px 25px rgba(240, 90, 40, 0.4);
    color: white;
  }

  .btn-icon-wrapper {
    background: white;
    color: var(--color-primary);
    width: 40px;
    height: 40px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
  }
  
  .btn-icon-wrapper svg {
      width: 20px;
      height: 20px;
  }

  .banner-image {
    flex: 1;
    position: relative;
    display: flex;
    justify-content: center;
    align-items: center;
    min-width: 300px;
  }

  .banner-image img {
    max-width: 100%;
    height: auto;
    object-fit: contain;
    filter: drop-shadow(0 20px 30px rgba(0,0,0,0.15));
    transform: scale(1.1);
  }
  
  /* Floating badge example */
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
  }
  
  .badge-icon {
      font-size: 1.5rem;
  }
  
  .badge-text {
      display: flex;
      flex-direction: column;
  }
  
  .badge-text strong {
      color: var(--color-primary);
      font-size: 0.9rem;
  }
  
  .badge-text span {
      font-size: 0.7rem;
      color: var(--color-text-muted);
  }

  @keyframes float {
      0% { transform: translateY(0px); }
      50% { transform: translateY(-10px); }
      100% { transform: translateY(0px); }
  }

  @media (max-width: 768px) {
    .banner-container {
      padding: 2rem 1rem;
      text-align: center;
    }
    
    .banner-content p {
        margin: 0 auto 2rem auto;
    }
    
    .floating-badge {
        display: none;
    }
  }
</style>

<div class="banner-container">
  <div class="banner-content">
    <h1>From farm to<br>your kitchen</h1>
    <p>Discover the freshest and finest groceries delivered quickly and conveniently.</p>
    <a href="/productos" class="btn-shop-now">
      Shop Now
      <div class="btn-icon-wrapper">
        <?php include_once 'assets/svg/icons/shopping-bag.svg' ?>
      </div>
    </a>
  </div>
  
  <div class="banner-image">
    <!-- Using a placeholder grocery bag image to match the provided layout structure -->
    <img src="/assets/img/banner/banner.png" alt="Fresh Groceries Bag" onerror="this.src='https://cdn-icons-png.flaticon.com/512/3081/3081986.png'; this.style.maxWidth='300px';">
    
    <div class="floating-badge">
        <span class="badge-icon">🍆</span>
        <div class="badge-text">
            <strong>51% OFF!</strong>
            <span>Get up to 2 qty at $19</span>
        </div>
    </div>
  </div>
</div>
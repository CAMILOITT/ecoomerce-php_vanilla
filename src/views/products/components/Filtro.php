<style>
  .filtro {
    width: 200px;
    margin: .5rem .7rem;
    background: var(--color-primary-light);
    border-radius: var(--border-m);
    display: flex;
    flex-direction: column;
    padding: .8rem 1rem;
    gap: .5lh;
    position: sticky;

    .filter-price {
      display: flex;
      gap: .5rem;
    }
  }
</style>

<div class="filtro">
  <h3>Filtro</h3>
  <h4>Precio</h4>
  <div class="filter-price">
    <input type="number" name="min_price" id="min-price" placeholder="min" min='0' style="width: 4rem;">
    <input type="number" name="max_price" id="max-price" placeholder="max" min='0' style="width: 4rem;">
  </div>
</div>
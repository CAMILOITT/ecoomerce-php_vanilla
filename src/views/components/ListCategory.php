<style>
  .item {
    color: var(--color-text);
  }
</style>

<div>
  <?php foreach (['cereal', 'leche', 'aceite', 'plátano'] as $item): ?>
    <a href="" class="item">
      <p><?= $item ?></p>
      <s></s><img src="" alt="">
    </a>
  <?php endforeach; ?>
</div>
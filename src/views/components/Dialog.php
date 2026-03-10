<?php

declare(strict_types=1);
// var_dump($dialogContent);
if (!$dialogContent) $dialogContent = 'contenido del dialogo'
?>

<style>
  .dialog {
    width: clamp(300px, 80%, 70vw);
    border-radius: var(--border-l);
    position: relative;

    &::backdrop {
      background-color: rgba(0, 0, 0, 0.5);
    }

    .close {
      position: absolute;
      top: 1rem;
      right: 1rem;

    }
  }
</style>

<dialog class="dialog <?= $class ?? '' ?> <?= $attr ?? '' ?>  ">
  <form method='dialog' class='close'>
    <button class='<?= $classBtn ?? "" ?>'><?php include 'assets/svg/icons/close.svg' ?></button>
  </form>
  <?= $dialogContent ?>
</dialog>
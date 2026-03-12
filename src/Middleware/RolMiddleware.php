<?php

declare(strict_types=1);

namespace App\Middleware;

class RolMiddleware
{
  public function handle()
  {
    if (!isset($_SESSION['id'])) {
      header('Location: /session/login');
      exit();
    }
  }

  public function handleAdmin()
  {
    if (!isset($_SESSION['id'])) {
      header('Location: /session/login');
      exit();
    }
  }
}

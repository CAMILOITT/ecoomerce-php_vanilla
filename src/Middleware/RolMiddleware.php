<?php

declare(strict_types=1);

namespace App\Middleware;

class RolMiddleware
{
  public function handle()
  {
    session_start();
    if (!isset($_SESSION['id'])) {
      header('Location: /session/login');
      exit();
    }
  }

  public function handleAdmin()
  {
    session_start();
    if (!isset($_SESSION['id'])) {
      header('Location: /session/login');
      exit();
    }
  }
}

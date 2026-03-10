<?php

declare(strict_types=1);

namespace App\Helpers;

class Csrf
{
  /**
   * Genera y almacena un token CSRF en la sesión si no existe uno.
   */
  public static function generateToken(): void
  {
    if (empty($_SESSION['csrf_token'])) {
      $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
    }
  }

  /**
   * Verifica si el token enviado coincide con el de la sesión.
   */
  public static function verifyToken(string $submittedToken): bool
  {
    return isset($_SESSION['csrf_token']) && hash_equals($_SESSION['csrf_token'], $submittedToken);
  }

  public static function csrfInput(): string
  {
    return '<input type="hidden" name="csrf_token" value="' . ($_SESSION['csrf_token'] ?? '') . '">';
  }
}

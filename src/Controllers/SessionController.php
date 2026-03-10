<?php

declare(strict_types=1);

namespace App\Controllers;

use PDO;
use App\Utils\HandleHttp;
use App\Types\CodeStatusHttp;
use App\Helpers\Csrf;


class SessionController
{
  public function __construct(private PDO $connection) {}

  public function register() {}

  public function logout()
  {
    session_destroy();
    HandleHttp::response(CodeStatusHttp::OK, ['success' => true, 'redirect' => '/session/login', 'message' => 'Logout successful']);
  }

  public function loginCustomer(string $userEmail, string $password)
  {
    // 1. Extraer y verificar el token CSRF del formulario.
    // $token = $_POST['csrf_token'] ?? '';
    // if (!Csrf::verifyToken($token)) {
    //   HandleHttp::error(CodeStatusHttp::FORBIDDEN, 'Solicitud no válida (Invalid CSRF token).');
    //   return;
    // }

    $userData = (new CustomerController($this->connection))->getByEmail($userEmail);
    if (!$userData) {
      HandleHttp::error(CodeStatusHttp::UNAUTHORIZED, 'Invalid credentials');
      return;
    }
    if (!password_verify($password, $userData['password'])) {
      HandleHttp::error(CodeStatusHttp::UNAUTHORIZED, 'Invalid credentials');
      return;
    }
    session_regenerate_id(true);
    $_SESSION['id'] = $userData['id'];
    HandleHttp::response(CodeStatusHttp::OK, ['success' => true, 'message' => 'Login successful']);
  }

  public function loginStaff(string $userEmail, string $password)
  {
    // 1. Extraer y verificar el token CSRF del formulario.
    // $token = $_POST['csrf_token'] ?? '';
    // if (!Csrf::verifyToken($token)) {
    //   HandleHttp::error(CodeStatusHttp::FORBIDDEN, 'Solicitud no válida (Invalid CSRF token).');
    //   return;
    // }

    // NOTA: El método getByEmail en StaffController necesita ser implementado.
    $userData = (new StaffController($this->connection))->getByEmail($userEmail);
    if (!$userData) {
      HandleHttp::error(CodeStatusHttp::UNAUTHORIZED, 'Invalid credentials');
      return;
    }
    if (!password_verify($password, $userData['password'])) {
      HandleHttp::error(CodeStatusHttp::UNAUTHORIZED, 'Invalid credentials');
      return;
    }
    session_regenerate_id(true);
    $_SESSION['id'] = $userData['id'];
    HandleHttp::response(CodeStatusHttp::OK, ['success' => true, 'redirect' => '/admin/dashboard', 'message' => 'Login successful']);
  }
}

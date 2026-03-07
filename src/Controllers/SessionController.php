<?php

declare(strict_types=1);

namespace App\Controllers;

use PDO;
use App\Utils\HandleHttp;
use App\Types\CodeStatusHttp;

class SessionController
{
  public function __construct(private PDO $connection) {}

  public function register() {}

  public function logout()
  {
    session_destroy();
    HandleHttp::response(CodeStatusHttp::OK, ['success' => true, 'redirect' => '/session/login', 'message' => 'Logout successful']);
  }

  public function login(string $userEmail, string $password)
  {
    $userData = (new UserController($this->connection))->getUserByEmail($userEmail);

    if (isset($userData)) {
      HandleHttp::error(CodeStatusHttp::UNAUTHORIZED, 'Invalid credentials');
      return;
    }
    if (!password_verify($password, $userData['password'])) {
      HandleHttp::error(CodeStatusHttp::UNAUTHORIZED, 'Invalid credentials');
      return;
    }
    session_start();
    $_SESSION['id'] = $userData['id'];
    HandleHttp::response(CodeStatusHttp::OK, ['success' => true, 'redirect' => '/admin/dashboard', 'message' => 'Login successful']);
  }
}

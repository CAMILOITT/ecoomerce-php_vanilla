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

  public function register()
  {
    $data = $this->getJsonInput();
    if (!$data) return;

    $name = $data['name'] ?? '';
    $lastname = $data['lastname'] ?? '';
    $dni = $data['dni'] ?? '';
    $email = $data['email'] ?? '';
    $password = $data['password'] ?? '';

    // Validations
    if (!$name || !$lastname || !$dni || !$email || !$password) {
      HandleHttp::error(CodeStatusHttp::BAD_REQUEST, 'Todos los campos son obligatorios');
      return;
    }

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
      HandleHttp::error(CodeStatusHttp::BAD_REQUEST, 'El correo electrónico no es válido');
      return;
    }

    $customerController = new CustomerController($this->connection);
    
    // Check if email already exists
    if ($customerController->getByEmail($email)) {
      HandleHttp::error(CodeStatusHttp::CONFLICT, 'El correo electrónico ya está registrado');
      return;
    }

    // Hash password
    $hashedPassword = password_hash($password, PASSWORD_BCRYPT);

    $success = $customerController->createCustomer([
      'name' => $name,
      'lastname' => $lastname,
      'dni' => $dni,
      'email' => $email,
      'password' => $hashedPassword,
      'document_id' => 1 // Default to Cédula
    ]);

    if ($success) {
       HandleHttp::response(CodeStatusHttp::OK, ['success' => true, 'message' => 'Registro exitoso']);
    } else {
       HandleHttp::error(CodeStatusHttp::INTERNAL_SERVER_ERROR, 'Error al crear la cuenta');
    }
  }

  private function getJsonInput(): ?array
  {
    $raw = file_get_contents('php://input');
    $data = json_decode($raw, true);

    if (json_last_error() !== JSON_ERROR_NONE) {
      HandleHttp::error(CodeStatusHttp::BAD_REQUEST, 'Datos JSON inválidos');
      return null;
    }

    return $data;
  }

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

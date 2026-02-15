<?php

declare(strict_types=1);

namespace App\Controllers;

use PDO;

class SessionController
{
  public function __construct() {}

  public function register(PDO $pdo) {}

  public function login(string $user, string $password, PDO $connection)
  {
    $stmt = $connection->prepare('SELECT * FROM staff WHERE username = :username');
    $stmt->bindParam(':username', $user);
    $stmt->execute();
    $userData = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$userData) {
      http_response_code(401);
      exit('Invalid credentials');
    }
    if (!password_verify($password, $userData['password'])) {
      http_response_code(401);
      exit('Invalid credentials');
    }

    // Aquí podrías generar un token JWT o iniciar una sesión
    echo 'Login successful';
  }
}


// Note: Aprende a usar la funcion CALCULATE en DAX de Power Pivot y Power BI

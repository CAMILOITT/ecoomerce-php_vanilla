<?php

declare(strict_types=1);

namespace App\Controllers;

use PDO;

class UserController
{
  public function __construct(private PDO $connection) {}

  public function getUserById($id)
  {
    $stmt = $this->connection->prepare("SELECT * FROM users WHERE id = :id");
    $stmt->bindParam(':id', $id, PDO::PARAM_INT);
    $stmt->execute();
    return $stmt->fetch(PDO::FETCH_ASSOC);
  }

  public function updateUser($id, $data)
  {
    $stmt = $this->connection->prepare("UPDATE users SET name = :name, email = :email WHERE id = :id");
    $stmt->bindParam(':id', $id, PDO::PARAM_INT);
    $stmt->bindParam(':name', $data['name'], PDO::PARAM_STR);
    $stmt->bindParam(':email', $data['email'], PDO::PARAM_STR);
    return $stmt->execute();
  }

  public function getUserByEmail($email)
  {
    $stmt = $this->connection->prepare("SELECT * FROM users WHERE email = :email");
    $stmt->execute([':email' => $email]);
    return $stmt->fetch(PDO::FETCH_ASSOC);
  }
}

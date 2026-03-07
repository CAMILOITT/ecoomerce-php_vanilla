<?php

declare(strict_types=1);

namespace App\Model;

use PDO;

class CustomerModel
{
  public function __construct(private PDO $conn) {}
  public function getAll()
  {
    $stmt = $this->conn->prepare('SELECT * FROM customers');
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
  }
}

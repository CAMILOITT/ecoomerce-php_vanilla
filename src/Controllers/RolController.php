<?php

declare(strict_types=1);


namespace App\Controllers;

use PDO;

class RolController
{

  private $table = 'roles';

  public function __construct(private PDO $conn) {}

  public function getAll(int $start, int $limit)
  {
    $stmt = $this->conn->prepare("SELECT * FROM {$this->table} LIMIT :start, :limit");
    $stmt->bindParam(':start', $start, PDO::PARAM_INT);
    $stmt->bindParam(':limit', $limit, PDO::PARAM_INT);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
  }
}

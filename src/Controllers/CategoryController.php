<?php

declare(strict_types=1);

namespace App\Controllers;

use PDO;

class CategoryController
{

  private $table = 'categories';

  public function __construct(private PDO $conn) {}

  public function getAll(int $page = 0, int $limit = 10)
  {
    $offset = $page * $limit;
    $stmt = $this->conn->prepare("SELECT * FROM {$this->table} LIMIT :limit OFFSET :offset");
    $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
    $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
  }

  public function getAllCategories()
  {
    $stmt = $this->conn->prepare("SELECT * FROM {$this->table} where parent_id IS NULL");
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
  }

  public function getAllSubcategories()
  {
    $stmt = $this->conn->prepare("SELECT * FROM {$this->table} where parent_id IS NOT NULL");
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
  }
}

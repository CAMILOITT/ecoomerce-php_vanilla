<?php

declare(strict_types=1);

namespace App\Controllers;

use PDO;

class CategoryController
{

  private $table = 'categories';

  public function __construct(private PDO $conn) {}

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

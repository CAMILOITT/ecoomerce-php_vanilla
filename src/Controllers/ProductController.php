<?php

declare(strict_types=1);


namespace App\Controllers;

use PDO;

class ProductController
{

  private $table = 'products';

  public function __construct(private PDO $conn) {}

  public function getAllProducts(int $start, int $limit)
  {
    $stmt = $this->conn->prepare("SELECT * FROM {$this->table} LIMIT :start, :limit");
    $stmt->bindParam(':start', $start, PDO::PARAM_INT);
    $stmt->bindParam(':limit', $limit, PDO::PARAM_INT);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
  }

  public function getRandomProducts(int $limit)
  {
    $stmt = $this->conn->prepare("SELECT * FROM {$this->table} ORDER BY RAND() LIMIT :limit");
    $stmt->bindParam(':limit', $limit, PDO::PARAM_INT);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC) ?? [];
  }

  public function getProductById(int $id)
  {
    $stmt = $this->conn->prepare("SELECT * FROM {$this->table} WHERE id = :id");
    $stmt->bindParam(':id', $id, PDO::PARAM_INT);
    $stmt->execute();
    return $stmt->fetch(PDO::FETCH_ASSOC) ?: null;
  }

  public function updateProductById(int $id, ...$props) {}
}

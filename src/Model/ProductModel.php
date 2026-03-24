<?php

declare(strict_types=1);

namespace App\Model;

use PDO;

class ProductModel
{

  private $table = 'products';

  public function __construct(private PDO $conn) {}

  public function getAll(int $start = 0, int $limit = 10)
  {
    $query = <<<SQL
      SELECT * FROM {$this->table} LIMIT :limit  OFFSET :start;
      SQL;
    $stmt = $this->conn->prepare($query);
    $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
    $stmt->bindValue(':start', $start, PDO::PARAM_INT);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
  }

  public function getRandom(int $limit)
  {
    $sql = <<<SQL
      SELECT * FROM {$this->table} ORDER BY RAND() LIMIT :limit
    SQL;
    $stmt = $this->conn->prepare("SELECT * FROM {$this->table} ORDER BY RAND() LIMIT :limit");
    $stmt->bindParam(':limit', $limit, PDO::PARAM_INT);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC) ?? [];
  }

  public function getById(int $id)
  {
    $stmt = $this->conn->prepare("SELECT * FROM {$this->table} WHERE id = :id");
    $stmt->execute([':id' => $id]);
    return $stmt->fetch(PDO::FETCH_ASSOC) ?: null;
  }

  public function updateById(int $id, ...$props) {}

  public function getByCategory(string $category)
  {
    $stmt = $this->conn->prepare("SELECT p.* FROM {$this->table} p JOIN categories c ON p.category_id = c.id WHERE c.name = :category");
    $stmt->bindParam(':category', $category, PDO::PARAM_STR);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC) ?? [];
  }

  public function getBySearch(string $search)
  {
    $stmt = $this->conn->prepare("SELECT * FROM {$this->table} WHERE name LIKE :search OR description LIKE :search");
    $likeSearch = '%' . $search . '%';
    $stmt->bindParam(':search', $likeSearch, PDO::PARAM_STR);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC) ?? [];
  }
}

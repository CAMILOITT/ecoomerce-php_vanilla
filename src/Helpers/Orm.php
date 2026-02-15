<?php

declare(strict_types=1);

namespace App\Helpers;

use PDO;

class ORM
{
  protected $id;
  protected $table;
  protected $db;

  public function __construct(int $id,  string $table, PDO $db,)
  {
    $this->id = $id;
    $this->db = $db;
    $this->table = $table;
  }

  public function find(): array
  {
    $stmt = $this->db->prepare("SELECT * FROM {$this->table} WHERE id = :id");
    $stmt->bindParam(':id', $this->id, PDO::PARAM_INT);
    $stmt->execute();
    return $stmt->fetch(PDO::FETCH_ASSOC);
  }

  public function delete(): bool
  {
    $stmt = $this->db->prepare("DELETE FROM {$this->table} WHERE id = :id");
    $stmt->bindParam(':id', $this->id, PDO::PARAM_INT);
    return $stmt->execute();
  }

  public function update(array $data): bool
  {
    $setClause = '';
    $params = [];
    foreach ($data as $column => $value) {
      $setClause .= "{$column} = :{$column}, ";
      $params[":{$column}"] = $value;
    }
    $setClause = rtrim($setClause, ', ');

    $stmt = $this->db->prepare("UPDATE {$this->table} SET {$setClause} WHERE id = :id");
    $params[':id'] = $this->id;

    return $stmt->execute($params);
  }
}

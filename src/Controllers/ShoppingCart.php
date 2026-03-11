<?php

declare(strict_types=1);

namespace App\Controllers;

use PDO;

class ShoppingCart
{
  public function __construct(private PDO $conn) {}
  public function getByCustomerId(int $customerId): array
  {
    $stmt = $this->conn->prepare("SELECT * FROM shopping_cart WHERE customer_id = :customerId");
    $stmt->execute(['customerId' => $customerId]);
    return $stmt->fetchAll();
  }
  public function getAllProductsByCustomerId(int $customerId): array
  {
    $query = "SELECT
    p.id,
    p.name,
    (p.unit_price * sc.amount) AS price,
    sc.amount
  FROM
    shopping_cart sc
    JOIN facturas.products p ON sc.products_id = p.id
  WHERE
    sc.customer_id = :customerId and  p.state = 1;
  ";
    $stmt = $this->conn->prepare($query);
    $stmt->execute([':customerId' => $customerId]);
    return $stmt->fetchAll();
  }
  public function update(int $productId, int $quantity, int $customerId): void
  {
    $stmt = $this->conn->prepare("UPDATE shopping_cart SET amount = :quantity WHERE products_id = :productId AND customer_id = :customerId");
    $stmt->execute(['quantity' => $quantity, 'productId' => $productId, 'customerId' => $customerId]);
  }

  public function delete(int $productId, int $customerId): void
  {
    $stmt = $this->conn->prepare("DELETE FROM shopping_cart WHERE products_id = :productId AND customer_id = :customerId");
    $stmt->execute(['productId' => $productId, 'customerId' => $customerId]);
  }
}

<?php

declare(strict_types=1);

namespace App\Controllers;

use PDO;

class CustomerController
{
  public function __construct(private PDO $pdo) {}
  public function getCustomerById(int $id)
  {
    $stmt = $this->pdo->prepare('SELECT * FROM customers WHERE id = :id');
    $stmt->execute([':id' => $id]);
    return $stmt->fetch(PDO::FETCH_ASSOC) ?: null;
  }
  public function getCustomerByEmail(string $email) {}
  public function createCustomer(...$props) {}
  public function updateCustomerById(int $id, ...$props) {}
  public function deleteCustomerById(int $id) {}
  public function getPurchaseHistoryByCustomerId(int $customerId)
  {
    $stmt = $this->pdo->prepare(
      "SELECT f.id, f.date, f.total
       FROM facturas f
       WHERE f.customer_id = :customerId
       ORDER BY f.date DESC;"
    );
    $stmt->execute([':customerId' => $customerId]);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
  }
  public function getInformation(int $id)
  {
    $stmt = $this->pdo->prepare(
      "SELECT
          c.name, c.dni, c.address, c.phone, c.email,
          d.name AS type_document
        FROM facturas.customers c
        INNER JOIN facturas.documents d
        ON c.document_id = d.id
        WHERE c.id = :id;"
    );
    $stmt->execute([':id' => $id]);
    return $stmt->fetch() ?: null;
  }
}


// Note: Aprende a usar la funcion CALCULATE en DAX de Power Pivot y Power BI

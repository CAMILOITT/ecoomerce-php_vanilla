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
  public function getByEmail(string $email)
  {
    $query = "SELECT * FROM customers WHERE email = :email";
    $stmt = $this->pdo->prepare($query);
    $stmt->execute([':email' => $email]);
    return $stmt->fetch(PDO::FETCH_ASSOC);
  }
  public function createCustomer(array $props)
  {
    $query = "INSERT INTO customers (document_id, name, lastname, dni, address, phone, email, password, state, created_at, updated_at) 
              VALUES (:document_id, :name, :lastname, :dni, :address, :phone, :email, :password, :state, NOW(), NOW())";
    $stmt = $this->pdo->prepare($query);
    return $stmt->execute([
      ':document_id' => $props['document_id'] ?? 1, // Defaulting to 1 if not provided, assuming it's a valid ID
      ':name' => $props['name'],
      ':lastname' => $props['lastname'],
      ':dni' => $props['dni'],
      ':address' => $props['address'] ?? '',
      ':phone' => $props['phone'] ?? '',
      ':email' => $props['email'],
      ':password' => $props['password'],
      ':state' => 1 // Active by default
    ]);
  }
  public function updateCustomerById(int $id, ...$props) {}
  public function deleteCustomerById(int $id) {}
  public function getPurchaseHistoryByCustomerId(int $customerId)
  {
    $stmt = $this->pdo->prepare(
      "SELECT s.id, st.name, st.lastname,  s.bill_date, s.total
      FROM facturas.sales s 
      inner JOIN  facturas.staff st on 
      s.staff_id = st.id
      where s.customer_id = :customerId
      ORDER by bill_date DESC
      LIMIT 50;"
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
  public function getSaleDetailsById(int $saleId)
  {
    $stmt = $this->pdo->prepare(
      "SELECT
        p.name,
        sp.quantity,
        sp.price AS unit_price
      FROM facturas.sales_products sp
      JOIN facturas.products p ON sp.product_id = p.id
      WHERE sp.sale_id = :saleId"
    );
    $stmt->execute([':saleId' => $saleId]);
    $details = $stmt->fetchAll(PDO::FETCH_ASSOC);

    $stmt = $this->pdo->prepare(
      "SELECT total FROM facturas.sales WHERE id = :saleId"
    );
    $stmt->execute([':saleId' => $saleId]);
    $sale = $stmt->fetch(PDO::FETCH_ASSOC);


    return [
      'details' => $details,
      'total' => $sale ? $sale['total'] : 0
    ];
  }
}


// Note: Aprende a usar la funcion CALCULATE en DAX de Power Pivot y Power BI

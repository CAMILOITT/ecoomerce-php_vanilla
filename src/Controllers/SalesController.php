<?php

declare(strict_types=1);

namespace App\Controllers;

use PDO;
use App\Controllers\Controller;

class SalesController extends Controller
{

  private $table = 'sales';

  public function getAll(int $page = 0, int $limit = 10)
  {
    $offset = $page * $limit;
    $stmt = $this->conn->prepare("SELECT
  s.id,
  s.subtotal,
  s.subtotal_iva,
  s.iva,
  s.total,
  s.bill_number,
  s.bill_date,
  st.name as staff_name,
  c.name as customer_name
FROM facturas.sales s
JOIN facturas.customers c ON c.id = s.customer_id
JOIN facturas.staff st ON st.id = s.staff_id
LIMIT :limit OFFSET :offset;");
    $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
    $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
  }

  public function getById()
  {
    $stmt = $this->conn->prepare("SELECT * FROM {$this->table}");
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
  }
}

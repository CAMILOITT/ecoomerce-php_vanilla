<?php

declare(strict_types=1);

namespace App\Controllers;

use PDO;

class DashboardController
{
  public function __construct() {}

  public function getBestProductsOfMonth(PDO $connection)
  {
    $query = 'SELECT p.name, COUNT(sd.product_id) as amount
              FROM sales_details sd
              JOIN products p ON sd.product_id = p.id
              JOIN sales s ON sd.sale_id = s.id
              WHERE MONTH(s.bill_date) = MONTH(CURRENT_DATE()) AND YEAR(s.bill_date) = YEAR(CURRENT_DATE())
              GROUP BY p.name
              ORDER BY amount DESC
              LIMIT 10;';
    $stmt = $connection->prepare($query);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
  }
}

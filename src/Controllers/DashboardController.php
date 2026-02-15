<?php

declare(strict_types=1);

namespace App\Controllers;

use PDO;

class DashboardController
{
  public function __construct() {}

  public function getBestProductsOfMonth(PDO $connection)
  {
    $stmt = $connection->prepare('SELECT name, count(name) as amount FROM products WHERE MONTH(created_at) = MONTH(CURRENT_DATE()) AND YEAR(created_at) = YEAR(CURRENT_DATE())');
    $stmt->execute();
    $bestProducts = $stmt->fetch(PDO::FETCH_ASSOC);

    return $bestProducts;
  }
}

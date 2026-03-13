<?php

declare(strict_types=1);

namespace App\Router;

use App\Helpers\HandleRouter;
use App\Model\ProductModel;
use App\Types\CodeStatusHttp;
use App\Utils\HandleHttp;
use PDO;

class ProductsRouter extends HandleRouter
{

  public function __construct(private PDO $conn)
  {
    parent::__construct('/api/v1');

    $this->get('/products', [], function () {
      $product = new ProductModel($this->conn);
      $limit = isset($_GET['limit']) ? (int)$_GET['limit'] : 10;
      $page = isset($_GET['page']) ? (int)$_GET['page'] * $limit : 0;
      $products = $product->getAll($page, $limit);
      HandleHttp::response(CodeStatusHttp::OK, $products);
    });
  }
}

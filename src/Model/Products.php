<?php

declare(strict_types=1);


namespace App\Model;

class Products
{

  public $nameTable = 'products';

  public function __construct() {}

  public function getAllProducts(int $start, int $limit) {}
  public function getProductById(int $id) {}
  public function updateProductById(int $id, ...$props) {}
}

<?php

declare(strict_types=1);


namespace App\Model;

use PDO;

class Category
{
  public function __construct(private PDO $connection)
  {
    throw new \Exception('Not implemented');
  }

  public function getAll() {}
}

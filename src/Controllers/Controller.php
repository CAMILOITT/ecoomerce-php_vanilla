<?php

declare(strict_types=1);

namespace App\Controllers;

use PDO;

abstract class Controller
{
  private $table;

  public function __construct(protected PDO $conn) {}

  abstract public function getAll(int $page = 0, int $limit = 10);
}

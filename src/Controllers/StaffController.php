<?php

declare(strict_types=1);

namespace App\Controllers;

use PDO;


class StaffController extends Controller
{
  private $table = 'staff';

  public function getAll(int $page = 0, int $limit = 10)
  {
    $offset = $page * $limit;
    $stmt = $this->conn->prepare("SELECT 
    s.id as id,
    s.name as nombre,
    s.lastname as apellido,
    s.email as correo
    FROM facturas.staff s
    LIMIT :limit OFFSET :offset;");
    $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
    $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
  }
}

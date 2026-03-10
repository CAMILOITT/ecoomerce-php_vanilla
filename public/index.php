<?php

declare(strict_types=1);

session_set_cookie_params([
  'lifetime' => 0,
  'secure' => false,
  'httponly' => true,
]);
session_start();

require_once __DIR__ . '/../vendor/autoload.php';
require_once __DIR__ . '/../src/Config/Database.php';
require_once __DIR__ . '/../src/Helpers/App.php';

use App\Config\Database;
use App\Helpers\App;

$pdo = new Database();
$conn = $pdo->getConn();

if (!$conn) {
  die('Error al conectar a la base de datos');
}

$app = new App($conn);
$app->render();

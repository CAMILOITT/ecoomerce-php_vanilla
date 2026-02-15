<?php

declare(strict_types=1);

namespace App\Config;

require_once __DIR__ . '/../../vendor/autoload.php';

use Dotenv\Dotenv;
use PDO;
use Exception;

class Database
{
  private ?PDO $connection;

  public function __construct()
  {
    $dotenv = Dotenv::createImmutable(__DIR__ . '/../../');
    $dotenv->load();
    $DSN = $_ENV['DATABASE_URL'] ?? '';
    if (!$DSN) throw new Exception('Url de la base de datos no esta configurada en las variables de entorno');
    $PASSWORD = $_ENV['DATABASE_PASSWORD'] ?? '';
    if (!$PASSWORD) throw new Exception('DATABASE_PASSWORD is not set in the environment variables.');
    $USERNAME = $_ENV['DATABASE_USERNAME'] ?? '';
    if (!$USERNAME) throw new Exception('DATABASE_USERNAME is not set in the environment variables.');

    $this->connection = new PDO($DSN, $USERNAME, $PASSWORD,    [
      PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
      PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    ]);
  }

  public function getConn(): PDO
  {
    return $this->connection;
  }

  public function closeConnection()
  {
    $this->connection = null;
  }
}

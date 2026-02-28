<?php

declare(strict_types=1);

namespace App\Helpers;

use App\Controllers\DashboardController;
use App\Controllers\SessionController;
use App\Controllers\UserController;
use App\Helpers\Router;
use PDO;
use App\Types\CodeStatusHttp;
use App\Utils\HandleHttp;

class App
{
  private string $baseViews;
  private string $uri;

  function __construct(private PDO $conn)
  {
    $this->baseViews = realpath(__DIR__ . '/../views');
    $uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
    $uri = trim($uri, '/');
    $this->uri = $uri;
  }

  function render()
  {
    $conn = $this->conn;
    $path_req = realpath($this->baseViews . "/{$this->uri}/index.php");

    if ($this->uri === 'api/v1/register') {
      $raw = file_get_contents('php://input');
      $data = json_decode($raw, true);
      // ** Nota a;adir un manejador de controller y codigo tipados
      // ** intanciamiento desde el index
      // ** auto import con diferentes layouts.
      // ** auto seo e img.
      // ** a;adir auth
      if (!$data) {
        HandleHttp::error(CodeStatusHttp::BAD_REQUEST, 'Datos JSON inválidos');
        return;
      }

      if (json_last_error() !== JSON_ERROR_NONE) {
        HandleHttp::error(CodeStatusHttp::BAD_REQUEST, 'Error al parsear JSON: ' . json_last_error_msg());
      }
      $bestProducts = new DashboardController();
      $bestProducts->getBestProductsOfMonth($this->conn);
      header('Content-Type: application/json'); // !A;adir por defecto en el controller o peticion, (un manejador de content-type)
      echo json_encode($bestProducts);
      return;
    }

    if ($this->uri === 'api/v1/logout') {
      $session = new SessionController($this->conn);
      $session->logout();
    }

    if ($this->uri === 'api/v1/login') {
      $raw = file_get_contents('php://input');
      $data = json_decode($raw, true);
      if (!$data) {
        HandleHttp::error(CodeStatusHttp::BAD_REQUEST, 'Datos JSON inválidos');
        return;
      }

      if (json_last_error() !== JSON_ERROR_NONE) {
        HandleHttp::error(CodeStatusHttp::BAD_REQUEST, 'Error al parsear JSON: ' . json_last_error_msg());
        return;
      }

      $userEmail = $data['email'] ?? '';
      $password = $data['password'] ?? '';
      if ($userEmail === "" || $password === "") {
        HandleHttp::error(CodeStatusHttp::BAD_REQUEST, 'Usuario y contraseña son requeridos');
        return null;
      }
      $connection = $this->conn;
      $session = new SessionController($connection);
      $session->login($userEmail, $password);
      return;
      // HandleHttp::redirect('/admin/dashboard');
      // exit();
    }
    // echo $this->baseViews;
    // echo $this->uri;
    // echo '\n';

    // if (!$path_req) {
    //   $path_req = realpath(__DIR__ . "/../src/views/{$this->uri}" .  '/index.php');
    //   echo '</ br>'; probar diferentes rutas para ver si se encuentra el archivo
    //   echo __DIR__ . "/../src/views/{$this->uri}" .  '/index.php';
    //   // $path_req = realpath(__DIR__ . "/../src/views/{$this->uri}" . '[product]' . 'index.php');
    //   return;
    // }

    // echo $path_req;


    // if (!$path_req) {
    //   http_response_code(404);
    //   exit('404');
    // }

    include_once $path_req;
  }

  function router(Router $router)
  {
    $router->dispatch();
  }

  function redirect() {}
}

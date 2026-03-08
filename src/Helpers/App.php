<?php

declare(strict_types=1);

namespace App\Helpers;

use App\Controllers\DashboardController;
use App\Controllers\ProductController;
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

  function handleFrontend()
  {
    $path_dir = realpath($this->baseViews . "/{$this->uri}/");
    $conn = $this->conn;

    if (!$path_dir) {
      $uri = join('/', array_slice(explode('/', $this->uri), 0, -1));
      $path_dir = realpath($this->baseViews . "/$uri");
      $dirs =  scandir($path_dir);
      $dir_match = null;
      foreach ($dirs as $dir) {
        if (preg_match('/\[*\]/', $path_dir . $dir)) {
          $dir_match = $dir;
          break;
        }
      }
      $path_content = realpath($path_dir  . "/$dir_match/index.php");
      $path_view = realpath($path_dir  . "/$dir_match/layout.php");

      if (!$path_content || !$path_view) {
        HandleHttp::error(CodeStatusHttp::NOT_FOUND, 'Página no encontrada');
        return;
      }

      include_once $path_view;
      return;
    }


    $path_content = realpath($this->baseViews . "/{$this->uri}/index.php");
    $path_view = realpath($this->baseViews . "/{$this->uri}/layout.php");
    // echo realpath($this->baseViews . "/{$this->uri}");
    // echo realpath($this->baseViews . "/{$this->uri}");
    // echo is_dir(realpath($this->baseViews . "/{$this->uri}"));
    // print_r(is_dir($this->uri));
    if (is_dir($path_content)) {
      $path_content = realpath($this->baseViews . "/{$this->uri}/index.php");
    }

    if (!$path_view) {
      $path_view = realpath($this->baseViews . "/{$this->uri}/../layout.php");
      include $path_view;
      return;
    }
    include $path_view;
  }

  function render()
  {
      // First try to resolve as an API route using ApiRouter
      $apiRouter = new \App\Router\ApiRouter($this->conn);
      
      // We pass the full URI so the router can match it to `/api/v1/...`
      // Notice we add a '/' to match the expected format in Router
      $matchedApiRoute = $apiRouter->dispatch('/' . $this->uri);
      
      if ($matchedApiRoute) {
          return;
      }

      // If it wasn't an API route, serve the frontend
      $this->handleFrontend();
  }
}

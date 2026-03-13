<?php

declare(strict_types=1);

namespace App\Helpers;

use App\Types\CodeStatusHttp;
use App\Utils\HandleHttp;
use Exception;
use PDO;

class Router
{
  private array $routes = [];

  public function __construct(private PDO $conn)
  {
    $this->registerRouter();
  }

  public function registerRouter()
  {
    $fileRouters = scandir(__DIR__ . '/../Router');
    foreach ($fileRouters as $file) {
      $file = trim($file, '.php');
      if (!$file) continue;
      $mwClass = "App\\Router\\" . $file;

      if (!class_exists($mwClass)) continue;
      $mwInstance = new $mwClass($this->conn);
      $routesInstance = $mwInstance->getRoutes();
      $this->routes = array_merge($this->routes, $routesInstance);
    }
  }

  public function dispatch()
  {
    $uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
    $method = $_SERVER['REQUEST_METHOD'];

    if (!isset($this->routes[$method][$uri])) return false;

    $route = $this->routes[$method][$uri];
    $action = $route['action'] ?? null;
    $routeMiddleware = $route['middleware'] ?? [];

    foreach ($routeMiddleware as $mw) {
      $mwClass = "App\\Middleware\\" . ucfirst($mw) . "Middleware";
      if (!class_exists($mwClass)) continue;
      $mwInstance = new $mwClass();
      if (!method_exists($mwInstance, 'handle')) continue;
      $mwInstance->handle();
    }

    if (is_callable($action)) {
      call_user_func($action);
      return true;
    }

    if (is_string($action)) {
      [$controller, $methodAction] = explode('@', $action);
      $controllerClass = "App\\Controllers\\$controller";
      if (!class_exists($controllerClass))
        throw new Exception("Controller no existe");
      $instance = new $controllerClass();
      if (!method_exists($instance, $methodAction))
        throw new Exception("Método no existe");
      call_user_func([$instance, $methodAction]);
      return true;
    }

    return false;
  }

  protected function getJsonInput(): ?array
  {
    $raw = file_get_contents('php://input');
    $data = json_decode($raw, true);

    if (!$data) {
      HandleHttp::error(CodeStatusHttp::BAD_REQUEST, 'Datos JSON inválidos');
      return null;
    }

    if (json_last_error() !== JSON_ERROR_NONE) {
      HandleHttp::error(CodeStatusHttp::BAD_REQUEST, 'Error al parsear JSON: ' . json_last_error_msg());
      return null;
    }

    return $data;
  }
}

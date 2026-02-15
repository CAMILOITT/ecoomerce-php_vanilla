<?php

declare(strict_types=1);

namespace App\Helpers;

class Router
{
  private array $routes = [];
  public string $baseUrl;

  public function __construct(?string $baseUrl = '/', ?array $middleware = [])
  {
    $this->baseUrl = $baseUrl;
  }

  public function get(string $uri, array | string $middleware, ?string $action): void
  {
    $completeUri = rtrim($this->baseUrl, '/') . '/' . ltrim($uri, '/');

    if (is_string($middleware)) $middleware = [$middleware];
    $this->routes['GET'][$this->normalize($completeUri)][] = $middleware;
    if ($action) $this->routes['GET'][$this->normalize($completeUri)][] = $action;
  }

  public function post(string $uri, array | string $middleware, ?string $action): void
  {
    $completeUri = rtrim($this->baseUrl, '/') . '/' . ltrim($uri, '/');
    if (is_string($middleware)) $middleware = [$middleware];
    $this->routes['POST'][$this->normalize($completeUri)][] = $middleware;
    if ($action) $this->routes['POST'][$this->normalize($completeUri)][] = $action;
  }

  public function dispatch(): void
  {
    $method = $_SERVER['REQUEST_METHOD'];
    $uri = $this->normalize(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH));

    if (!isset($this->routes[$method][$uri])) {
      http_response_code(404);
      echo '404';
      return;
    }

    [$controller, $methodAction] = explode('@', $this->routes[$method][$uri]);

    $controllerClass = "App\\Controllers\\$controller";

    if (!class_exists($controllerClass)) {
      throw new \Exception("Controller no existe");
    }

    $instance = new $controllerClass();

    if (!method_exists($instance, $methodAction)) {
      throw new \Exception("Método no existe");
    }

    call_user_func([$instance, $methodAction]);
  }

  private function normalize(string $uri): string
  {
    return rtrim($uri, '/') ?: '/';
  }
}


// class Router
// {
//   private string $basePath;
//   private array $routes = [];

//   public function __construct(string $basePath = '')
//   {
//     $this->basePath = $basePath;
//   }

//   public function get(string $path, string ...$handlers): void
//   {
//     $this->addRoute('GET', $path, $handlers);
//   }

//   public function post(string $path, string ...$handlers): void
//   {
//     $this->addRoute('POST', $path, $handlers);
//   }

//   private function addRoute(string $method, string $path, array $handlers): void
//   {
//     $this->routes[] = [
//       'method' => $method,
//       'path' => rtrim($this->basePath . $path, '/'),
//       'handlers' => $handlers,
//     ];
//   }

//   public function getRoutes(): array
//   {
//     return $this->routes;
//   }
// }

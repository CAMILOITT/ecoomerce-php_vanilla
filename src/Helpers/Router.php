<?php

declare(strict_types=1);

namespace App\Helpers;


class Router
{
  private array $routes = [];
  public string $baseUrl;
  protected ?array $middleware;

  public function __construct(?string $baseUrl = '/',  ?array $middleware = [])
  {
    $this->baseUrl = $baseUrl;
    $this->middleware = $middleware;
  }

  public function get(string $uri, array | string $middleware, ?string $action): void
  {
    $completeUri = rtrim($this->baseUrl, '/') . '/' . ltrim($uri, '/');

    if (is_string($middleware)) $this->middleware[] = $middleware;
    else $this->middleware = array_merge($this->middleware, $middleware);
    $this->routes['GET'][$this->normalize($completeUri)][] = $middleware;
    if (isset($action)) $this->routes['GET'][$this->normalize($completeUri)][] = $action;
  }

  public function post(string $uri, array | string $middleware, ?string $action): void
  {
    $completeUri = rtrim($this->baseUrl, '/') . '/' . ltrim($uri, '/');
    if (is_string($middleware)) $this->middleware[] = $middleware;
    else $this->middleware = array_merge($this->middleware, $middleware);
    $this->routes['POST'][$this->normalize($completeUri)][] = $middleware;
    if (isset($action)) $this->routes['POST'][$this->normalize($completeUri)][] = $action;
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
    if (!class_exists($controllerClass)) throw new \Exception("Controller no existe");
    $instance = new $controllerClass();
    if (!method_exists($instance, $methodAction)) throw new \Exception("Método no existe");
    call_user_func([$instance, $methodAction]);
  }

  private function normalize(string $uri): string
  {
    return rtrim($uri, '/') ?: '/';
  }
}

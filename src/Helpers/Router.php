<?php

declare(strict_types=1);

namespace App\Helpers;


class Router
{
  private array $routes = [];
  public string $baseUrl;
  protected ?array $middleware;

  public function __construct(?string $baseUrl = '/', ?array $middleware = [])
  {
    $this->baseUrl = $baseUrl;
    $this->middleware = $middleware;
  }

  public function get(string $uri, array|string $middleware, callable|string|null $action): void
  {
    $completeUri = rtrim($this->baseUrl, '/') . '/' . ltrim($uri, '/');

    if (is_string($middleware))
      $this->middleware[] = $middleware;
    else
      $this->middleware = array_merge($this->middleware, $middleware);
    $this->routes['GET'][$this->normalize($completeUri)]['middleware'] = $middleware;
    if (isset($action))
      $this->routes['GET'][$this->normalize($completeUri)]['action'] = $action;
  }

  public function post(string $uri, array|string $middleware, callable|string|null $action): void
  {
    $completeUri = rtrim($this->baseUrl, '/') . '/' . ltrim($uri, '/');
    if (is_string($middleware))
      $this->middleware[] = $middleware;
    else
      $this->middleware = array_merge($this->middleware, $middleware);
    $this->routes['POST'][$this->normalize($completeUri)]['middleware'] = $middleware;
    if (isset($action))
      $this->routes['POST'][$this->normalize($completeUri)]['action'] = $action;
  }

  public function put(string $uri, array|string $middleware, callable|string|null $action): void
  {
    $completeUri = rtrim($this->baseUrl, '/') . '/' . ltrim($uri, '/');
    if (is_string($middleware))
      $this->middleware[] = $middleware;
    else
      $this->middleware = array_merge($this->middleware, $middleware);
    $this->routes['PUT'][$this->normalize($completeUri)]['middleware'] = $middleware;
    if (isset($action))
      $this->routes['PUT'][$this->normalize($completeUri)]['action'] = $action;
  }

  public function delete(string $uri, array|string $middleware, callable|string|null $action): void
  {
    $completeUri = rtrim($this->baseUrl, '/') . '/' . ltrim($uri, '/');
    if (is_string($middleware))
      $this->middleware[] = $middleware;
    else
      $this->middleware = array_merge($this->middleware, $middleware);
    $this->routes['DELETE'][$this->normalize($completeUri)]['middleware'] = $middleware;
    if (isset($action))
      $this->routes['DELETE'][$this->normalize($completeUri)]['action'] = $action;
  }

  public function dispatch(string $uriOverride): bool
  {
    $method = $_SERVER['REQUEST_METHOD'];
    $uri = $this->normalize($uriOverride ?? parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH));

    if (!isset($this->routes[$method][$uri]))
      return false;

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
        throw new \Exception("Controller no existe");
      $instance = new $controllerClass();
      if (!method_exists($instance, $methodAction))
        throw new \Exception("Método no existe");
      call_user_func([$instance, $methodAction]);
      return true;
    }

    return false;
  }

  private function normalize(string $uri): string
  {
    return rtrim($uri, '/') ?: '/';
  }
}

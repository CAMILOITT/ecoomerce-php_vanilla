<?php

namespace App\Helpers;


class HandleRouter
{
  private array $routes = [];
  public string $baseUrl;
  protected ?array $middleware;

  public function __construct(?string $baseUrl = '/', ?array $middleware = [])
  {
    $this->baseUrl = $baseUrl;
    $this->middleware = $middleware;
  }

  public function getRoutes(): array
  {
    return $this->routes;
  }


  public function get(string $uri, array|string $middleware, callable|string|null $action = null): void
  {
    $this->registerRequest('GET', $uri, $middleware, $action);
  }

  public function post(string $uri, array|string $middleware, callable|string|null $action = null): void
  {
    $this->registerRequest('POST', $uri, $middleware, $action);
  }

  public function put(string $uri, array|string $middleware, callable|string|null $action = null): void
  {
    $this->registerRequest('PUT', $uri, $middleware, $action);
  }

  public function delete(string $uri, array|string $middleware, callable|string|null $action = null): void
  {
    $this->registerRequest("DELETE", $uri, $middleware, $action);
  }

  public function registerRequest(string $typeRequest = 'GET', string $uri, array|string $middleware, callable|string|null $action = null): void
  {
    $completeUri = rtrim($this->baseUrl, '/') . '/' . ltrim($uri, '/');
    if (is_string($middleware))
      $this->middleware[] = $middleware;
    else
      $this->middleware = array_merge($this->middleware, $middleware);
    $this->routes[$typeRequest][$this->normalize($completeUri)]['middleware'] = $middleware;
    if (isset($action))
      $this->routes[$typeRequest][$this->normalize($completeUri)]['action'] = $action;
  }

  private function normalize(string $uri): string
  {
    return rtrim($uri, '/') ?: '/';
  }
}

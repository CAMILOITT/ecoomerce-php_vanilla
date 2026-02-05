<?

namespace App\Core;

class Router
{
  private array $routes = [];

  public function get(string $uri, string $action): void
  {
    $this->routes['GET'][$this->normalize($uri)] = $action;
  }

  public function post(string $uri, string $action): void
  {
    $this->routes['POST'][$this->normalize($uri)] = $action;
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

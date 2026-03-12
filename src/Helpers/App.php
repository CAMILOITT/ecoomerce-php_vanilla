<?php

declare(strict_types=1);

namespace App\Helpers;

use PDO;
use App\Router\FrontendRouter;
use App\Router\ApiRouter;

class App
{
  private string $uri;
  private FrontendRouter $handleFrontend;

  function __construct(private PDO $conn)
  {
    $this->handleFrontend = new FrontendRouter($conn);
    $uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
    $uri = trim($uri, '/');
    $this->uri = $uri;
  }

  function render()
  {
    $apiRouter = new ApiRouter($this->conn);
    $matchedApiRoute = $apiRouter->dispatch('/' . $this->uri);

    if ($matchedApiRoute)
      return;

    $this->handleFrontend->dispatch();
  }
}

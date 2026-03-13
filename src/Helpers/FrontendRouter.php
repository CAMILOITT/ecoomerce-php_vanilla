<?php

declare(strict_types=1);

namespace App\Helpers;

use PDO;

class FrontendRouter
{
  protected string $baseViews;

  public function __construct(private PDO $conn, protected ?string $uri = '')
  {
    $this->baseViews = realpath(__DIR__ . '/../views');

    if (!$uri) {
      $uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
      $uri = trim($uri, '/');
    }

    $this->uri = $uri;
  }

  public function pageNotFound()
  {
    $pathDir = realpath($this->baseViews . '/404');
    $pathView = realpath($pathDir . '/layout.php');
    $pathContent  = realpath($pathDir . '/index.php');
    include $pathView;
  }

  public function pageUnauthorized()
  {
    $pathDir = realpath($this->baseViews . '/unauthorized');
    $pathView = realpath($pathDir . '/layout.php');
    $pathContent  = realpath($pathDir . '/index.php');
    include $pathView;
  }

  public function getLayout(string $pathUri)
  {
    if (!$pathUri) return realpath($this->baseViews .  "/layout.php");
    $pathUri = trim($pathUri, '/');

    if ($pathUri) $pathLayout = realpath($this->baseViews . "/$pathUri" . "/layout.php");
    if (!$pathLayout) return $this->getLayout(join('/', array_slice(explode('/', $pathUri), 0, -1)));
    return $pathLayout;
  }

  public function getDirectory()
  {
    $pathDir = realpath($this->baseViews . "/{$this->uri}");

    if (!$pathDir) {
      $uri = join('/', array_slice(explode('/', $this->uri), 0, -1));
      $pathDir = realpath($this->baseViews . "/$uri");
      $directories = scandir($pathDir);
      $dirMatch = null;
      foreach ($directories as $dir) {
        if (preg_match('/\[*\]/', $pathDir . $dir)) {
          $dirMatch = $dir;
          break;
        }
      }
      return realpath($pathDir . '/' . $dirMatch);
    }
    return $pathDir;
  }

  public function dispatch()
  {
    $conn = $this->conn;
    $pathDir = $this->getDirectory();

    if (!$pathDir) {
      $this->pageNotFound();
      return;
    }
    $pathLayout = $this->getLayout($this->uri);
    $path_content = realpath($pathDir . "/index.php");
    include $pathLayout;
  }
}

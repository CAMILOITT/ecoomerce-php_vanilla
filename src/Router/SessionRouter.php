<?php

declare(strict_types=1);

namespace App\Router;

use App\Helpers\HandleRouter;
use PDO;

class SessionRouter extends HandleRouter
{
  public function __construct(private PDO $conn)
  {
    parent::__construct('/session');

    $this->post('/login', 'SessionController@login');
    $this->post('/register',  'SessionController@register');
    $this->post('/logout', 'SessionController@logout');
  }
}

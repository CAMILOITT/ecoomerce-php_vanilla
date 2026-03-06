<?php

declare(strict_types=1);

namespace App\Router;

use App\Helpers\Router;

class SessionRouter extends Router
{
  public function __construct()
  {
    parent::__construct('/session');

    $this->post('/login', 'guest', 'SessionController@login');
    $this->post('/register', 'guest', 'SessionController@register');
    $this->post('/logout', 'auth', 'SessionController@logout');
  }
}

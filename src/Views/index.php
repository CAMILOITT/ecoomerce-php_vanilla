<?
require_once __DIR__ . '/../app/Core/Router.php';

use App\Core\Router;

$router = new Router();
$router->get('/users', 'UserController@index');
$router->dispatch();

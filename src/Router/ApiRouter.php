<?php

declare(strict_types=1);

namespace App\Router;

use App\Helpers\Router;
use App\Controllers\DashboardController;
use App\Controllers\SessionController;
use App\Controllers\ShoppingCart;
use App\Model\ProductModel;
use App\Types\CodeStatusHttp;
use App\Utils\HandleHttp;
use PDO;

class ApiRouter extends Router
{
  public function __construct(private PDO $conn)
  {
    parent::__construct('/api/v1');

    $this->get('/products', [], function () {
      $product = new ProductModel($this->conn);
      $page = isset($_GET['page']) ? (int)$_GET['page'] : 0;
      $limit = isset($_GET['limit']) ? (int)$_GET['limit'] : 10;
      $products = $product->getAll($page, $limit);
      HandleHttp::response(CodeStatusHttp::OK, $products);
    });

    $this->post('/register', [], function () {
      $data = $this->getJsonInput();
      if (!$data) return;
      $dashboard = new DashboardController();
      $bestProducts = $dashboard->getBestProductsOfMonth($this->conn);
      HandleHttp::response(CodeStatusHttp::OK, $bestProducts);
    });

    $this->post('/logout', [], function () {
      $session = new SessionController($this->conn);
      $session->logout();
      echo json_encode(['message' => 'Logged out successfully']);
    });

    $this->post('/login', [], function () {
      $data = $this->getJsonInput();
      if (!$data) return;
      $userEmail = $data['email'] ?? '';
      $password = $data['password'] ?? '';

      if (!$userEmail || !$password) {
        HandleHttp::error(CodeStatusHttp::BAD_REQUEST, 'Usuario y contraseña son requeridos');
        return;
      }

      $session = new SessionController($this->conn);
      $session->loginCustomer($userEmail, $password);
    });

    $this->get('/sale/{id}', ['id' => 'int'], function ($params) {
      $customerController = new \App\Controllers\CustomerController($this->conn);
      $saleDetails = $customerController->getSaleDetailsById($params['id']);
      header('Content-Type: application/json');
      echo json_encode($saleDetails);
    });

    $this->put('/shopping_cart/{id}', ['id' => 'int'], function ($params) {
      $data = $this->getJsonInput();
      if (!isset($_SESSION['customer_id'])) {
        HandleHttp::error(CodeStatusHttp::UNAUTHORIZED, 'No autorizado');
        return;
      }
      $shoppingCart = new ShoppingCart($this->conn);
      $shoppingCart->update($params['id'], $data['quantity'], $_SESSION['customer_id']);
    });

    $this->delete('/shopping_cart/{id}', ['id' => 'int'], function ($params) {
      if (!isset($_SESSION['customer_id'])) {
        HandleHttp::error(CodeStatusHttp::UNAUTHORIZED, 'No autorizado');
        return;
      }
      $shoppingCart = new ShoppingCart($this->conn);
      $shoppingCart->delete($params['id'], $_SESSION['customer_id']);
    });
  }

  private function getJsonInput(): ?array
  {
    $raw = file_get_contents('php://input');
    $data = json_decode($raw, true);

    if (!$data) {
      HandleHttp::error(CodeStatusHttp::BAD_REQUEST, 'Datos JSON inválidos');
      return null;
    }

    if (json_last_error() !== JSON_ERROR_NONE) {
      HandleHttp::error(CodeStatusHttp::BAD_REQUEST, 'Error al parsear JSON: ' . json_last_error_msg());
      return null;
    }

    return $data;
  }
}

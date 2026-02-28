<?php

namespace App\Utils;

use App\Types\CodeStatusHttp;


class HandleHttp
{
  public static function redirect(string $url)
  {
    header("Location: $url");
    exit();
  }

  public static function response(CodeStatusHttp $status, string|array $data)
  {
    http_response_code($status->value);
    header('Content-Type: application/json');
    echo json_encode(['data' => $data]);
  }

  public static function error(CodeStatusHttp $status, string $message)
  {
    http_response_code($status->value);
    header('Content-Type: application/json');
    echo json_encode(['error' => $message]);
  }
}

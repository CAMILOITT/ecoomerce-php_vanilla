<?php

declare(strict_types=1);

namespace App\Utils;

use Exception;

class HttpClient
{
  public static function fetchData(
    string $url,
    string $typeHttp = 'GET',
    array $headers = []
  ): array {
    $ch = curl_init($url);

    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, $typeHttp);

    curl_setopt($ch, CURLOPT_HTTPHEADER, array_merge([
      'Accept: application/json',
      'Content-Type: application/json',
    ], $headers));

    $response = curl_exec($ch);

    if ($response === false) {
      throw new Exception(curl_error($ch));
    }

    return json_decode($response, true);
  }
}

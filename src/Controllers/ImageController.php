<?php

declare(strict_types=1);

namespace App\Controllers;

class ImageController
{
  private $path = 'public/storage/products/';

  public function __construct() {}

  public function update(string $oldFileName, $newFile)
  {
    $newFileName = $this->upload($newFile);
    if ($newFileName) {
      $this->delete($oldFileName);
      return $newFileName;
    }
    return null;
  }

  public function upload($file)
  {
    if (!isset($file) || $file['error'] !== UPLOAD_ERR_OK) {
      return null;
    }

    $allowedMimeTypes = ['image/jpeg', 'image/png', 'image/webp'];
    $fileMimeType = mime_content_type($file['tmp_name']);

    if (!in_array($fileMimeType, $allowedMimeTypes)) {
      return null;
    }

    $extension = pathinfo($file['name'], PATHINFO_EXTENSION);
    $newFileName = uniqid() . '.' . $extension;
    $destination = $this->path . $newFileName;

    if (move_uploaded_file($file['tmp_name'], $destination)) {
      return $newFileName;
    }

    return null;
  }

  public function delete(string $fileName)
  {
    if (empty($fileName)) {
      return false;
    }

    $filePath = $this->path . $fileName;

    if (file_exists($filePath)) {
      return unlink($filePath);
    }

    return false;
  }
}

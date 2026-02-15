<?php

declare(strict_types=1);

namespace App\Model;

class User
{
  private $id;
  private $name;
  private $email;

  public function __construct($id, $name, $email)
  {
    $this->id = $id;
    $this->name = $name;
    $this->email = $email;
  }

  public function getId()
  {
    return $this->id;
  }

  public function getName()
  {
    return $this->name;
  }

  public function getAll()
  {
    return $this->email;
  }
}

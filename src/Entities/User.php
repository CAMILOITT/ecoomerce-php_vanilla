<?php

declare(strict_types=1);

namespace App\Entities;

class UserEntity
{
  private $id;
  private $name;
  private $email;
  private $password;

  public function __construct($id, $name, $email, $password)
  {
    $this->id = $id;
    $this->name = $name;
    $this->email = $email;
    password_hash($password, PASSWORD_DEFAULT);
    $this->password = $password;
  }

  public function getId()
  {
    return $this->id;
  }

  public function getName()
  {
    return $this->name;
  }

  public function getEmail()
  {
    return $this->email;
  }
}

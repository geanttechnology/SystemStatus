<?php
// Copyright © 2017 by SystemStatus.fr
// All rights reserved. This file or any portion thereof MUST contain the following copyrights.

abstract class User
{
  private $pdo, $ID;
  protected $table;

  public function __construct()
  {

  }

  public function getID()
  {
    return $ID;
  }
  
}

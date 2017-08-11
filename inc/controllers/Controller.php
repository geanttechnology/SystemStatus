<?php
// Copyright © 2017 by SystemStatus.fr
// All rights reserved. This file or any portion thereof MUST contain the following copyrights.

abstract class Controller
{

  private $templates;

  public function __construct(){

  }

  public function middleware($name)
  {
    $mw = new $name();
    $mw->handle();
  }
}

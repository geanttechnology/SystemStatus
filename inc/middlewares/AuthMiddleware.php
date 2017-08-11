<?php
// Copyright © 2017 by SystemStatus.fr
// All rights reserved. This file or any portion thereof MUST contain the following copyrights.

class AuthMiddleware extends Middleware
{
  public function handle()
  {
    if(!Auth::isActive()){
      if(!isset($_SESSION)) { session_start(); }
      session_destroy();
      header('Location: ' . APP_URL . '/login');
    }
  }
}

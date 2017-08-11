<?php
// Copyright © 2017 by SystemStatus.fr
// All rights reserved. This file or any portion thereof MUST contain the following copyrights.

class StatusMiddleware extends Middleware
{
  public function handle()
  {
    if(Api::isBanned()){
      $app = include(__DIR__ . "/../../config/app.php");
      header("Location: banned");
      exit(0);
    }
  }
}

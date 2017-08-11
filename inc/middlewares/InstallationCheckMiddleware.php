<?php
// Copyright © 2017 by SystemStatus.fr
// All rights reserved. This file or any portion thereof MUST contain the following copyrights.

class InstallCheckMiddleware extends Middleware
{
  public function handle()
  {
    if(App::isInstalled())
      header('Location: '.APP_URL.'/');

  }
}

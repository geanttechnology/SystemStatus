<?php
// Copyright © 2017 by SystemStatus.fr
// All rights reserved. This file or any portion thereof MUST contain the following copyrights.

class PluginsController extends Controller
{
  public function __construct(){

    AuthController::checkAuthStatus();
    SecurityController::checkAccess(3);

    $this->templates = new League\Plates\Engine('inc/views/admin');
    $this->templates->addFolder('layouts', 'inc/views/layouts/');

    $this->middleware('InstallMiddleware');
    $this->middleware('AuthMiddleware');
    $this->middleware('StatusMiddleware');
    $this->middleware('APIMiddleware');



  }

  public function home()
  {
    echo $this->templates->render('plugins');
  }



}

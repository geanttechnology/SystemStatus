<?php
// Copyright © 2017 by SystemStatus.fr
// All rights reserved. This file or any portion thereof MUST contain the following copyrights.

use \VisualAppeal\AutoUpdate;

class HomeController extends Controller
{

  public function __construct(){
    $this->templates = new League\Plates\Engine('inc/views/');
    $this->templates->addFolder('layouts', 'inc/views/layouts/');

    $this->middleware('InstallMiddleware');
    $this->middleware('APIMiddleware');
  }

  public function home()
  {
    $this->middleware('StatusMiddleware');
    echo $this->templates->render('home');
  }

  public function banned()
  {
    echo $this->templates->render('banned');
  }

}

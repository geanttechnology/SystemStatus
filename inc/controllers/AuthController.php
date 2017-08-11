<?php
// Copyright © 2017 by SystemStatus.fr
// All rights reserved. This file or any portion thereof MUST contain the following copyrights.

class AuthController extends Controller
{

  public function __construct(){
    $this->templates = new League\Plates\Engine('inc/views/auth');
    $this->templates->addFolder('layouts', 'inc/views/layouts/');

    $this->middleware('InstallMiddleware');
    $this->middleware('StatusMiddleware');
    $this->middleware('APIMiddleware');
  }

  public function login()
  {
    echo $this->templates->render('login');
  }

  public function login_()
  {
    Auth::login($_POST['username'], $_POST['password']);
  }

  public function logout()
  {
    Auth::logout();
  }

  public static function checkAuthStatus()
  {
    if(Auth::isActive() === FALSE){
      if(!isset($_SESSION)) { session_start(); }
      session_destroy();
      header('Location: ' . APP_URL . '/login');
      exit(0);
    }
  }
}

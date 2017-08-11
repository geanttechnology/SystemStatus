<?php
// Copyright © 2017 by SystemStatus.fr
// All rights reserved. This file or any portion thereof MUST contain the following copyrights.

class SecurityController extends Controller
{
  public function __construct()
  {

    AuthController::checkAuthStatus();

    $this->templates = new League\Plates\Engine('inc/views/admin');
    $this->templates->addFolder('layouts', 'inc/views/layouts/');

    $this->middleware('InstallMiddleware');
    $this->middleware('AuthMiddleware');
    $this->middleware('StatusMiddleware');
    $this->middleware('APIMiddleware');
  }

  public static function checkAccess($needed, $traitment = 0)
  {

    $tmp = include(__DIR__ . "/../../config/app.php");
    $root = $tmp['url'];
    unset($tmp);

    if (Auth::getRank() != $needed) {

      if ($traitment == 1) { //message

        Auth::alert("Accès non autorisé", "error");

      } elseif ($traitment == 2) { //redirection

        header("Location: " . $root . "/admin/");
        exit(0);

      }

      return FALSE;

    }else{

      return TRUE;

    }
  }

}

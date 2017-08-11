<?php
// Copyright © 2017 by SystemStatus.fr
// All rights reserved. This file or any portion thereof MUST contain the following copyrights.

class AdminController extends Controller
{

  public function __construct(){

    AuthController::checkAuthStatus();

    $this->templates = new League\Plates\Engine('inc/views/admin');
    $this->templates->addFolder('layouts', 'inc/views/layouts/');

    $this->middleware('InstallMiddleware');
    $this->middleware('AuthMiddleware');
    $this->middleware('StatusMiddleware');
    $this->middleware('APIMiddleware');

  }

  public function home()
  {
    echo $this->templates->render('home');
  }

  public function update_()
  {
    if(!empty($_POST['action']))
    {
      if(file_exists(__DIR__.'/../../update.php'))
        http_response_code(200);
      else
        http_response_code(404);
    }else{
      http_response_code(404);
    }
  }

  public function download()
  {
    $file = file_get_contents(API::getUpdateScript());
    file_put_contents(__DIR__.'/../../update.php', $file);
  }

  public function manageItems()
  {
    echo $this->templates->render('manageItems');
  }

  public static function checkAvailableUpdate($showMessage = 1)
  {

    //Init variable
    $updateAvailable = "";

    $version = file_get_contents('https://api.systemstatus.fr/version.txt');
    $version = explode("-", $version);
    $version = $version[0];

    $current_version = CMS_VERSION;

    if(strlen($version) == 4){ //v1.1----------------------------------------

      if($version[1] > $current_version[1]){ //v[1].1
        $updateAvailable = TRUE;
      }

      if($version[1] >= $current_version[1] && $version[3] > $current_version[3]){ //v[1].[1]
        $updateAvailable = TRUE;
      }

    }else if(strlen($version) == 6){ //v1.1.1----------------------------------------------

      if($version[1] > $current_version[1]){ //v[1].1.1
        $updateAvailable = TRUE;
      }

      if($version[1] >= $current_version[1] && $version[3] > $current_version[3]){ //v[1].[1]
        $updateAvailable = TRUE;
      }

      if($version[1] >= $current_version[1] && $version[3] >= $current_version[3] && $version[5] > $current_version[5]){ //v[1].[1].[1]
        $updateAvailable = TRUE;
      }

    }else{
      $updateAvailable = FALSE;
    }

    if ($updateAvailable === TRUE){

      if ($showMessage == 1):?>
          <div class="col-md-10">
              <div class="panel panel-info">
                  <div class="panel-body">
                      <div class="col-md-7">
                          <h5><i class="fa fa-magic"></i>&nbsp;Une nouvelle mise à jour est disponible</h5>
                      </div>
                      <span class="pull-right col-md-3">
                  <a href="<?= APP_URL ?>/admin/update"><button class="btn btn-info btn-sm col-md-12">Installer <i
                                  class="fa fa-download"></i></button></a>
              </span>
                  </div>
              </div>
          </div>
        <?php

      else:

        return TRUE;

      endif;


    }else{
      return FALSE;
    }

  }

  public function update()
  {
    echo $this->templates->render('update');
  }

  public static function getGlobalNews()
  {
    $api = new API();
    $result = $api->getGlobalNews()->data;

    return $result;
  }

  public static function getAccidentFontAwesomeIconByStatusId($int){
    switch ($int) {
      case 1:
        return "<i class='fa fa-check-circle-o'></i>";
        break;

      case 2:
        return "<i class='fa fa-exclamation-triangle'></i>";
        break;

      case 3:
        return "<i class='fa fa-bolt'></i>";
        break;

      case 4:
        return "<i class='fa fa-wrench'></i>";
        break;

      default:
        return "<i class='fa fa-times'></i>";
        break;
    }
  }

  public static function getTypeByStatusId($int){
    switch ($int) {
      case 1:
        return "success";
        break;

      case 2:
        return "warning";
        break;

      case 3:
        return "danger";
        break;

      case 4:
        return "info";
        break;

      default:
        return "default";
        break;
    }
  }

  public static function getIncidentStatus($int){
    switch ($int) {
      case 0:
        return "<span class='text-success'>Résolu <i class='fa fa-check-circle-o'></i></span>";
        break;

      case 1:
        return "<span class='text-danger'>En cours <i class='fa fa-refresh'></i></span>";
        break;

      default:
        return "<span class='text-warning'>ERROR</span>";
        break;
    }
  }

  public static function deleteDir($dirPath) {
    if (! is_dir($dirPath)) {
      throw new InvalidArgumentException("$dirPath must be a directory");
    }
    if (substr($dirPath, strlen($dirPath) - 1, 1) != '/') {
      $dirPath .= '/';
    }
    $files = glob($dirPath . '*', GLOB_MARK);
    foreach ($files as $file) {
      if (is_dir($file)) {
        self::deleteDir($file);
      } else {
        unlink($file);
      }
    }
    rmdir($dirPath);
  }

}

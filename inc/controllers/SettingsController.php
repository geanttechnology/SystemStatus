<?php
// Copyright © 2017 by SystemStatus.fr
// All rights reserved. This file or any portion thereof MUST contain the following copyrights.

class SettingsController extends Controller
{

  public function __construct()
  {

    AuthController::checkAuthStatus();
    SecurityController::checkAccess(3);

    $this->templates = new League\Plates\Engine('inc/views/admin');
    $this->templates->addFolder('layouts', 'inc/views/layouts/');

    $this->middleware('InstallMiddleware');
    $this->middleware('AuthMiddleware');
    $this->middleware('StatusMiddleware');
    $this->middleware('APIMiddleware');



  }

  public function settings()
  {
    echo $this->templates->render('settings');
  }

  public function update()
  {

    if (stristr($_POST['name'], '"') === FALSE AND stristr($_POST['name'], "'") === FALSE) {

      $replace = (empty($_POST['name'])) ? "SystemStatus CMS" : $_POST['name'];

      $search = array(APP_NAME);

      $file = file_get_contents(__DIR__ . '/../../config/app.php');
      $file = str_replace($search, $replace, $file);

      unset($replace);
      unset($search);

      if (file_put_contents(__DIR__ . '/../../config/app.php', $file)) {
        unset($file);

        echo Auth::alert('Votre configuration a été mise à jour avec succès ', 'success');
        Auth::DesignedRefresh(APP_URL . "/admin/settings");
      } else {
        echo Auth::alert('<strong>Attention : </strong> veuillez vérifier que le fichiers <code>config/app.php</code> existe bien et qu\'il a les droit nécessaire (<code>644</code>) !', 'error');
      }

    } else {
      echo Auth::alert('<strong>Attention : </strong> Les guillemet simples et doubles ne sont pas autorisés.', 'error');
    }
  }

  public function maintenance()
  {

    //If in maintenance
    if(app::inMaintenance()){
      unlink(__DIR__ . '/../../storage/maintenance');
    }else{
      file_put_contents(__DIR__ . '/../../storage/maintenance', '');
    }

  }

  public function reset($username, $password)
  {

    if(Auth::dialogLogin($username, $password) === TRUE){

      echo Auth::alert("Traitement en cours...", "info");

      $root = file_get_contents(__DIR__ . "/../../config/rootWebUrl");
      echo "<meta http-equiv=\"refresh\" content=\"3; URL=\"".$root."/install\">";

      //Unlink installation files
      $filesToDelete = [
        __DIR__ . '/../../config/app.php',
        __DIR__ . '/../../config/rootWebUrl',
        __DIR__."/../../storage/installed"
      ];
      foreach($filesToDelete as $file){
        if(file_exists($file)){
          unlink($file);
      }
      }
      //Unlink installation files [END] ////////////////////

      //Reset config file
      copy(__DIR__ . '/../../config/app.example.php', __DIR__ . '/../../config/app.php');
      echo Auth::alert("Succès ! Redirection en cours...", "success");

    }else{

      echo Auth::alert("Identifiants incorrects", "error");

    }

  }
}

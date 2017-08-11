<?php
// Copyright © 2017 by SystemStatus.fr
// All rights reserved. This file or any portion thereof MUST contain the following copyrights.

class ThemesController extends Controller
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
    echo $this->templates->render('themes');
  }

  public function edit($name)
  {
    define('THEME_NAME_', $name);
    echo $this->templates->render('edit_theme');
  }

  public function edit_()
  {
    if(!empty($_POST['file']) && !empty($_POST['content']) && !empty($_POST['theme']))
    {
      if(file_put_contents(__DIR__ . '/../../themes/' . $_POST['theme'] . '/'.$_POST['file'], $_POST['content']))
      {
        echo Auth::alert('Le fichier a été modifié avec succès !', 'success');
      }else{
        echo Auth::alert('Erreur, pendant la modification du fichier !', 'error');
      }
    }else{
      echo Auth::alert('Erreur, veuillez vérifier que votre fichier n\'est pas vide !', 'error');
    }
  }

  public function delete($name)
  {
    $theme = new Theme($name);
    $theme->delete();

    Auth::alert('Le thème ' . $name . ' a été supprimé avec succès !', 'success');
    Auth::DesignedRefresh(APP_URL . "/admin/themes");

  }

  public function active($name)
  {
    $theme = new Theme($name);
    if($theme->isTheme()){
      $search  = array(THEME_NAME);
      $replace = array($name);

      $file = file_get_contents(__DIR__ . '/../../config/app.php');
      $file = str_replace($search, $replace, $file);
      unset($search);
      unset($replace);
      if(file_put_contents(__DIR__ . '/../../config/app.php', $file))
      {
        unset($file);
        echo Auth::alert('Votre theme a été activé avec succès', 'success');
        Auth::DesignedRefresh(APP_URL . "/admin/themes");

      }else{
        unset($file);
        echo Auth::alert('<strong>Attention : </strong> veuillez vérifier que le fichiers <code>config/app.php</code> existe bien et qu\'il a les droit nécessaire (<code>644</code>) !', 'error');
      }
    }else{
      unset($theme);
      echo Auth::alert('<strong>Attention : </strong> veuillez vérifier que le fichiers <code>themes/'.$name.'/theme.php</code> existe bien !', 'error');
    }
  }

  public function disable($name)
  {
    $theme = new Theme($name);
    if($theme->isTheme()){
      unset($theme);
      $search  = array(THEME_NAME);
      $replace = array('default');

      $file = file_get_contents(__DIR__ . '/../../config/app.php');
      $file = str_replace($search, $replace, $file);
      unset($search);
      unset($replace);
      if(file_put_contents(__DIR__ . '/../../config/app.php', $file))
      {
        unset($file);
        echo Auth::alert('Votre theme a été désactivé avec succès', 'success');
        echo "<script>location.reload();</script>";
      }else{
        unset($file);
        echo Auth::alert('<strong>Attention : </strong> veuillez vérifier que le fichiers <code>config/app.php</code> existe bien et qu\'il a les droit nécessaire (<code>644</code>) !', 'error');
      }
    }else{
      unset($theme);
      echo Auth::alert('<strong>Attention : </strong> veuillez vérifier que le fichiers <code>themes/'.$name.'/theme.php</code> existe bien !', 'error');
    }
  }

}

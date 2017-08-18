<?php
// Copyright © 2017 by SystemStatus.fr
// All rights reserved. This file or any portion thereof MUST contain the following copyrights.

class InstallController extends Controller
{

  public function __construct()
  {
    $this->templates = new League\Plates\Engine('inc/views/install/');
    $this->templates->addFolder('layouts', 'inc/views/layouts/');

    $this->middleware('InstallCheckMiddleware');
  }

  public static function showLanguages()
  {
    return $languages = LanguageController::showInstallList();
  }

  public function home()
  {
    echo $this->templates->render('home');
  }

  public function app()
  {
    echo $this->templates->render('app');
  }

  public function app_($lang)
  {
    $file = NULL;
    if (!empty($_POST['name']) && !empty($_POST['url'])) {
      if (file_exists(__DIR__ . '/../../config/app.example.php')) {
        $search = ['%url%', '%root%', '%name%'];
        $replace = [$_POST['url'], str_replace("/inc/controllers", "", __DIR__), $_POST['name']];

        if (file_exists(__DIR__ . '/../../config/app.php')) {
          unlink(__DIR__ . '/../../config/app.php');
          copy(__DIR__ . '/../../config/app.example.php', __DIR__ . '/../../config/app.php');
        }

        copy(__DIR__ . '/../../config/app.example.php', __DIR__ . '/../../config/app.php');

        $file = file_get_contents(__DIR__ . '/../../config/app.php');
        $file = str_replace($search, $replace, $file);
        if (file_put_contents(__DIR__ . '/../../config/app.php', $file)) {
          $webProtocol = (isset($_SERVER['HTTPS']) ? "https://" : "http://");
          $root = explode("/install", $_SERVER["REQUEST_URI"]);
          $root = $webProtocol . $_SERVER["HTTP_HOST"] . $root[0];
          echo "<script>window.location='" . $root . "/install/user?lang=" . $lang . "'</script>";
        } else {
          echo Auth::alert(LANG['controllers']['install']['error-writing-config-file'], 'error');
          exit(0);
        }
      } else {
        echo Auth::alert(LANG['controllers']['install']['error-check-example-app-exists'], 'error');
        exit(0);
      }
    } else {
      echo Auth::alert(LANG['global']['errors']['input-fields'], 'warning');
      exit(0);
    }
  }

  public
  function createUser()
  {
    echo $this->templates->render('user');
  }

  public
  function createUser_()
  {
    if (!empty($_POST['username']) && !empty($_POST['password'])) {
      if (preg_match(" /^[a-zA-Z0-9_]{3,16}$/ ", $_POST['username'])) { // check (3-16 charac)

        // API
        $api = Api::createLicence();
        $licence = $api->licence;
        $apiKey = $api->api_key;

        $search = ['%licence%', '%api%'];
        $replace = [$licence, $apiKey];
        $file = file_get_contents(__DIR__ . '/../../config/app.php');
        $file = str_replace($search, $replace, $file);
        file_put_contents(__DIR__ . '/../../config/app.php', $file);

        // user
        UsersController::addUserForInstall($licence, $apiKey, $_POST['username'], $_POST['password'], $_COOKIE['lang']);

      } else {
        Auth::alert(LANG['controllers']['install']['error-preg-match-user-create'], 'warning');
        exit(0);
      }

    } else {
      Auth::alert(LANG['global']['errors']['input-fields'], 'warning');
      exit(0);
    }
  }

  public
  function finish()
  {
    fopen(__DIR__ . '/../../storage/installed', 'w'); //ouvre le fichier
    echo $this->templates->render('finish');
  }

  private
  function alert($content, $type)
  {
    echo '<div class="alert alert-' . $type . ' alert-dismissible fade in" role="alert">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">×</span>
        </button>
        ' . $content . '
    </div>';
  }


}

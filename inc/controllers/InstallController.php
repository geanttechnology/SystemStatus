
<?php
// Copyright © 2017 by SystemStatus.fr
// All rights reserved. This file or any portion thereof MUST contain the following copyrights.

class InstallController extends Controller
{

  public function __construct(){
    $this->templates = new League\Plates\Engine('inc/views/install/');
    $this->templates->addFolder('layouts', 'inc/views/layouts/');

    $this->middleware('InstallCheckMiddleware');
  }

  public function home()
  {
    echo $this->templates->render('home');
  }

  public function app()
  {
    echo $this->templates->render('app');
  }

  public function app_()
  {
    $file = null;
    if(!empty($_POST['name']) && !empty($_POST['url']))
    {
      if(file_exists(__DIR__ . '/../../config/app.example.php')){
        $search  = array('%url%', '%root%', '%name%');
        $replace = array($_POST['url'], str_replace("/inc/controllers", "", __DIR__), $_POST['name']);

        if(file_exists(__DIR__ . '/../../config/app.php'))
        {
          unlink(__DIR__ . '/../../config/app.php');
          copy(__DIR__ . '/../../config/app.example.php', __DIR__ . '/../../config/app.php');
        }

        copy(__DIR__ . '/../../config/app.example.php', __DIR__ . '/../../config/app.php');

        $file = file_get_contents(__DIR__ . '/../../config/app.php');
        $file = str_replace($search, $replace, $file);
        if(file_put_contents(__DIR__ . '/../../config/app.php', $file))
        {
          $webProtocol = (isset($_SERVER['HTTPS']) ? "https://" : "http://");
          $root = explode("/install", $_SERVER["REQUEST_URI"]);
          $root = $webProtocol . $_SERVER["HTTP_HOST"] . $root[0];
          echo "<script>window.location='".$root."/install/user'</script>";
        }else{
          echo Auth::alert('<strong>Erreur :</strong> pendant la modification du fichier de configuration.', 'error');
          exit(0);
        }
      }else{
        echo Auth::alert('<strong>Attention :</strong> Veuillez vérifier que le fichier <code>config/app.example.php</code> existe.', 'error');
        exit(0);
      }
    }else{
      echo Auth::alert('<strong>Attention :</strong> Veuillez remplir tout les champs.', 'warning');
      exit(0);
    }
  }

  public function createUser()
  {
    echo $this->templates->render('user');
  }

  public function createUser_()
  {
    if(!empty($_POST['username']) && !empty($_POST['password']))
    {
      if(preg_match ( " /^[a-zA-Z0-9_]{3,16}$/ " , $_POST['username'])){ // check (3-16 charac)

        // API
        $api = Api::createLicence();
        $licence = $api->licence;
        $apiKey = $api->api_key;

        $search  = array('%licence%', '%api%');
        $replace = array($licence, $apiKey);
        $file = file_get_contents(__DIR__.'/../../config/app.php');
        $file = str_replace($search, $replace, $file);
        file_put_contents(__DIR__.'/../../config/app.php', $file);

        // user
       UsersController::addUserForInstall($licence, $apiKey, $_POST['username'], $_POST['password']);

      } else {
        Auth::alert('<strong>Attention :</strong> Les caractères spéciaux sont interdits ou la longueur requise n\'est pas respectée !', 'warning');
        exit(0);
      }

    } else {
      Auth::alert('<strong>Attention :</strong> Veuillez remplir tout les champs !', 'warning');
      exit(0);
    }
  }

  public function finish()
  {
    fopen(__DIR__ . '/../../storage/installed', 'w'); //ouvre le fichier
    echo $this->templates->render('finish');
  }

  private function alert($content, $type){
    echo '<div class="alert alert-'.$type.' alert-dismissible fade in" role="alert">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">×</span>
        </button>
        '.$content.'
    </div>';
  }


}

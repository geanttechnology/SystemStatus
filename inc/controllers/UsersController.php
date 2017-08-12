<?php
// Copyright © 2017 by SystemStatus.fr
// All rights reserved. This file or any portion thereof MUST contain the following copyrights.

class UsersController extends Controller
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

  public static function addUserForInstall($licence, $api_key, $username, $password, $rank = 3)
  {
    if (!empty($username) && !empty ($password)) {

      $resultAddUser = file_get_contents("https://api.systemstatus.fr/v3/?licence=" . $licence . "&api_key=" . $api_key . "&request=addUser&username=" . $username . "&password=" . $password . "&rank=" . $rank);

      $resultAddUser = json_decode($resultAddUser, TRUE);

      if ($resultAddUser['request'] == "successful") {
        $root = file_get_contents(__DIR__ . "/../../config/rootWebUrl");
        echo Auth::alert(LANG['controllers']['users']['success-created'], "success");
        echo "<script>window.location='" . $root . "/install/finish?lang=".$_COOKIE['lang']."'</script>";
      } else if ($resultAddUser['why'] == "limits reached") {
        echo Auth::alert(LANG['controllers']['users']['limits-reached'], "error");
      } else if ($resultAddUser['why'] == "already exists") {
        echo Auth::alert(LANG['controllers']['users']['already-exists'], "error");
      } else {
        echo Auth::alert(LANG['global']['errors']['error-occured'], "error");
      }

    } else {
      echo Auth::alert(LANG['global']['errors']['input-fields'], "error");
    }
  }

  public function users()
  {
    echo $this->templates->render('users');
  }

  public function updateUser()
  {
    if (isset($_POST['ID']) && !empty($_POST['ID'])) {

      if (isset($_POST['rank']) && !empty($_POST['rank']) OR isset($_POST['username']) && !empty($_POST['username']) OR isset($_POST['password']) && !empty($_POST['password'])) {

        $postData["username"] = (isset($_POST['username']) && !empty($_POST['username'])) ? $_POST["username"] : "unsetCodeExcept";
        $postData["rank"] = (isset($_POST['rank']) && !empty($_POST['rank'])) ? $_POST["rank"] : "unsetCodeExcept";
        $postData["password"] = (isset($_POST['password']) && !empty($_POST['password'])) ? $_POST["password"] : "unsetCodeExcept";

        $api = new API();
        $resultUpdateUser = json_decode(json_encode(json_decode($api->updateUser(intval($_POST['ID']), $postData))), TRUE);

        unset($postData);

        if ($resultUpdateUser['request'] == "successful") {
          echo Auth::alert("Le compte a été modifié avec succès !", "success");
          Auth::DesignedRefresh(APP_URL . "/admin/users");
        } else if ($resultUpdateUser['why'] == "not found") {
          echo Auth::alert("Le compte requis n'existe pas dans la base de données !", "error");
        } else {
          echo Auth::alert("Une erreur est survenue", "error");
        }


      } else {

        echo Auth::alert("<strong>Attention :</strong> Veuillez remplir au moin un champ du formulaire !", "error");

      }

    } else {

      echo Auth::alert("<strong>Attention :</strong> L'utilisateur n'a pas été envoyé !", "error");

    }

  }

  public function deleteUser()
  {
    if (!empty($_POST['ID'])) {

      $api = new API();
      $resultAddUser = json_decode(json_encode(json_decode($api->deleteUser(intval($_POST['ID'])))), TRUE);

      if ($resultAddUser['request'] == "successful") {
        echo Auth::alert("Le compte a été supprimé avec succès !", "success");
        Auth::DesignedRefresh(APP_URL . "/admin/users");
      } else if ($resultAddUser['why'] == "not found") {
        echo Auth::alert("L'utilisateur requis n'existe pas dans la base de données", "error");
      } else {
        echo Auth::alert("Une erreur est survenue", "error");
      }
    } else {
      echo Auth::alert("<strong>Attention :</strong> Veuillez remplir tout les champs du formulaire !", "error");
    }
  }

  public function addUser()
  {
    if (!empty($_POST['username']) && !empty($_POST['password']) && !empty($_POST['rank'])) {

      //Variables
      $username = $_POST['username'];
      $password = $_POST['password'];
      $rank = intval($_POST['rank']);

      $api = new API();
      $resultAddUser = json_decode(json_encode(json_decode($api->addUser($username, $password, $rank))), TRUE);

      unset($password);
      unset($rank);

      if ($resultAddUser['request'] == "successful") {
        echo Auth::alert(LANG['controllers']['users']['success-created'], "success");
        unset($username);
        Auth::DesignedRefresh(APP_URL . "/admin/users");
      } else if ($resultAddUser['why'] == "limits reached") {
        echo Auth::alert(LANG['controllers']['users']['limits-reached'], "error");
      } else if ($resultAddUser['why'] == "already exists") {
        echo Auth::alert(LANG['controllers']['users']['already-exists'], "error");
      } else {
        echo Auth::alert(LANG['global']['errors']['error_occured'], "error");
      }

    } else {
      echo Auth::alert("<strong>Attention :</strong> Veuillez remplir tout les champs du formulaire !", "error");
    }
  }
}

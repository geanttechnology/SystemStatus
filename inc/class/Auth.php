<?php
// Copyright © 2017 by SystemStatus.fr
// All rights reserved. This file or any portion thereof MUST contain the following copyrights.
  class Auth
  {
    public static function isActive()
    {
      if (!isset($_SESSION)) {
        session_start();
      }
      if (isset($_SESSION['status']) && $_SESSION['status']['active'] == 1 && time() < ($_SESSION['status']['time'] + (60 * 60))) // 60 * 60 => 1 hour
        return TRUE;
      else
        return FALSE;
    }

    public static function login($username, $password)
    {
      //Send credentials
      $api = new API();
      $result = json_decode($api->authUser($username, $password), TRUE);
      $data = $result['data'];

      //Parse result

      if ($result['request'] == "successful") {
        Auth::setID($data['id']);
        Auth::setUsername($data['username']);
        Auth::setRank($data['rank']);
        Auth::setStatus(1, time());

        echo Auth::alert("<strong>Succès :</strong> vous êtes maintenant connecté !<span class='pull-right'><i class='fa fa-refresh fa-spin'></i></span>", 'success', 1);
        echo "<meta http-equiv='refresh' content='2; url = " . APP_URL . "/admin'/>";
      } else {
        echo Auth::alert('<strong>Attention : </strong> Veuillez vérifier votre mot de passe !', 'danger', 1);
      }
    }

    public static function dialogLogin($username, $password)
    {
      //Send credentials
      $api = new API();
      $result = json_decode($api->authUser($username, $password), TRUE);
      $data = $result['data'];

      //Parse result
      if ($result['request'] == "successful") {
        return TRUE;
      } else {
        return FALSE;
      }
    }

    public static function routes($router)
    {
      $router->get('/login', 'AuthController@login');
      $router->post('/login', 'AuthController@login_');
      $router->get('/logout', 'AuthController@logout');
    }

    public static function getID()
    {
      return $_SESSION['ID'];
    }

    public static function setID($ID)
    {
      $_SESSION['ID'] = $ID;
    }

    public static function getUsername()
    {
      return $_SESSION['username'];
    }

    public static function setUsername($username)
    {
      return $_SESSION['username'] = $username;
    }

    public static function getRank()
    {
      return $_SESSION['rank'];
    }

    public static function setRank($rank)
    {
      return $_SESSION['rank'] = $rank;
    }

    public static function setStatus($state, $time)
    {
      $_SESSION['status'] = [];
      $_SESSION['status']['active'] = $state;
      $_SESSION['status']['time'] = $time;

      return TRUE;
    }

    public static function getTypeAccount($type)
    {

      switch ($type) {
        case 2:
          return "Normal";
          break;

        case 3:
          return "<span class='text-info'>Administrateur</span>";
          break;

        default:
          return "ERREUR";
          break;
      }
    }

    public static function logout()
    {
      session_destroy();
      header('Location: ' . APP_URL . '/login');
    }

    public static function alert($content, $type, $version = 2)
    {

      if ($version == 1) {

        //Version 1
        return '<div class="alert alert-' . $type . ' animated fadeInDown" style="border-radius: 0;" role="alert">
        ' . $content . '
    </div>';

      } else {

        //Version 2 (latest version)
        return '<script>toastr.' . $type . '("' . $content . '")</script>';

      }

    }

    public static function setGUI($type, $content, $hide, $redirect = "")
    {
      if (!empty($type) && !empty($content) && !empty($hide)) {
        $_SESSION["GUI"] = [
          "type"   => $type,
          "text"   => $content,
          "hide"   => $hide,
          "expire" => time() + 1,
        ];
        if (!empty($redirect)) {
          header("Location: " . $redirect);
        }
      }
    }

    public static function DesignedRefresh($url)
    {
      echo '<meta http-equiv="refresh" content="1; url = ' . $url . '"/>';
      echo '
        <script>
            $("#loader")
                .addClass(\'loader animated fadeIn\')
                .html("<div class=\'content\'><i class=\'fa fa-circle-o-notch fa-spin fa-5x fa-fw\'></i><h4>Traitement en cours...</h4></div>")
        </script>';
    }

    public static function gui($type, $content, $hide) //This shows more friendly notifications who can hides themself thanks to the $hide argument.
    {
      echo '
  <div id="' . time() . '" class="gui-alert animated fadeInDown alert alert-' . $type . ' alert-dismissible fade in" role="alert">
     <button type="button" class="close" data-dismiss="alert" aria-label="Close">
       <span aria-hidden="true">×</span>
     </button>
     ' . html_entity_decode($content) . '
   </div>
  ';
      if ($hide == 1): //This hides notification if $hide == 1 when calling the function
        ?>
          <script>
              setTimeout(function () {
                  $("#<?=time()?>").removeClass("fadeInDown");
                  $("#<?=time()?>").addClass("fadeOutDown");
              }, 5000);
          </script>
      <?php endif;
    }

  }

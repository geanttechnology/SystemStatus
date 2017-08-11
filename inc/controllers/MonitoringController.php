<?php
// Copyright © 2017 by SystemStatus.fr
// All rights reserved. This file or any portion thereof MUST contain the following copyrights.

class MonitoringController extends Controller
{
  public function __construct(){

    $this->templates = new League\Plates\Engine('inc/views/admin');
    $this->templates->addFolder('layouts', 'inc/views/layouts/');

    $this->middleware('InstallMiddleware');
    $this->middleware('AuthMiddleware');
    $this->middleware('StatusMiddleware');
    $this->middleware('APIMiddleware');

  }

  public function monitoring()
  {
    echo $this->templates->render('monitoring');
  }

  public function add()
  {

    AuthController::checkAuthStatus();
    SecurityController::checkAccess(3);

    if (!empty($_POST['target']) && !empty($_POST['service'])) {

      $target = $_POST['target'];
      $service = intval($_POST['service']);

      $api = new API();
      $result = json_decode(json_encode(json_decode($api->createMonitoring($target, $service))), True);


      if($result["request"] == "successful"){

        echo Auth::alert("La cible de monitoring a bien été ajoutée à la base de données", "success");
        Auth::DesignedRefresh(APP_URL . "/admin/monitoring");

      } else {

        switch ($result["why"]){
          case "already exists":
            echo Auth::alert("La cible de monitoring existe déjà", "error");
            break;
          case "not found":
            echo Auth::alert("Le service requis n'existe pas", "error");
            break;
          case "limits reached":
            echo Auth::alert("Votre licence a atteint sa limite de monitoring, veuillez mettre à niveau votre licence", "error");
            break;
          case "no parameters":
            echo Auth::alert("Requete incomplète, veuillez réessayer", "error");
            break;
          default:
            echo Auth::alert("Une erreur s'est produite, veuillez réessayer", "error");
            break;
        }

      }

    }else{
      echo Auth::alert("Requete erronée ou incomplète, veuillez réessayer", "error");
    }
  }

  public function delete()
  {

    AuthController::checkAuthStatus();
    SecurityController::checkAccess(3);

    if(!empty($_POST['ID'])){

      //Call api in order to delete monitoring
      $monitoringID = intval($_POST['ID']);

      $api = new API();
      $result = json_decode(json_encode(json_decode($api->deleteMonitoring($monitoringID))), True);


      if($result["request"] == "successful"){

        unset($result);

        echo Auth::alert("Le monitoring n°".$_POST['ID']." a été supprimé avec succès !", "success");
        echo '<script>$("#monitoring_'.$monitoringID.'").remove()</script>';

      } else {

        switch ($result["why"]){
          case "incorrect owner":
            unset($result);
            echo Auth::alert("Le service requis n'existe pas", "error");
            break;
          default:
            unset($result);
            echo Auth::alert("Une erreur s'est produite, veuillez réessayer", "error");
            break;
        }

      }

    } else {
      echo Auth::alert("<strong>Attention :</strong> Veuillez remplir tout les champs du formulaire !", "error");
    }
  }

  public function externalPing($api_key, $target, $serviceID)
  {

    function ping($host){
      exec(sprintf('ping -c 1 -W 5 %s', escapeshellarg($host)), $res, $rval);
      return $rval === 0;
    }

    $cfg = include(__DIR__."/../../config/app.php");

    $realApiKey = $cfg["cms"]["api_key"];

    //Check if we can trust in the given API KEY
    if($api_key == $realApiKey){

      unset($cfg);
      unset($realApiKey);

      /* //////////////:============================://////////////////////
          *                  Start monitoring
      * //////////////:============================:////////////////////// */
      $hostStatus = ping($target);
      $hostStatus = ($hostStatus == 1) ? "on" : "off";

      /* //////////////:============================://////////////////////
         *                  Send API Request
         * //////////////:============================:////////////////////// */

      if($hostStatus == "off") {
        unset($hostStatus);
        echo "off";

        //Update monitoring status
        self::updateTargetStatus($serviceID, "off");
        //Update Service
        $api = new API();
        $api->updateService(3, intval($serviceID));

      }else if($hostStatus == "on") {
        echo "on";
        //Update monitoring status
        self::updateTargetStatus($serviceID, "on");
        //Update Service
        $api = new API();
        $api->updateService(1, intval($serviceID));
      }

    }else{
      echo "not correct api key";
    }
  }

  public static function getMonitoringPingStatusBadge($status)
  {

    AuthController::checkAuthStatus();

    switch ($status){
      case 2:?>
          <span class="label label-warning">En attente <i class="fa fa-question-circle"></i></span>
        <?php break;
      case 1:?>
          <span class="label label-success">En ligne <i class="fa fa-check"></i></span>
        <?php break;
      case 0:?>
          <span class="label label-danger">Hors ligne <i class="fa fa-flash"></i></span>
        <?php break;
      default:?>
          <span class="label label-warning">ERROR (contact dev)</span>
        <?php break;
    }
  }

  public static function updateTargetStatus($serviceID, $status)
  {

    $status = ($status != "on" && $status != "off") ? "waiting" : $status;

    $api = new API();
    $result = json_decode(json_encode(json_decode($api->updateTargetStatus($serviceID, $status))), True);


    if($result["request"] == "successful"){
      unset($result);

      echo Auth::alert("La cible de monitoring a bien été mise à jour", "success");
      //Auth::DesignedRefresh("/admin/monitoring");

    } else {

      switch ($result["why"]){
        case "not found":
          unset($result);
          echo Auth::alert("Le service requis n'existe pas", "error");
          break;
        default:
          unset($result);
          echo Auth::alert("Une erreur s'est produite, veuillez réessayer", "error");
          break;
      }
    }

  }
}

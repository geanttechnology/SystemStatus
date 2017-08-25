<?php
// Copyright © 2017 by SystemStatus.fr
// All rights reserved. This file or any portion thereof MUST contain the following copyrights.

class ServicesController extends Controller
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

  public function add()
  {
    if(!empty($_POST['name']) && !empty($_POST['category']) && !empty($_POST['statut'])){

      $api = new API();
      $result = json_decode(json_encode(json_decode($api->addService(htmlspecialchars($_POST['name']), intval($_POST['category']), intval($_POST['statut'])))), True);

      if(isset($result['status']) && $result['status'] == "error"){

        switch ($result['why']){
          case "takenName":
              unset($result);
            echo Auth::alert(LANG['controllers']['services']['already-exists'], 'warning');
            break;
          case "incorrectStatus":
              unset($result);
            echo Auth::alert("Le statut demandé est incorrect", 'warning');
            break;
          case "incorrectCategory":
              unset($result);
            echo Auth::alert("La catégorie n'existe pas", 'warning');
            break;
          case "limitsReached":
              unset($result);
            echo Auth::alert("<strong>Attention :</strong> Vous avez atteint la limite de services pour votre licence", 'warning');
            break;
          default:
              unset($result);
            echo Auth::alert("Une erreur est survenue", 'warning');
            break;
        }

      } else {
        echo Auth::alert("Le service a été créé !", "success");
        Auth::DesignedRefresh(APP_URL . "/admin/manageItems");
      }

    }else{
      echo Auth::alert('<strong>Attention :</strong> Veuillez remplir tout les champs du formulaire !', 'error');
    }
  }

  public function delete($ID)
  {
    $api = new API();
    $result = json_decode($api->deleteService(intval($ID)), True);
    unset($ID);

    if($result['request'] == "successful"){

      echo Auth::alert('Suppression effectuée avec succès !', 'success');
      Auth::DesignedRefresh(APP_URL . "/admin/manageItems");

    }else{

      echo Auth::alert('<strong>Attention :</strong> une erreur est survenue lors de la suppression !', 'error');

    }
  }

  public function update($status, $ID)
  {

    $api = new API();
    $result = json_decode(json_encode(json_decode($api->updateService(intval($status), intval($ID)))), True);
    unset($status);
    unset($ID);


    if($result['request'] == "successful"){

      echo Auth::alert("Mise à jour effectuée avec succès", 'success');

    }else{

      echo Auth::alert("Une erreur est survenue lors de la mise à jour", 'error');


    }

  }

  public static function getServiceStatus($serviceStatus){

    switch (intval($serviceStatus)) {
      case 1: unset($serviceStatus)?>
          <small class="pull-right text-success status_dot"><?=LANG['controllers']['services']['operational']?></small>
        <?php break;

      case 2: unset($serviceStatus)?>
          <small class="pull-right text-warning status_dot"><?=LANG['controllers']['services']['partial-failure']?></small>
        <?php break;

      case 3: unset($serviceStatus)?>
          <small class="pull-right text-danger status_dot"><?=LANG['controllers']['services']['defective']?></small>
        <?php break;

      case 4: unset($serviceStatus)?>
          <small class="pull-right text-info status_dot"><?=LANG['controllers']['services']['maintenance']?></small>
        <?php break;

      default: unset($serviceStatus)?>
          <small class="pull-right text-default status_dot">ERROR</small>
        <?php break;
    }
  }

  public static function getServiceStatusNoFloat($serviceStatus){

    switch (intval($serviceStatus)) {
      case 1:unset($serviceStatus)?>
          <span class="label label-success"><?=LANG['controllers']['services']['operational']?></span>
        <?php break;

      case 2:unset($serviceStatus)?>
          <span class="label label-warning"><?=LANG['controllers']['services']['partial-failure']?></span>
        <?php break;

      case 3:unset($serviceStatus)?>
          <span class="label label-danger"><?=LANG['controllers']['services']['defective']?></span>
        <?php break;

      case 4:unset($serviceStatus)?>
          <span class="label label-info"><?=LANG['controllers']['services']['maintenance']?></span>
        <?php break;

      default:?>
          <span class="label label-default">ERROR</span>
        <?php break;
    }
  }

  public static function getServiceStatusByStatusId($statusID){

    switch (intval($statusID)) {
      case 1:unset($statusID)?>
          <small class="text-success status_dot"><?=LANG['controllers']['services']['operational']?></small>
        <?php break;

      case 2:unset($statusID)?>
          <small class="text-warning status_dot"><?=LANG['controllers']['services']['partial-failure']?></small>
        <?php break;

      case 3:unset($statusID)?>
          <small class="text-danger status_dot"><?=LANG['controllers']['services']['defective']?></small>
        <?php break;

      case 4:unset($statusID)?>
          <small class="text-info status_dot"><?=LANG['controllers']['services']['maintenance']?></small>
        <?php break;

      default:?>
          <small class="text-default status_dot">ERROR</small>
        <?php break;
    }
  }

  public static function assignService($serviceID, $categoryID)
  {

    $serviceID = intval($serviceID);
    $categoryID = intval($categoryID);

    $api = new API();
    $result = json_decode($api->assignService($serviceID, $categoryID));

    unset($serviceID);
    unset($categoryID);

    $result = json_decode(json_encode($result), True);

    if ($result['status'] == "error") {
      switch ($result['why']) {
        case "incorrect owner":
          echo Auth::alert("Le service ou la catégorie demandé(e) n'appartient pas à votre licence", 'warning');
          break;
        case "unknown error":
          echo Auth::alert("Une erreur est survenue", 'warning');
          break;
      }
    } else if ($result['request'] == "successful") {
      echo Auth::alert("Le service a été assigné avec succès", 'success');
      Auth::DesignedRefresh(APP_URL . "/admin/manageItems");
    }

  }
}
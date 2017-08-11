<?php
// Copyright © 2017 by SystemStatus.fr
// All rights reserved. This file or any portion thereof MUST contain the following copyrights.

class CategoryController extends Controller
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

  public function add()
  {
    if(!empty($_POST['name'])){

      $api = new API();
      $result = json_decode($api->addCategory($_POST['name']), true);

      if(isset($result['status']) && $result['status'] == "error" && $result['why'] == "limitsReached"){
        echo Auth::alert('<strong>Attention :</strong> Vous avez atteint la limite de catégories pour votre licence', 'warning');
      } else {
        echo Auth::alert("La catégorie a été créée !", "success");
        Auth::DesignedRefresh(APP_URL . "/admin/manageItems");
      }

    }else{
      echo Auth::alert('<strong>Attention :</strong> Veuillez remplir tout les champs du formulaire !', 'error');
    }
  }

  public function deleteAll($ID)
  {
    //Variables
    $category = intval($ID);

    $api = new API();

    $resultDeleteAllCategory = json_decode($api->deleteAllCategory($category), True);
    if($resultDeleteAllCategory['request'] == "successful"){
      echo Auth::alert('Suppression effectuée avec succès !', 'success');
      Auth::DesignedRefresh(APP_URL . "/admin/manageItems");
    }else{
      echo Auth::alert('<strong>Attention :</strong> une erreur est survenue lors de la suppression !', 'error');
    }
  }

  public function delete($ID)
  {
    //Variables
    $category = intval($ID);
    $api = new API();

    //Delete category
    $resultDeleteCategory = json_decode($api->deleteCategory($category), True);
    if($resultDeleteCategory['request'] == "successful"){
      echo Auth::alert('Suppression effectuée avec succès !', 'success');
      Auth::DesignedRefresh(APP_URL . "/admin/manageItems");
    }else{
      echo Auth::alert('<strong>Attention :</strong> une erreur est survenue lors de la suppression !', 'error');
    }

    //Set related services as "not attached"
    $api->detachServices($category);

  }

  public static function getCategoryStatus($upperStatus){

    switch (intval($upperStatus)){
      case 4:?>
          <i class="fa fa-dot-circle-o text-info pull-right margint5"></i>
        <?php break;
      case 3:?>
          <i class="fa fa-dot-circle-o text-danger pull-right margint5"></i>
        <?php break;
      case 2:?>
          <i class="fa fa-dot-circle-o text-warning pull-right margint5"></i>
        <?php break;
      case 1:?>
          <i class="fa fa-dot-circle-o text-success pull-right margint5"></i>
        <?php break;
      default:?>
          ERROR
        <?php break;
    }
  }

}

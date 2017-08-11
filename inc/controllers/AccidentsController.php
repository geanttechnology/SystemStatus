<?php
// Copyright © 2017 by SystemStatus.fr
// All rights reserved. This file or any portion thereof MUST contain the following copyrights.

class AccidentsController extends Controller
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

  public function accident($ID)
  {
    define('ACCIDENT_ID', $ID);
    echo $this->templates->render('accident');
  }

  public function update()
  {
    if (!empty($_POST['action'])) {

      switch (htmlspecialchars($_POST['action'])) {

        case 'content':
          if (isset($_POST['ID']) && !empty($_POST['ID']) && isset($_POST['status']) && !empty($_POST['status']) && isset($_POST['content'])) {

            $accidentSerialId = htmlspecialchars($_POST['ID']);
            $newStatus = $_POST['status'];
            $content = (empty($_POST['content'])) ? "Aucun commentaire" : nl2br(htmlspecialchars($_POST['content']));
            $author_id = auth::getID();

            $api = new API();
            $resultUpdateAccident = json_decode(json_encode(json_decode($api->updateAccident($accidentSerialId, $content, $newStatus, $author_id))), True);

            if ($resultUpdateAccident[request] == "successful") {

              Auth::DesignedRefresh(APP_URL . "/admin/accidents/" . $accidentSerialId);

            } else if ($resultUpdateAccident[status] == "error") {

              switch ($resultUpdateAccident[why]) {
                case "incorrect owner":
                  echo Auth::alert("<strong> Attention :</strong> l'incident requis ne vous appartient pas !", 'warning');
                  break;
                case "incorrect status":
                  echo Auth::alert("<strong> Attention :</strong> le statut envoyé n'est pas valide !", 'warning');
                  break;
                case "unknown error":
                  echo Auth::alert("<strong> Attention :</strong> une erreur est survenue !", 'warning');
                  break;
                default:?>
                  <script>alert("<?=$resultUpdateAccident[why]?>");</script>
                  <?php break;
              }


            } else {
              echo Auth::alert("<strong> Attention :</strong> Il y a eu une erreur pendant l'envoi de la requete, veuillez réessayer !", 'warning');
            }
          }
          break;
      }
    }

  }

  public function delete()
  {
    if(!empty($_POST['ID'])) {

      $serialId = htmlspecialchars($_POST['ID']);

      $api = new API();
      $resultDeleteAccident = json_decode(json_encode(json_decode($api->deleteAccident($serialId))), True);

      if ($resultDeleteAccident[request] == "successful") {

        Auth::DesignedRefresh(APP_URL . "/admin");

      } else if ($resultDeleteAccident[status] == "error" AND $resultDeleteAccident[why] == "incorrect owner") {

        echo Auth::alert("<strong> Attention :</strong> l'incident requis ne vous appartient pas !", 'error');

      } else {

        echo Auth::alert("<strong> Attention :</strong> Une erreur est survenue", 'error');

      }

    } else {

      echo Auth::alert("<strong> Attention :</strong> Aucun incident n'a été selectionné !", 'error');

    }


  }

  public function add()
  {
    if(!empty($_POST['title']) && !empty($_POST['content']) && !empty($_POST['serviceID']) && !empty($_POST['serviceStatus'])){

      $title = htmlspecialchars($_POST['title']);
      $content = nl2br($_POST['content']);
      $serviceId = intval($_POST['serviceID']);
      $serviceStatus = intval($_POST['serviceStatus']);
      $author_id = Auth::getID();

      $api = new API();
      $resultCreateAccident = json_decode(json_encode(json_decode($api->addAccident($title, $content, $serviceId, $serviceStatus, $author_id))), True);


      $resultUpdateStatus = json_decode(json_encode(json_decode($api->updateService($serviceStatus, $serviceId))), True);

      if($resultCreateAccident[status] == "error") {
        switch ($resultCreateAccident[why]) {
          case "incorrect owner":
            echo Auth::alert("Le service demandé ne vous appartient pas !", 'warning');
            break;
          default:
            echo Auth::alert("Une erreur est survenue", 'warning');
            break;
        }

      } else if($resultCreateAccident[request] == "successful") {

        Auth::GUI("success", "L'incident a bien été créé", 0);
        Auth::DesignedRefresh(APP_URL . "/admin/accidents/".$resultCreateAccident[accident_id]);

      } else {

        echo Auth::alert("Aucune réponse de l'API, veuillez réessayer plus tard.", 'warning');

      }


    }else{
      echo Auth::alert('<strong>Attention :</strong> Veuillez remplir tout les champs du formulaire !', 'error');
    }
  }

  public function close()
  {
    if(isset($_POST['ID'])){

      $ID = htmlspecialchars($_POST['ID']);

      //Close accident
      $api = new API();
      $resultCloseAccident = json_decode(json_encode(json_decode($api->closeAccident($ID, Auth::getID()))), True);

      if($resultCloseAccident[request] == "successful"){
        Auth::DesignedRefresh(APP_URL . "/admin/accidents/".$ID);

      } else {
        echo Auth::alert("<strong> Attention :</strong> Il y a eu une erreur pendant l'envoi de la requete, veuillez réessayer ! (Erreur API)", 'warning');
      }


    }else{
      echo Auth::alert("<strong> Attention :</strong> Il y a eu une erreur pendant l'envoi de la requete, veuillez réessayer !", 'warning');
    }
  }

  public static function getAccidentReplyContent($content){
      echo str_replace("\r\n", "<br>", str_replace("<br />", "", html_entity_decode(htmlspecialchars_decode($content))));
  }

  public static function getAll(){

    $api = new API();
    return $resultGetAllAccidents = json_decode(json_encode(json_decode($api->getAllAccidents())), True);

  }
}

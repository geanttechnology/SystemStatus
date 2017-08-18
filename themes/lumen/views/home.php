<?php

/*Copyright © 2017 by SystemStatus.fr
All rights reserved. This file or any portion thereof MUST contain the following copyrights.*/

?>

<div class="container" style="margin-bottom: 5%;">

    <br ><br ><br >

  <?php if (Auth::isActive()): ?>
      <!-- Auth alert -->
      <div id="auth-info" class="alert alert-info" role="alert">
          <i class="fa fa-shield"></i>&nbsp;Connecté en temps que <strong><?=Auth::getUsername()?></strong>
          <span class="pull-right"><a href="<?=APP_URL?>/admin" class="white-text">Retourner à l'administration</a></span>
      </div>
      <!-- ./Auth alert -->
  <?php endif ?>

    <!-- Services status check -->
  <?php
  $api = new API();
  $services = json_decode($api->getServices());
  $services = json_decode(json_encode($services->data), True);

  //Initialize values
  $nonOperationalServices = 0;

  if(is_array($services)) {

    foreach ($services as $key => $value) {
      if ($services[$key]["status"] != 1) {
        ++$nonOperationalServices;
      }
    }

    if ($nonOperationalServices > 0):?>
        <div class="alert alert-warning fade in" role="alert">
            <strong>Certains services ne sont pas opérationnels <i class="fa fa-info-circle pull-right" style="font-size: 1.5em"></i></strong>
        </div>
    <?php else: ?>
        <div class="alert alert-success alert-dismissible fade in" role="alert">
            <strong>Tout les services sont opérationnels</strong>
            <i class="fa fa-check-circle-o pull-right" style="font-size: 1.5em;"></i>
        </div>
    <?php endif;
  }
  ?>
    <!-- ./Services check -->

    <!-- Categories -->
  <?php
  $api = new API();
  $categories = json_decode($api->getCategories());
  $categories = json_decode(json_encode($categories->data), True);

  if(is_array($categories)) {

  echo "<div id='lom-452'>";

  foreach ($categories as $categoryKey => $categoryValue){

    /* //////////////:============================://////////////////////
       *          [START] Get Category Global Status [START]
       * //////////////:============================:////////////////////// */

    //Initialize values
    $status1 = 0;
    $status2 = 0;
    $status3 = 0;
    $status4 = 0;

    if(is_array($services)) {

      foreach ($services as $serviceKey => $serviceValue) {

        if ($services[$serviceKey]['category_id'] == $categories[$categoryKey]['id']) {

          switch ($services[$serviceKey]['status']){
            case 1:
              ++$status1;
              break;
            case 2:
              ++$status2;
              break;
            case 3:
              ++$status3;
              break;
            case 4:
              ++$status4;
              break;
          }

        }

      }
    }

    $categories[$categoryKey]['globalStatus'] = ($status4 > 0) ? 4 : ($status3 > 0) ? 3 : ($status2 > 0) ? 2 : 1;

    if($status4 > 0){
      $categories[$categoryKey]['globalStatus'] = 4;
    }else if ($status3 > 0){
      $categories[$categoryKey]['globalStatus'] = 3;
    }else if ($status2 > 0){
      $categories[$categoryKey]['globalStatus'] = 2;
    }else{
      $categories[$categoryKey]['globalStatus'] = 1;
    }


    /* //////////////:============================://////////////////////
       *          [END] Get Category Global Status [END]
       * //////////////:============================:////////////////////// */

    ?>


      <div class="panel panel-default">

          <div class="panel-heading">

            <?= $categories[$categoryKey]['name'] . CategoryController::getCategoryStatus($categories[$categoryKey]['globalStatus']) ?>

          </div>

        <?php


        if(is_array($services)) {


          foreach ($services as $serviceKey => $serviceValue){

            if ($services[$serviceKey]['category_id'] == $categories[$categoryKey]['id']){ ?>

                <div class="panel-body">

                  <?= $services[$serviceKey]['name'] ?>

                  <?php if (!isset($services[$serviceKey]['accidented']) || $services[$serviceKey]['accidented'] != 1):ServicesController::getServiceStatus($services[$serviceKey]['status']);endif; ?>

                  <?php

                  if (isset($services[$serviceKey]['accidented']) && $services[$serviceKey]['accidented'] == 1) {

                    //Extract useful data
                    $accident = json_decode($api->getAccident($services[$serviceKey]['accident_serial_id']));
                    $accidentMainData = json_decode(json_encode($accident->data), True);
                    $accidentReplies = json_decode(json_encode($accident->replies), True);
                    $accidentService = json_decode(json_encode($accident->service), True);
                    $accidentCategory = json_decode(json_encode($accident->category), True);
                    $accidentAuthor = json_decode(json_encode($accident->user), True);


                    ?>

                      <abbr class="link" title="Voir le rapport d'incident">
                          <i class='fa fa-exclamation-triangle link pull-right accident-link text-<?= AdminController::getTypeByStatusId($accidentService["status"]); ?>'
                             data-toggle="modal"
                             data-target="#modalAccident<?= $accidentMainData['accident_serial_id'] ?>"></i>
                          <span class="link" data-toggle="modal"
                                data-target="#modalAccident<?= $accidentMainData['accident_serial_id'] ?>"><?= ServicesController::getServiceStatus($accidentService['status']); ?></span>
                      </abbr>

                      <!-- Modal -->
                      <div class="modal fade" id="modalAccident<?= $accidentMainData['accident_serial_id'] ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel">
                          <div class="modal-dialog modal-lg" role="document">
                              <div class="modal-content">
                                  <div class="modal-header">
                                      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                          <span aria-hidden="true">&times;</span>
                                      </button>
                                      <h4 class="modal-title">Consultation du rapport</h4>
                                  </div>
                                  <!-- Modal Body ====================================================================================================================== -->
                                  <div class="modal-body">
                                      <!-- row -->
                                      <div class="row">

                                          <h3 class="col-md-12">
                                              Rapport d'incident #<?= $accidentMainData["accident_serial_id"] ?>
                                              <small>Statut de l'incident: <?= AdminController::getIncidentStatus($accidentMainData["accident_status"]) ?></small>
                                          </h3>
                                          <dl class="dl-horizontal col-md-12">
                                              <dt>Création de l'incident</dt>
                                              <dd>Créé <strong>
                                                  <?php
                                                  Api::getDate($accidentMainData["date"]);
                                                  ?>
                                                  </strong> par <strong><?= $accidentAuthor["username"] ?></strong>
                                              </dd>

                                              <dt>Service lié</dt>
                                              <dd>
                                                  <strong><?= $accidentService['name'] ?></strong> dans la catégorie
                                                  <strong><?= $accidentCategory['name'] ?></strong>
                                              </dd>

                                            <?php if (is_array($accidentReplies)): ?>
                                                <dt>Dernière mise à jour</dt>
                                                <dd>
                                                  <span class="pull-left">
                                                    <?php
                                                    end($accidentReplies);
                                                    $lastUpdate = key($accidentReplies);
                                                    $lastUpdate = $accidentReplies[$lastUpdate]['date'];
                                                    ?>
                                                    <?php echo ServicesController::getServiceStatusByStatusId($services[$serviceKey]['status']) . " " . Api::getDate($lastUpdate); ?>
                                                  </span>
                                                </dd>
                                            <?php endif; ?>

                                          </dl>
                                      </div>
                                      <!-- ./row -->

                                      <!-- row -->
                                      <div class="row">
                                          <div class="timeline-centered">

                                            <?php
                                            if(is_array($accidentReplies)):
                                              foreach ($accidentReplies as $accidentRepliesKey => $accidentRepliesValue) {

                                                $pictoBackgroundColor = AdminController::getTypeByStatusId($accidentReplies[$accidentRepliesKey]['service_status_update']);

                                                ?>

                                                  <article class="timeline-entry">
                                                      <div class="timeline-entry-inner">
                                                          <div class="timeline-icon bg-<?= $pictoBackgroundColor ?>">
                                                              <i class="entypo-feather"><?= AdminController::getAccidentFontAwesomeIconByStatusId($accidentReplies[$accidentRepliesKey]['service_status_update']) ?></i>
                                                          </div>
                                                          <div class="timeline-label">
                                                              <h2>
                                                                <?= $accidentReplies[$accidentRepliesKey]["author_username"] ?>
                                                                  <span>a répondu à l'incident <span class="pull-right">Posté <?= Api::getDate($accidentReplies[$accidentRepliesKey]['date']) ?></span></span>
                                                              </h2>
                                                              <p>
                                                                <?php AccidentsController::getAccidentReplyContent($accidentReplies[$accidentRepliesKey]['content']) ?>
                                                              </p>
                                                          </div>
                                                      </div>
                                                  </article>

                                                <?php
                                              }
                                            endif;

                                            ?>

                                            <?php
                                            $pictoBackgroundColor = AdminController::getTypeByStatusId($accidentMainData["service_status"]);
                                            ?>

                                              <article class="timeline-entry">
                                                  <div class="timeline-entry-inner">
                                                      <div class="timeline-icon bg-<?= $pictoBackgroundColor ?>">
                                                          <i class="entypo-feather"><?= AdminController::getAccidentFontAwesomeIconByStatusId($accidentMainData["service_status"]) ?></i>
                                                      </div>
                                                      <div class="timeline-label">

                                                          <h2>
                                                              <span><?= $accidentAuthor["username"] ?> a créé le rapport d'incident</span>
                                                              <span class="pull-right"><span>Posté <?= Api::getDate($accidentMainData["date"]) ?></span></span>
                                                          </h2>
                                                          <p>
                                                            <?= $accidentMainData["content"] ?>
                                                          </p>
                                                      </div>
                                                  </div>
                                              </article>

                                              <article class="timeline-entry begin">
                                                  <div class="timeline-entry-inner">
                                                      <div class="timeline-icon" style="-webkit-transform: rotate(-90deg); -moz-transform: rotate(-90deg);">
                                                          <i class="entypo-flight"></i>
                                                      </div>
                                                  </div>
                                              </article>
                                          </div>
                                      </div>
                                      <!-- ./row -->
                                  </div>

                                  <!-- Modal Body [END] ====================================================================================================================== -->

                                  <div class="modal-footer">
                                    <?php if (Auth::isActive()): ?>
                                        <a href="<?= APP_URL ?>/admin/accidents/<?= $accidentMainData['accident_serial_id'] ?>"
                                           class="btn btn-primary">Gérer l'incident</a>
                                    <?php endif; ?>

                                      <button type="button" class="btn btn-default" data-dismiss="modal">Fermer</button>
                                  </div>
                              </div>
                          </div>
                      </div>
                      <!-- ./Modal -->
                  <?php } ?>

                </div>

              <?php

            } // if service accidented



          } //foreach services

          ?>



          <?php



        } // if_array(services) (!)




        ?>



      </div>

    <?php

  } //foreach categories

  ?>

</div> <!-- end container -->

<?php

echo "</div>"; //end #lom-452

}else{ // if_array(categories) (!)
  ?>
    </div> <!-- end container -->
    <div class="text-center text-muted" style="margin-top: 10%">
        <i class="fa fa-magic fa-4x"></i>
        <br>
        <h4 class="text-muted">Rendez-vous dès à présent sur votre panel afin de gérer vos catégories et services !</h4>
        <a href="<?=APP_URL?>/admin" class="btn btn-default" id="lom-453">Panel d'administration <i class="fa fa-cog fa-spin"></i></a>
    </div>
  <?php
}

?>

<?php

$allClosedAccidents = AccidentsController::getAll();

if(isset($allClosedAccidents["data"]) && is_array($allClosedAccidents["data"])) {

  echo "<h4 class='text-center -bold' style='margin-top: 15px;'>Incidents résolus ces 7 derniers jours</h4>";

  echo '<div class="container">';


  $allClosedAccidents = $allClosedAccidents["data"];

  foreach ($allClosedAccidents as $key => $value) {

    //if accident happened in the 7 next days
    if (time() <= ($allClosedAccidents[$key]["date"] + 604800)) {

      ?>


        <div class="col-xs-12 col-md-4">
            <div class="accidentHistoryVignette">
                <div class="text-center -align-center" style="font-size: 3em;">
                        <span class="link text-<?= AdminController::getTypeByStatusId($allClosedAccidents[$key]["service_status"]) ?>">
                          <?= AdminController::getAccidentFontAwesomeIconByStatusId($allClosedAccidents[$key]["service_status"]) ?>
                        </span>
                </div>
                <h4><?= $allClosedAccidents[$key]["title"] ?></h4>
                <p>
                  <?= AccidentsController::getAccidentReplyContent($allClosedAccidents[$key]["content"]) ?>
                </p>
                <hr>
                <div class="row">
                    <span class="text-muted pull-right" style="margin-right: 15px;">Incident créé <?=Api::getDate($allClosedAccidents[$key]["date"])?></span>
                </div>

            </div>
        </div>

      <?php

    }

  }

  echo "</div>"; //end container

}

?>



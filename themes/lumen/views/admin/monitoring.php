<?php

/*Copyright © 2017 by SystemStatus.fr
All rights reserved. This file or any portion thereof MUST contain the following copyrights.*/

?>
<div class="col-sm-12 col-md-10 dzq-345 animated fadeIn">

    <div class="row">
        <h3 class="text-center text-uppercase">Espace de monitoring</h3>
        <hr class="col-md-6 col-md-offset-3">
    </div>

    <p class="text-muted">
        Cette page vous permet d'automatiser le statut de vos services par l'envoi régulier de requêtes <abbr title="Packet Internet Groper">PING</abbr><br><i class="fa fa-info-circle"></i> Les statuts peuvent mettre jusqu'à 5 minutes avant d'être actualisés.
    </p>

    <div id="result"></div>

  <?php
  $api = new API();
  $monitorings = json_decode($api->getMonitorings());
  if(isset($monitorings->data)){
    $monitorings = json_decode(json_encode($monitorings->data), True);
  }

  $n_row = 1;

  if(!empty($monitorings) && is_array($monitorings)):?>

      <div class="table-responsive">
          <table class="table table-striped">
              <thead>
              <tr>
                  <th>#</th>
                  <th>Cible</th>
                  <th>Service en relation</th>
                  <th>Etat actuel</th>
                  <th>Actions</th>
              </tr>
              </thead>
              <tbody>

              <?php

              if (is_array($monitorings)) {
                //Each row
                foreach ($monitorings as $key => $value) {


                  ?>

                    <tr id="monitoring_<?= $monitorings[$key]["id"] ?>">
                        <th scope="row"><?= $n_row ?></th>
                        <td><?= $monitorings[$key]["target"] ?></td>
                        <td><strong><?= $monitorings[$key]["service_name"] ?></strong> dans catégorie <span class="text-muted"><?= $monitorings[$key]["category_name"] ?></span></td>
                        <td><?= MonitoringController::getMonitoringPingStatusBadge($monitorings[$key]["target_status"]) ?></td>
                        <td>
                            <form class="deleteForm" class="<?= $n_row ?>">
                                <input hidden="" value="<?=$monitorings[$key]["id"]?>" name="ID" required=""/>
                                <button type="submit" class="btn btn-danger btn-xs" name="deleteMonitoring">
                                    <i class="fa fa-times"></i>
                                </button>
                            </form>
                        </td>
                    </tr>

                  <?php

                  $n_row++;
                }

              }else{
                ?>

                  <h4 class="text-muted text-center">Aucune cible de monitoring n'a été créée à ce jour</h4>

                <?php
              }

              ?>
              </tbody>
          </table>
      </div>

    <?php
  else: //!empty
    ?>

      <div class="alert alert-warning fade in" role="alert">
          <strong>Remarque: </strong>Aucune cible de monitoring n'a été créée à ce jour
      </div>

    <?php

  endif;
  ?>

    <form id="addForm" class="col-sm-12 col-md-4">
        <div class="form-group">
            <label for="">Cible du monitoring</label>
            <input type="text" class="form-control" name="target" placeholder="google.fr, 8.8.8.8" required>
            <p class="help-block">Veuillez saisir un domaine ou une adresse IP.</p>
        </div>
        <div class="form-group">
            <label for="">Service correspondant</label>
            <select class="form-control" name="service" required>

              <?php
              $api = new API();

              //Variables

              $monitorings = json_decode($api->getMonitorings());
              if(isset($monitorings->data) && !empty($monitorings->data)) {
                $monitorings = json_decode(json_encode($monitorings->data), True);
              }

              $services = json_decode($api->getServices());
              if(isset($services->data) && !empty($services->data)) {
                $services = json_decode(json_encode($services->data), True);
              }

              $servicesCount = 0;
              $alreadyUsedServicesCount = 0;


              $alreadyUsedServices = array();


              if($services > 0){
                foreach ($services as $key => $value){

                  ++$servicesCount;

                  if($monitorings > 0){
                    foreach($monitorings as $monitoringKEY => $monitoringValue){
                      array_push($alreadyUsedServices, $monitorings[$monitoringKEY]["internal_attached_service"]);

                      if($monitorings[$monitoringKEY]["internal_attached_service"] == $services[$key]["id"]){
                        ++$alreadyUsedServicesCount;
                      }
                    }
                  }

                }

                if($servicesCount == $alreadyUsedServicesCount):?>
                  <?php $showAllServicesUsed = 1; ?>
                <?php endif;

                foreach($services as $key => $value){
                  if(in_array($services[$key]["id"], $alreadyUsedServices) === FALSE):?>
                      <option value="<?=$services[$key]["id"]?>"><?=$services[$key]["name"]?> dans catégorie "<?=$services[$key]["category_name"]?>"</option>
                  <?php endif;
                }

                if(!is_array($services)):?>
                    <option>Aucun service n'est disponible</option>
                  <?php endif;

                if($showAllServicesUsed == 1):?>
                    <option value="unknown">Aucun service n'est disponible</option>
                <?php endif;



              }

              ?>

            </select>
        </div>

        <div class="form-group">
            <button type="submit" class="btn btn-primary full-width" name="addMonitoringSubmit" <?php if($servicesCount == $alreadyUsedServicesCount):?>disabled<?php endif; ?>>Ajouter la cible <i class="fa fa-plus"></i></button>
        </div>

    </form>

    <div class="col-sm-12 col-md-8">
        <h4>Comment ça marche ?</h4>
        <p>
            Chaque cible de monitoring est contactée régulièrement afin de tester sa disponibilité sur internet. Si une cible venait à ne pas répondre, son statut passera automatiquement en défaillant au sein du système et sera visible en tant que tel dans la section publique.<br><br>
            <span class="text-danger">
                REMARQUE: seuls les domaines et adresses IP seront ciblés, les exemples suivants seront donc analysés comme tels:
                <ul>
                    <li><s>www.</s><strong>domain.ltd</strong><s>/index.php?ID=5</s></li>
                    <li><strong>111.111.1.1</strong><s>:8888</s></li>
                </ul>
            </span>
        </p>
    </div>

</div>

<div class="col-sm-12 col-md-10 dzq-345 animated fadeIn">

    <div class="row">
        <h3 class="text-center text-uppercase">Vue d'ensemble</h3>
        <hr class="col-md-6 col-md-offset-3">
    </div>


    <div id="result"></div> <!-- result div for alerts -->

  <?php

  //Get all data (categories & services)
  $api = new API();
  $categories = json_decode($api->getCategories());
  $services = json_decode($api->getServices());

  //Convert StdClasses into arrays
  $categories = json_decode(json_encode($categories->data), True);
  $services = json_decode(json_encode($services->data), True);

  //Count all items (categories & services)
  $nCategories = 0;
  $nServices = 0;

  if($categories != 0) {
    foreach ($categories as $key) {
      ++$nCategories;
    }
  }
  if($services > 0) {
    foreach ($services as $key) {
      ++$nServices;
    }
  }

  if($nCategories == 0):?>
      <div class="text-center text-muted not-configured-yet">
          <i class="fa fa-magic fa-4x"></i>
          <br>
          <h4 class="text-muted">Aucune catégorie n'a été créée à ce jour !</h4>
          <a href="<?=APP_URL?>/admin/manageItems"><button type="button" class="btn btn-default">Gérer les catégories/services <i class="fa fa-cog fa-spin"></i></button></a>
      </div>
  <?php else: ?>




    <?php foreach($categories as $categoryKey => $categoryValue): ?>
          <div class="panel panel-primary">
              <div class="panel-heading"><?=$categories[$categoryKey]['name']?></div>
              <div class="panel-body">


                  <!-- Data -->
                <?php
                //for each service
                if($services > 0) {

                foreach ($services as $serviceKey => $serviceValue) {
                  if ($services[$serviceKey]['category_id'] == $categories[$categoryKey]['id']): $showTable = 1; endif;
                }

                if($showTable == 1):

                ?>

                      <table class="table table-hover table-striped status-table">
                          <thead>
                          <tr>
                              <th class="col-md-3">Nom du service</th>
                              <th class="col-md-3">Statut du service</th>
                              <th class="col-md-3">Mettre à jour le statut</th>
                          </tr>
                          </thead>
                          <tbody>

                          <?php

                          foreach ($services as $serviceKey => $serviceValue) :


                            if ($services[$serviceKey]['category_id'] == $categories[$categoryKey]['id']):?>

                                <tr>

                                    <td><?=$services[$serviceKey]['name']?></td>

                                    <td id="statut_<?=$services[$serviceKey]['id']?>">

                                      <?=ServicesController::getServiceStatusNoFloat($services[$serviceKey]['status'])?>

                                      <?php if (isset($services[$serviceKey]['accidented']) && $services[$serviceKey]['accidented'] == 1): ?>
                                          <span class="label label-default link hidden-xs hidden-sm" onclick="document.location.href='/admin/accidents/<?=$services[$serviceKey]['accident_serial_id']?>'">Un incident est en cours <i class="fa fa-link"></i></span>

                                          <span class="label label-default link hidden-md hidden-lg" onclick="document.location.href='/admin/accidents/<?=$services[$serviceKey]['accident_serial_id']?>'">Incident ouvert</span>
                                      <?php endif; ?>

                                      <?php if ($services[$serviceKey]['monitored'] == 1): ?>
                                          <span class="label label-default hidden-sm hidden-xs">Ce service est controlé par monitoring <i class="fa fa-signal"></i></span>
                                          <span class="label label-default hidden-md hidden-lg">Monitoring <i class="fa fa-signal"></i></span>
                                      <?php endif; ?>

                                    </td>
                                  <?php if (empty($services[$serviceKey]['accidented']) && empty($services[$serviceKey]['monitored'])): //Show control icons IF not accident declared ?>
                                      <!-- Status icons -->
                                      <td class="updateStatusIcons">

                                          <!-- [1] -->
                                          <div class="dropdown status-block">
                                              <i class="fa fa-check text-success ope" service="<?=$services[$serviceKey]['id']?>"></i>
                                          </div>

                                          <!-- [2] -->
                                          <div class="dropdown status-block">
                                              <i class="fa fa-exclamation-circle text-warning" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"></i>
                                              <span class="caret" data-toggle="dropdown"></span>
                                              <ul class="dropdown-menu">
                                                  <li><a href="#" data-toggle="modal" data-target="#modalCreateAccident" data-servicename="<?=$services[$serviceKey]['name']?>" data-serviceid="<?=$services[$serviceKey]['id']?>" data-servicestatus="2">Panne avec incident <i class="fa fa-pencil"></i></a></li>
                                                  <li class="divider"></li>
                                                  <li><a href="#" class="partielle" service="<?= $services[$serviceKey]['id'] ?>">Panne sans accident <i class="fa fa-bolt"></i></a></li>
                                              </ul>
                                          </div>

                                          <!-- [3] -->
                                          <div class="dropdown status-block">
                                              <i class="fa fa-bolt text-danger" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"></i>
                                              <span class="caret" data-toggle="dropdown"></span>
                                              <ul class="dropdown-menu">
                                                  <li><a href="#" data-toggle="modal" data-target="#modalCreateAccident" data-servicename="<?=$services[$serviceKey]['name']?>" data-serviceid="<?=$services[$serviceKey]['id']?>" data-servicestatus="3">Panne avec incident <i class="fa fa-pencil"></i></a></li>
                                                  <li class="divider"></li>
                                                  <li><a href="#" class="defaillant" service="<?= $services[$serviceKey]['id'] ?>">Panne sans accident <i class="fa fa-bolt"></i></a></li>
                                              </ul>
                                          </div>

                                          <!-- [4] -->
                                          <div class="dropdown status-block">
                                              <i class="fa fa-cogs text-primary" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"></i>
                                              <span class="caret" data-toggle="dropdown"></span>
                                              <ul class="dropdown-menu">
                                                  <li><a href="#" data-toggle="modal" data-target="#modalCreateAccident" data-servicename="<?=$services[$serviceKey]['name']?>" data-serviceid="<?=$services[$serviceKey]['id']?>" data-servicestatus="4">Panne avec incident <i class="fa fa-pencil"></i></a></li>
                                                  <li class="divider"></li>
                                                  <li><a href="#" class="maintenance" service="<?= $services[$serviceKey]['id'] ?>">Panne sans accident <i class="fa fa-bolt"></i></a></li>
                                              </ul>
                                          </div>

                                          <!-- [LOADER] -->
                                          <div class="dropdown status-block status-update-loader-<?=$services[$serviceKey]['id']?>" style="display: none;"><i class="fa fa-refresh fa-spin fa-fw text-default"></i></div>

                                      </td>
                                  <?php endif; ?>

                                  <?php if(isset($services[$serviceKey]['accidented']) && $services[$serviceKey]['accidented'] == 1):?>
                                      <td>
                                          <span class="label btn-purple link hidden-sm hidden-xs" onclick="document.location.href='/admin/accidents/<?=$services[$serviceKey]['accident_serial_id']?>'">Mettre à jour l'incident <i class="fa fa-newspaper-o"></i></span>

                                          <span class="label btn-purple link hidden-md hidden-lg" onclick="document.location.href='/admin/accidents/<?=$services[$serviceKey]['accident_serial_id']?>'">Voir incident</span>

                                      </td>
                                  <?php endif; ?>


                                  <?php if($services[$serviceKey]['monitored'] == 1):?>
                                      <td>
                                          <span class="label label-default link hidden-sm hidden-xs" onclick="document.location.href='/admin/monitoring/'">Accéder aux monitoring <i class="fa fa-link"></i></span>
                                          <span class="label label-default link hidden-md hidden-lg" onclick="document.location.href='/admin/monitoring/'">Gérer... <i class="fa fa-link"></i></span>
                                      </td>
                                  <?php endif; ?>
                                </tr>

                              <?php

                            endif;

                          endforeach;

                          $showTable = 0;

                          else:?>
                              <span class="text-muted">Aucun service pour cette catégorie</span>
                            <?php

                          endif;
                          }
                          ?>
                          <!-- Data [END] -->

                          </tbody>
                      </table>

                  <a href="<?=APP_URL?>/admin/manageItems?addService&categoryID=<?=$categories[$categoryKey]['id']?>">
                      <button class="btn btn-default btn-sm full-width-mobile">Ajouter un service <i class="fa fa-plus"></i></button>
                  </a>

              </div>
          </div>
    <?php endforeach; ?>




  <?php endif; ?>

</div>

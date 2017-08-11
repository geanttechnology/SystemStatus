<div class="col-sm-12 col-md-10 dzq-345 animated fadeIn">
    <div class="row">
        <h3 class="text-center text-uppercase">Infrastructures</h3>
        <hr class="col-md-6 col-md-offset-3">
    </div>
    <div id="result"></div>
  <?php
  /*
  Form execution
  */
  ?>

    <!-- Not attached services -->
  <?php

  $api = new API();
  $services = json_decode($api->getServices());
  $services = json_decode(json_encode($services->data), True);
  $nDetachedServices = 0;

  if($services > 0) {
    foreach ($services as $key => $value) {
      if ($services[$key]['category_id'] == 0) :
        ++$nDetachedServices;
      endif;
    }
  }

  if($nDetachedServices > 0):
    ?>
      <div class="alert alert-warning" role="alert">
          Il semblerait qu'un ou plusieurs service(s) ne soi(en)t pas rattaché(s) à une catégorie
      </div>
  <?php endif;

  if($services > 0) {
    foreach ($services as $key => $value) {
      if ($services[$key]['category_id'] == 0) :
        ?>
          <div class="list-group">
              <a href="#" class="list-group-item no-link">
                  <h4 class="list-group-item-heading pull-left non-assigned-service-h4"><?=$services[$key]['name'];?></h4>
                  <p class="list-group-item-text text-right">
                      <button type="button" class="btn btn-info btn-sm non-assigned-service-btn" onClick="assignService(<?=$services[$key]['id']?>, '<?=$services[$key]['name']?>')">Assigner à une catégorie</button>
                      <button service="<?=$services[$key]['id']?>" class="btn btn-danger btn-sm deleteService">Supprimer</button>
                  </p>
              </a>
          </div>
        <?php
      endif;
    }
  }

  ?>

    <div class="modal fade" tabindex="-1" role="dialog" id="assignServiceModal">
        <div class="modal-dialog" role="document">
            <form method="post">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title">Configuration de <span id="assignServiceModalName"></span></h4>
                    </div>
                    <div class="modal-body">

                        <div class="form-group">
                            <label>Catégorie du service</label>
                            <select class="form-control" name="category" required id="assignedCategory">
                              <?php
                              $api = new API();
                              $categories = json_decode($api->getCategories());
                              $categories = json_decode(json_encode($categories->data), True);

                              $nC = 0;

                              if(is_array($categories)) {

                                foreach ($categories as $key => $value):
                                  ++$nC; ?>
                                    <option value="<?= $categories[$key]["id"] ?>" <?php if ($nC == 1): ?>selected="selected"<?php endif; ?>><?= $categories[$key]["name"] ?></option>
                                  <?php
                                endforeach;

                              }

                              if($nC == 0):?>
                                  <option>Aucune catégorie</option>
                              <?php endif; ?>

                            </select>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Annuler</button>
                        <button type="button" class="btn btn-primary" id="assignServiceModalID" name="assignService_id" <?php if($nC == 0):?>disabled<?php endif;?>>Assigner le service</button>
                    </div>
                </div><!-- /.modal-content -->
            </form>
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->

    <script>
        function assignService($id, $name)
        {
            $('#assignServiceModal').modal('show');
            $('.dzq-345').removeClass('animated fadeIn');
            $("#assignServiceModalName").html($name);
            $("#assignServiceModalID").attr("service", $id);
        }
    </script>
    <!-- Not attached services [END]-->

    <!-- Category list -->
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
  //Count all items (categories & services) [END]

  if($nCategories == 0):?>
      <br>
      <div class="text-center text-muted">
          <h4 class="text-muted">Aucune catégorie à afficher</h4>
      </div>
      <hr>

  <?php else: ?>

    <?php $nC = 0; $nServices = 0; ?>

      <div class="panel-group col-sm-12 col-md-4" id="accordion" role="tablist" aria-multiselectable="true">

        <?php

        //for each category
        foreach($categories as $categoryKey => $categoryValue):

          $nC++;
          $nServices = 0;

          ?>

            <div class="panel panel-default">
                <div class="panel-heading" role="tab" id="heading_<?=$nC?>">
                    <h4 class="panel-title">
                        <a class="<?php if($nC != 1): ?>collapsed<?php endif; ?> no-link" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapse<?=$nC?>" aria-expanded="<?php if($nC == 1): ?>true<?php else: ?>false<?php endif; ?>" aria-controls="collapse<?=$nC?>">
                          <?=$categories[$categoryKey]["name"];?>
                        </a>
                      <?php
                      if($services > 0) {
                        foreach ($services as $serviceKey => $serviceValue) {
                          if($services[$serviceKey]['category_id'] == $categories[$categoryKey]['id']){
                            ++$nServices;
                          }
                        }
                      }
                      ?>
                        &nbsp;<span class="badge"><?=$nServices?></span>
                      <?php
                      $upperStatus = 1;
                      if($services > 0) {
                        foreach ($services as $serviceKey => $serviceValue) {
                          //control upper status => if(service of this category && control upperStatus)
                          if ($services[$serviceKey]['category_id'] == $categories[$categoryKey]['id'] && $services[$serviceKey]['status'] > $upperStatus) {
                            $upperStatus = $services[$serviceKey]['status'];
                          }
                        }
                      }
                      ?>
                      <?php CategoryController::getCategoryStatus($upperStatus); ?>
                        <!-- Delete category btn -->
                        <button type="button" class="btn btn-danger btn-xs pull-right  hidden-sm hidden-xs" data-toggle="modal" data-target="#deleteCategory-<?=$categories[$categoryKey]["id"]?>" onclick="$('.dzq-345').removeClass('animated fadeIn')">Supprimer <i class="fa fa-times-circle"></i></button>
                        <button type="button" class="btn btn-danger btn-xs pull-right hidden-md hidden-lg" data-toggle="modal" data-target="#deleteCategory-<?=$categories[$categoryKey]["id"]?>" onclick="$('.dzq-345').removeClass('animated fadeIn')"><i class="fa fa-times-circle"></i></button>
                        <!-- Modal -->
                        <div class="modal fade" id="deleteCategory-<?=$categories[$categoryKey]["id"]?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                        <h4 class="modal-title" id="myModalLabel">Demande de confirmation</h4>
                                    </div>
                                    <div class="row">
                                        <div class="modal-body">
                                            <div class="col-sm-12 col-md-4 text-center">
                                                <i class="fa fa-exclamation-triangle fa-5x"></i>
                                            </div>
                                            <div class="col-sm-12 col-md-8">
                                                <h4>Attention !</h4>
                                                <p>Supprimer la catégorie <i><?=$categories[$categoryKey]["name"];?></i> <strong>supprimera aussi les services qu'elle contient</strong> !</p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-default" data-dismiss="modal">Annuler</button>
                                        <button class="btn btn-danger deleteAllCategory" data-dismiss="modal" category="<?=$categories[$categoryKey]["id"]?>">Tout supprimer</button>
                                        <button class="btn btn-warning deleteCategory" data-dismiss="modal" category="<?=$categories[$categoryKey]["id"]?>">Uniquement la catégorie</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </h4>
                </div>
                <div id="collapse<?=$nC?>" class="panel-collapse collapse <?php if($nC == 1): ?>in<?php endif; ?>" role="tabpanel" aria-labelledby="heading_<?=$nC?>">
                    <div class="panel-body">

                      <?php

                      $nS = 0;

                      if($services > 0) {

                        foreach ($services as $serviceKey => $serviceValue) {

                          if ($services[$serviceKey]['category_id'] == $categories[$categoryKey]['id']):
                            ++$nS;
                          endif;

                        }
                      }

                      if($nS == 0): ?>
                          <div class="text-left text-muted">
                              <h5 class="text-muted"><i class="fa fa-info-circle"></i> Aucune service lié à cette catégorie</h5>
                          </div>
                      <?php endif;

                      //for each service
                      if($services > 0) {

                        foreach ($services as $serviceKey => $serviceValue) {

                          if ($services[$serviceKey]['category_id'] == $categories[$categoryKey]['id']):?>

                              <span id="service_<?= $services[$serviceKey]['id'] ?>">
                                   <?= $services[$serviceKey]['name'] ?>&nbsp;
                                   <i service="<?= $services[$serviceKey]['id'] ?>" class="fa fa-times text-danger deleteService" style="margin-top: 2px"></i>
                                <?php ServicesController::getServiceStatus($services[$serviceKey]['status']) ?>
                                  <br>
                                </span>
                            <?php

                          endif;
                        }

                      }

                      ?>

                    </div>
                </div>
            </div>


          <?php $nServices = 0; $nS = 0; $upperStatus = 1;?>
        <?php endforeach; ?>

      </div>

  <?php endif;
  ?>


    <div class="col-sm-12 col-md-4">
        <div class="panel panel-primary">
            <div class="panel-heading">Ajouter une catégorie</div>
            <div class="panel-body">
                <form id="categoryForm">
                    <div class="form-group" id="helpAddCategory">
                        <label>Nom de la catégorie</label>
                        <input id="addCategory" type="text" class="form-control" name="name" placeholder="Nom de la catégorie" required autocomplete="off">
                        <span class="help-block" id="helpAddCategoryValue"></span>
                    </div>
                    <button id="addCategorySubmit" type="submit" class="btn btn-primary col-sm-12 full-width-mobile" name="submit_addCategory">Ajouter la catégorie <i class="fa fa-plus"></i></button>
                    <div class="text-muted">
                        <i class="fa fa-info-circle"></i>
                        <strong>Remarque:</strong>
                        Les caractères spéciaux et accents ne sont pas pris en charge.
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="col-sm-12 <?php if($nCategories == 0): ?>col-md-8<?php else: ?>col-md-4<?php endif; ?>">
        <div class="panel panel-primary">
            <div class="panel-heading">Ajouter un service</div>
            <div class="panel-body">
                <form id="servicesForm">
                    <div class="form-group" id="helpAddService">
                        <label>Nom du service</label>
                        <input id="addService" type="text" class="form-control" name="name" placeholder="Nom du service" required autocomplete="off">
                    </div>
                    <div class="form-group">
                        <label>Catégorie du service</label>
                      <?php

                      //Initialize value
                      $focusState = 0;

                      if(is_array($categories)) {
                        foreach ($categories as $key => $value):
                          if (isset($_GET['categoryID']) && $_GET['categoryID'] == $categories[$key]["id"]) {
                            $focusState = 1;
                          }else{
                            $focusState = 0;
                          }
                        endforeach;
                      }else{
                        $focusState = 0;
                      }
                      ?>
                        <select class="form-control<?php if($focusState == 1): ?> focus<?php endif; ?>" name="category" id="addServiceCategory" required>
                          <?php
                          $api = new API();
                          $categories = json_decode($api->getCategories());
                          $categories = json_decode(json_encode($categories->data), True);

                          $nC = 0;

                          if(is_array($categories)) {

                            foreach ($categories as $key => $value): ++$nC; ?>

                              <?php if (isset($_GET['addService']) && null !== $_GET['addService'] && isset($_GET['categoryID']) && !empty($_GET['categoryID'])): ?>
                                    <option value="<?= $categories[$key]["id"] ?>" data-categoryName="<?= $categories[$key]["name"] ?>" <?php if ($_GET['categoryID'] == $categories[$key]["id"]): ?>selected="selected"<?php endif; ?>><?= $categories[$key]["name"] ?></option>
                              <?php else : ?>
                                    <option value="<?= $categories[$key]["id"] ?>" data-categoryName="<?= $categories[$key]["name"] ?>" <?php if ($nC == 1): ?>selected="selected"<?php endif; ?>><?= $categories[$key]["name"] ?></option>
                              <?php endif;

                            endforeach;

                          }

                          if($nC == 0):?>
                              <option>Aucune catégorie</option>
                          <?php endif; ?>

                        </select>
                    </div>
                    <div class="form-group">
                        <label>Statut du service</label>
                        <select class="form-control" name="statut" required>
                            <option value="1">Opérationnel</option>
                            <option value="2">Panne partielle</option>
                            <option value="3">Défaillant</option>
                            <option value="4">Maintenance</option>
                        </select>
                    </div>
                    <span class="help-block text-justify" id="helpAddServiceValue"></span>
                    <button id="addServiceSubmit" type="submit" class="btn btn-primary col-xs-12 m-b-10" name="submit_addService" <?php if($nC == 0):?>disabled<?php endif; ?>>Ajouter le service <i class="fa fa-plus"></i></button>
                    <div class="text-muted">
                        <i class="fa fa-info-circle"></i>
                        <strong>Remarque:</strong>
                        Veuillez noter qu'une catégorie ne peut pas présenter deux fois le même nom de service. Toutefois, un même nom de service peut se retrouver dans plusieurs catégories.
                    </div>
                </form>
            </div>
        </div>
    </div>

</div>

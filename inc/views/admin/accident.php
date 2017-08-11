<?php

//Init variables
$accident = "";
$category = "";
$service = "";
$replies = "";

if(!empty(ACCIDENT_ID)){


  /* //////////////:============================://////////////////////
     *    [START] Check if accident exists && get DATA [START]
     * //////////////:============================:////////////////////// */

  $accidentSerialId = htmlspecialchars(ACCIDENT_ID);

  //Get all data (categories & services)
  $api = new API();
  $result = json_decode($api->getAccident($accidentSerialId));

  unset($accidentSerialId);
  unset($api);

  //Convert StdClasses into arrays
  $accident = json_decode(json_encode($result->data), True);
  $service = json_decode(json_encode($result->service), True);
  $replies = json_decode(json_encode($result->replies), True);
  $category = json_decode(json_encode($result->category), True);

  unset($result);

  if($accident == 0 || $accident['status'] == "error"){
    header("Location: " . APP_URL . "/admin");
    exit(0);
  }


  /* //////////////:============================://////////////////////
  *    [END] Check if accident exists && get DATA [END]
  * //////////////:============================:////////////////////// */

}else{
  header("Location: /admin/");
}

//Control url [END] ///////////////////////////////////////////////////////////////////////////////////////////////////////////////

?>

<?php $this->layout('layouts::admin'); ?>

<div class="col-md-10 col-sm-12">
    <ol class="breadcrumb">
        <li><a href="<?=APP_URL?>/admin">Accueil</a></li>
        <li><a  class="active" href="<?=APP_URL?>/admin/accidents/<?=ACCIDENT_ID?>">Incident #<?=ACCIDENT_ID?></a></li>
    </ol>
</div>

<div class="jumbotron col-sm-12 col-md-10 dzq-345 ">
    <div id="result"></div>

    <h3 class="col-md-12">
        Rapport d'incident #<?=$accident['accident_serial_id']?>
        <small>Statut de l'incident: <?=AdminController::getIncidentStatus($accident['accident_status'])?></small>
    </h3>

    <dl class="dl-horizontal col-md-12">

        <dt>Création de l'incident</dt>
        <dd>Créé <strong><?= Api::getDate($accident['date'])?></strong> par <strong><?=$accident["author_username"]?></strong></dd>

        <dt>Service lié</dt>
        <dd><strong><?=$service["name"]?></strong> dans la catégorie <strong><?php echo $category["name"]; unset($category); ?></strong></dd>

      <?php
      $lastUpdate = ($replies != "N/D") ? $accident['last_update'] : $accident['date'];
      ?>

        <dt>Dernière mise à jour</dt>
        <dd>
            <span class="pull-left">
              <?php echo ServicesController::getServiceStatusByStatusId($service["status"])." ".Api::getDate($lastUpdate); unset($service); ?>
            </span>
        </dd>

    </dl>

    <hr class="col-md-10">

    <div class="col-md-4">
        <h4>Rapport initial</h4>
        <p><?php AccidentsController::getAccidentReplyContent($accident['content']) ?></p>

      <?php if($accident['accident_status'] == 0):?>
              <button type="button" id="deleteBtn" class="btn btn-danger full-width"><i class="fa fa-trash"></i> Supprimer l'incident</button>
      <?php endif; ?>

    </div>

  <?php if($accident['accident_status']== 1): ?>
      <div class="col-md-4">
          <h4>Mise à jour du rapport</h4>
          <form id="updateForm">
              <div class="form-group">
                  <textarea id="addReplyContent" name="content" rows="8" cols="80" class="form-control"></textarea>
                  <br>
                  <button type="button" name="addReplySubmit" class="btn btn-primary col-xs-12" data-toggle="modal" data-target="#modalUpdateAccident">Envoyer <i class="fa fa-send"></i></button>
              </div>

              <!-- Modal -->
              <div class="modal fade" id="modalUpdateAccident" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                  <div class="modal-dialog" role="document">
                      <div class="modal-content">
                          <div class="modal-header">
                              <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                              <h4 class="modal-title" id="myModalLabel">Demande de confirmation</h4>
                          </div>
                          <div class="modal-body">
                              <p>Veuillez selectionner un statut pour la mise à jour de l'incident</p>
                              <select class="form-control" name="status">
                                <?php
                                $possible_status = array(1 => "Opérationnel", 2 => "Panne partielle", 3 => "Défaillant", 4 => "Maintenance");
                                foreach ($possible_status as $key => $value) :
                                  if($key != $accident['service_status']):?> <option value="<?=$key?>"><?=$value?></option> <?php endif; ?>
                                <?php endforeach ?>
                              </select>
                              <!-- Mobile -->
                              <div class="hidden-md hidden-lg">
                                  <br>
                                  <div class="form-group">
                                      <button id="createAccidentSubmit" type="submit" name="addReplySubmitWithUpdate" class="btn btn-primary form-control">
                                          Mettre à jour le statut
                                      </button>
                                  </div>
                              </div>
                              <div class="modal-footer">
                                  <!-- Desktop -->
                                  <div class="row hidden-xs hidden-sm">
                                      <button type="button" class="btn btn-default" data-dismiss="modal">Annuler</button>
                                      <button id="createAccidentSubmit" type="submit" name="addReplySubmitWithUpdate" class="btn btn-primary">
                                          Mettre à jour le statut
                                      </button>
                                  </div>

                                  <!-- Mobile -->
                                  <button type="button" class="btn btn-default hidden-md hidden-lg" data-dismiss="modal">Annuler</button>
                              </div>
                          </div>
                      </div>
                  </div>
              </div>
              <!-- Modal [end]-->

          </form>
      </div>

      <div class="col-sm-12 col-md-4">
          <h4>Modification de l'incident</h4>
          <button type="button" id="resolveBtn" class="btn btn-success full-width-mobile">Marquer comme résolu <i class="fa fa-check"></i></button>
      </div>

  <?php endif; ?>

    <h4 class="col-sm-12 <?php if($accident['accident_status'] == 0):?> col-md-8 pull-right <?php endif; ?>">Mises à jour de l'incident</h4>

  <?php if($replies != "N/D"):
    foreach ($replies as $key => $value):?>
        <div class="col-sm-12 <?php if($accident['accident_status']== 1):?> col-md-12 <?php else:?> col-md-8 pull-right <?php endif; ?>">
            <br>
            <div class="panel panel-default">
                <div class="panel-heading">
                    Réponse par <strong><?=$replies[$key]['author_username']?></strong>
                    <br>
                    Mise à jour du statut du service : <?=ServicesController::getServiceStatusByStatusId($replies[$key]['service_status_update'])?>
                    <span class="pull-right hidden-xs hidden-sm">Publiée <?=Api::getDate($replies[$key]['date'])?></span>
                    <span class="hidden-md hidden-lg pull-right text-muted"><br>Publiée <?=Api::getDate($replies[$key]['date'])?></span>
                </div>
                <br class="hidden-md hidden-lg">
                <div class="panel-body">
                  <?=$replies[$key]['content']?>
                </div>
            </div>
        </div>
    <?php endforeach;

    unset($accident);
    unset($replies);

  else: ?>

      <div class="alert alert-info fade in col-sm-12 col-md-4" role="alert">
          Aucune mise à jour pour le moment
      </div>

  <?php endif; ?>
</div>

<script>
    $("#updateForm").on("submit", function(e){
        e.preventDefault();
        $.ajax({
            url: "<?=APP_URL?>/admin/accidents/update",
            type: "POST",
            data: $(this).serialize()+"&action=content&ID=<?=ACCIDENT_ID?>",
            success: function(data)
            {
                $('#modalUpdateAccident').modal('hide');
                $("#notification").html(data);
            }
        });
    });

    $("#resolveBtn").on("click", function(){
        $.ajax({
            url: "<?=APP_URL?>/admin/accidents/close",
            type: "POST",
            data: "ID=<?=ACCIDENT_ID?>",
            success: function(data)
            {
                $("#notification").html(data);
            }
        });
    });

    $("#deleteBtn").on("click", function(){
        $.ajax({
            url: "<?=APP_URL?>/admin/accidents/delete",
            type: "POST",
            data: "ID=<?=ACCIDENT_ID?>",
            success: function(data)
            {
                $("#notification").html(data);
            }
        });
    });
</script>

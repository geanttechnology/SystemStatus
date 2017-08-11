<?php
SecurityController::checkAccess(3, 2);
$this->layout('layouts::admin');
?>
<div class="col-md-10 col-sm-12">
  <ol class="breadcrumb">
      <li><a href="<?=APP_URL?>/admin">Accueil</a></li>
      <li><a class="active" href="<?=APP_URL?>/admin/update">Mises à jour</a></li>
  </ol>
</div>

<div id="step1">
  <div class="col-sm-12 col-md-10 dzq-345 animated fadeIn">
    <h4>Mises à jour</h4>
    <br>
    <p>Téléchargement du script de mise à jour de la version : <b><?=file_get_contents('https://api.systemstatus.fr/version.txt')?></b><br>
    Veuillez patienter le temps du téléchargement.</p>
    <a class="btn btn-success btn-block disabled"><i class="fa fa-refresh fa-spin  fa-fw"></i><span class="sr-only">Loading...</span> Téléchargement en cours ...</a>
  </div>
</div>

<div id="step2">
  <div class="col-sm-12 col-md-10 dzq-345 animated fadeIn">
    <h4>Mises à jour</h4>
    <br>
    <p>Votre version actuelle : <?=CMS_VERSION?> <br> Version disponible : <?=file_get_contents('https://api.systemstatus.fr/version.txt')?></p>
    <a href="<?=APP_URL?>/update.php" class="btn btn-success btn-block">Mettre à jour</a>
  </div>
</div>

<script>
$(document).ready(function(){
  $("#step2").hide();
  checkDownload();
  $.ajax({
    url: "<?=APP_URL?>/admin/update/download",
    type: "POST",
    data: "action=download",
  });
});

function checkDownload()
{
  $.ajax({
    url: "<?=APP_URL?>/admin/update",
    type: "POST",
    data: "action=checkDownload",
    success: function()
    {
      $("#step1").hide();
      $("#step2").show();
    },
    error: function()
    {
      $("#step2").hide();
      $("#step1").show();
    }
  });
  window.setTimeout(function() { checkDownload() }, 5000)
}
</script>

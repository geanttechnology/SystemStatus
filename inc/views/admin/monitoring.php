<?php
SecurityController::checkAccess(3, 2);
$this->layout('layouts::admin');
?>

<div class="col-md-10 col-sm-12">
    <ol class="breadcrumb">
        <li><a href="<?=APP_URL?>/admin">Accueil</a></li>
        <li><a  class="active" href="<?=APP_URL?>/admin/monitoring">Monitoring</a></li>
    </ol>
</div>

<?php Theme::loadView('admin/monitoring'); ?>

<script>
$(".deleteForm").on("submit", function(e){
  e.preventDefault();
  $.ajax({
    url: "<?=APP_URL?>/admin/monitoring/delete",
    type: "POST",
    data: $(this).serialize(),
    success: function(data)
    {
      $("#monitoring_"+$(this).attr('class')).hide();
      $("#notification").html(data);
    }
  });
});

$("#addForm").on("submit", function(e){
  e.preventDefault();
  $.ajax({
    url: "<?=APP_URL?>/admin/monitoring/add",
    type: "POST",
    data: $(this).serialize(),
    success: function(data)
    {
      $("#notification").html(data);
    }
  });
});
</script>

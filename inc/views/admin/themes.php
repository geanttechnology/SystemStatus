<?php
SecurityController::checkAccess(3, 2);
$this->layout('layouts::admin');
?>

<div class="col-md-10 col-sm-12">
    <ol class="breadcrumb">
        <li><a href="<?=APP_URL?>/admin"><?=LANG["admin"]["side-bar"]["maj-home"] ?></a></li>
        <li><a  class="active" href="<?=APP_URL?>/admin/themes"><?=LANG["admin"]["side-bar"]["maj-themes"] ?></a></li>
    </ol>
</div>


<?php Theme::loadView('admin/themes'); ?>

<script>
$(function () {
  $('[data-toggle="tooltip"]').tooltip();
  $('[data-toggle="tooltip1"]').tooltip();
});

$(".activeTheme").on("click", function(){
  $.ajax({
    url: "<?=APP_URL?>/admin/themes/active/"+this.id,
    type: "POST",
    data: "",
    success: function(data)
    {
      $("#notification").append(data);
    }
  });
});

$(".disableTheme").on("click", function(){
  $.ajax({
    url: "<?=APP_URL?>/admin/themes/disable/"+this.id,
    type: "POST",
    data: "",
    success: function(data)
    {
      $("#notification").append(data);
    }
  });
});

$(".deleteTheme").on("click", function(){
  $.ajax({
    url: "<?=APP_URL?>/admin/themes/delete/"+this.id,
    type: "POST",
    data: "",
    success: function(data)
    {
      $("#tr_"+this.id).hide();
      $("#notification").append(data);
    }
  });
});
</script>

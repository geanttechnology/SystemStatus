<?php $this->layout('layouts::admin'); ?>

<div class="col-md-10 col-sm-12">
    <ol class="breadcrumb">
        <li><a href="<?=APP_URL?>/admin">Accueil</a></li>
        <li><a href="<?=APP_URL?>/admin/themes/edit/<?=THEME_NAME_?>">Edition d'un thème</a></li>
    </ol>
</div>

<?php Theme::loadView('admin/edit_theme'); ?>

<script>
$(".edit").on("change", function(e){
  e.preventDefault();
  $.ajax({
    url: "<?=APP_URL?>/admin/themes/edit",
    type: "POST",
    data: 'file='+$(this).attr('id')+'&content='+$(this).val()+'&theme=<?=THEME_NAME_?>',
    success: function(data)
    {
      $("#notification").append(data);
    }
  });
});
</script>

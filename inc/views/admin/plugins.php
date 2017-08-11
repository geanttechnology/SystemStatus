<?php
SecurityController::checkAccess(3, 2);
$this->layout('layouts::admin');
?>

<div class="col-md-10 col-sm-12">
    <ol class="breadcrumb">
        <li><a href="<?=APP_URL?>/admin">Accueil</a></li>
        <li><a  class="active" href="<?=APP_URL?>/admin/plugins">Plugins</a></li>
    </ol>
</div>

<?php Theme::loadView('admin/plugins'); ?>

<div class="list-group">
    <button type="button" class="list-group-item">Bienvenue <?=Auth::getUsername()?>
        <small class="pull-right">Accès de niveau <?=Auth::getTypeAccount(Auth::getRank())?></small>
    </button>
    <button type="button" class="list-group-item list-group-item-danger" onclick="document.location.href='<?=APP_URL?>/logout'">Déconnexion<i class="fa fa-lock pull-right nav-icon"></i></button>
</div>
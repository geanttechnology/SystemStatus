<nav class="navbar navbar-deglyphiconult navbar-fixed-top col-sm-12">
    <div class="container-fluid">
        <div class="navbar-header">
            <a class="navbar-brand" href="<?=APP_URL?>/admin">
               <span class="active">SystemStatus</span> <span class="hidden-xs hidden-sm">Admin</span> Panel
            </a>
        </div>


        <ul class="nav navbar-nav navbar-right">
            <li style="line-height: 4; margin-right: 10px;">
                <div class="dropdown">
                    <button class="btn btn-default btn-sm dropdown-toggle hidden-xs hiddem-sm" type="button" id="dropdownProfile" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                        <img src="<?= APP_URL ?>/inc/assets/img/user-profile.png" alt="">&nbsp;&nbsp;<?=Auth::getUsername()?>
                        <span class="caret"></span>
                    </button>
                    <button style="position: fixed; top: 10px; right: 20px;" class="btn btn-default btn-sm dropdown-toggle hidden-md hidden-lg" type="button" id="dropdownProfile" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                        <i class="fa fa-navicon"></i>
                    </button>
                    <ul class="dropdown-menu" aria-labelledby="dropdownProfile">
                        <li><a href=""><b>Accès rapide</b></a></li>
                        <li><a href="<?=APP_URL?>/admin">Accueil<span class="pull-right"><i class="fa fa-home"></i></span></a></li>
                        <?php if(SecurityController::checkAccess(3)): ?>
                            <li><a href="<?=APP_URL?>/admin/users">Utilisateurs<span class="pull-right"><i class="fa fa-user"></i></span></a></li>
                            <li><a href="<?=APP_URL?>/admin/manageItems">Infrastructures<span class="pull-right"><i class="fa fa-align-justify"></i></span></a></li>
                            <li><a href="<?=APP_URL?>/admin/monitoring">Monitoring<span class="pull-right"><i class="fa fa-signal"></i></span></a></li>
                            <li><a href="<?=APP_URL?>/admin/themes">Thèmes<span class="pull-right"><i class="fa fa-paint-brush"></i></span></a></li>
                            <li><a href="<?=APP_URL?>/admin/settings">Paramètres<span class="pull-right"><i class="fa fa-cogs"></i></span></a></li>
                        <?php endif; ?>
                        <li role="separator" class="divider"></li>
                        <li><a href="/logout"><span class="text-danger">Déconnexion<span class="pull-right"><i class="fa fa-lock"></i></span></span></a></li>
                    </ul>
                </div>

            </li>

            <li class="hidden-sm hidden-xs"><a href="<?=APP_URL?>/">Revenir sur la page statut...</a></li>

        </ul>


    </div>
</nav>
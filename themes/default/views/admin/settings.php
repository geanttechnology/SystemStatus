<?php

/*Copyright © 2017 by SystemStatus.fr
All rights reserved. This file or any portion thereof MUST contain the following copyrights.*/

?>
<!-- Custom Ressources -->
<link href="<?=APP_URL?>/inc/assets/css/bootstrap-toggle.min.css" rel="stylesheet">
<script src="<?=APP_URL?>/inc/assets/js/bootstrap-toggle.min.js"></script>

<div class="col-sm-12 col-md-10 dzq-345 animated fadeIn">
    <h3 class="text-center text-uppercase">Configuration</h3>

    <hr class="col-md-6 col-md-offset-3">

    <div class="row">

        <div class="col-md-12">
            <h4>Information de licence</h4>

            <div class="row">
                <div class="col-md-3">
                    <label>Licence</label>
                    <pre class="text-center"><?=CMS_LICENCE?></pre>
                </div>
                <div class="col-md-3">
                    <label>Clé d'API <small class="text-danger">- HAUTEMENT CONFIDENTIELLE</small></label>
                    <pre class="text-center"><?=CMS_API?></pre>
                </div>
            </div>
        </div>

        <form id="updateProductNameForm" class="col-md-6">
            <div id="resultUpdateProductNameForm"></div>

            <h4>Personnalisation</h4>

            <div class="form-group">
                <label>Nom du site web <small>- laisser vide pour revenir à la configuration par défaut</small></label>
                <input type="text" class="form-control" name="name" id="name" placeholder="Par exemple: AddictProject" value="<?=APP_NAME?>">
                <span class="help-block"><i class="fa fa-info-circle"></i>&nbsp;Cela remplacera le logo <i>SystemStatus</i> sur la section publique</span>
            </div>
            <div class="row">
                <div class="form-group col-md-12">
                    <button type="button" class="btn btn-default full-width-mobile btn-sm" id="reset">Réinitialiser <i class="fa fa-times"></i></button>
                    <button class="btn btn-primary full-width-mobile sma-232 btn-sm" type="submit" name="custom_submit">Enregistrer les modifications <i class="fa fa-check"></i></button>
                </div>
            </div>
        </form>

        <form id="updateProductMaintenanceForm" class="col-md-6">
            <div id="resultUpdateProductMaintenanceForm"></div>
            <h4>Procédures techniques</h4>
            <div class="form-group">
                <label>Mode maintenance</label>
                <br>
                <input id="toggleUpdateProductMaintenanceForm" type="checkbox" data-toggle="toggle" data-on="Actif" data-off="Inactif">
                <span class="help-block"><i class="fa fa-info-circle"></i>&nbsp;Cette fonctionnalité affiche un message de maintenance à vos visiteurs<br> le temps que vous configuriez votre CMS</span>
            </div>
          <?php if(app::inMaintenance()): ?>
              <script>
                  $("#toggleUpdateProductMaintenanceForm").bootstrapToggle('toggle');
              </script>
          <?php endif; ?>
        </form>
    </div>

    <div class="panel panel-danger">
        <div class="panel-body">
            <h4>Réinstallation du CMS</h4>

            <div id="resultResetForm"></div>

            <p>
                <strong>La réinstallation du CMS implique la suppression de toutes les données relatives à votre licence. Une fois l'opération confirmée, impossible de revenir en arrière</strong>
            </p>

            <button class="btn btn-danger btn-sm full-width-mobile col-md-12" data-toggle="modal" data-target="#resetCMSModal"><i class="fa fa-exclamation-triangle"></i>&nbsp;Réinstaller le CMS&nbsp;<i class="fa fa-exclamation-triangle"></i></button>
        </div>
    </div>

</div>

<!-- Modal -->
<div class="modal fade" id="resetCMSModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">Confirmez votre identité</h4>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <label>Veuillez saisir votre mot de passe</label>
                    <input id="resetCMS-username" type="hidden" value="<?=Auth::getUsername()?>">
                    <input id="resetCMS-password" type="password" class="form-control" placeholder="*****************">
                </div>
                <span class="text-muted">En cliquant sur "Réinstaller", vous déclarez avoir été averti des conséquences de la résinatallation de votre CMS. Ni SystemStatus ni son staff ne pouront être tenus responsables de votre décision.</span>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Annuler</button>
                <button type="submit" class="btn btn-danger" id="confirmResetCMS">Réinitialiser <i class="fa fa-trash"></i></button>
            </div>
        </div>
    </div>
</div>

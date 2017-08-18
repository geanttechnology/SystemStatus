<?php

/*Copyright © 2017 by SystemStatus.fr
All rights reserved. This file or any portion thereof MUST contain the following copyrights.*/

?>
<div class="col-sm-12 col-md-10 dzq-345 animated fadeIn">
  <div id="result"></div>
    <h4>Liste des plugins installés sur votre CMS</h4>

    <div class="table-responsive">
        <table class="table table-striped">
            <thead>
            <tr>
                <th>#</th>
                <th>Nom</th>
                <th>Autheur</th>
                <th>Version</th>
                <th>Compatible</th>
                <th>Statut</th>
                <th>Action</th>
            </tr>
            </thead>

            <tbody id="pluginTable">
              <?php $id = 0; foreach(Plugin::selectAll() as $themes => $value){ $id++; ?>
                <tr id="tr_<?=$value['name'];?>">
                  <th><?=$id?></th>
                  <th><?=$value['name']?></th>
                  <th><?=$value['author']?></th>
                  <th><?=$value['version']?></th>
                  <th><?php if($value['compatible']){ ?><span class="label label-success">Compatible</span><?php }else{ ?><span class="label label-danger">Non-compatible</span><?php }?></th>
                  <th><?php if($value['active']){ ?><span class="label label-success">Actif</span><?php }else{ ?><span class="label label-default">Non-actif</span><?php }?></th>
                  <th><?php if($value['active']){ ?>
                    <a class="btn btn-primary btn-xs disablePlugin" id="<?=$value['name'];?>">Désactiver</a>
                    <?php }else{ ?>
                      <?php if($value['compatible']){ ?>
                        <a class="btn btn-success btn-xs activePlugin" id="<?=$value['name'];?>">Activer</a>
                      <?php } ?>
                      <a class="btn btn-danger btn-xs deletePlugin" id="<?=$value['name'];?>">Supprimer</a>
                    <?php }?>
                    <button class="btn btn-info btn-xs" data-toggle="modal" data-target="#<?=$value['name']?>Modal">En savoir +</button>
                  </th>
                <tr/>

                <div id="<?=$value['name']?>Modal" class="modal fade" role="dialog">
                  <div class="modal-dialog">
                    <div class="modal-content">
                      <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title">"<?=$value['name']?>" Plugin <small>par <?=$value['author']?></small></h4>
                      </div>
                      <div class="modal-body">
                        <p>
                          Nom : <?=$value['name']?><br/>
                          Auteur : <?=$value['author']?><br/>
                          Version : <code><?=$value['version']?></code><br/>
                          Description : <?=$value['description']?><br/>
                        </p>
                      </div>
                      <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                      </div>
                    </div>
                  </div>
                </div>

              <?php } ?>
            </tbody>
        </table>
    </div>
</div>

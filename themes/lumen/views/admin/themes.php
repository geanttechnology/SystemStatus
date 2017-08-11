<div class="col-sm-12 col-md-10 dzq-345 animated fadeIn">
  <div id="result"></div>

    <div class="row">
        <h3 class="text-center text-uppercase">Liste des themes installés</h3>
        <hr class="col-md-6 col-md-offset-3">
    </div>

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

            <tbody id="themesTable">
              <?php $id = 0; foreach(Theme::selectAll() as $themes => $value){ $id++; ?>
                <tr id="tr_<?=$value['name'];?>">
                  <th><?=$id?></th>
                  <th><?=$value['name']?></th>
                  <th><?=$value['author']?></th>
                  <th><?=$value['version']?></th>
                  <th><?php if($value['compatible']){ ?><span class="label label-success">Compatible</span><?php }else{ ?><span class="label label-danger">Non-compatible</span><?php }?></th>
                  <th><?php if($value['active']){ ?><span class="label label-success">Actif</span><?php }else{ ?><span class="label label-default">Non-actif</span><?php }?></th>
                  <th>
                    <a class="btn btn-info btn-xs" href="<?=APP_URL?>/admin/themes/edit/<?=$value['name']?>"><i class="fa fa-edit"></i> Editer</a>
                    <?php if($value['active']){ ?>
                    <a class="btn btn-primary btn-xs disableTheme" <?php if($value['name'] == 'deafult'){ ?> disabled data-toggle="tooltip" data-placement="top" title="Le theme par défaut ne peut être désactivé" <?php }else{ ?> id="<?=$value['name'];?>" <?php } ?>>Désactiver</a>
                    <?php }else{ ?>
                      <?php if($value['compatible']){ ?>
                        <a class="btn btn-success btn-xs activeTheme" id="<?=$value['name'];?>">Activer</a>
                      <?php } ?>
                      <a class="btn btn-danger btn-xs deleteTheme" <?php if($value['name'] == 'deafult'){ ?> disabled data-toggle="tooltip1" data-placement="top" title="Le theme par défaut ne peut être supprimé" <?php }else{ ?> id="<?=$value['name'];?>" <?php }?>>Supprimer</a>
                    <?php }?>
                  </th>
                <tr/>
              <?php } ?>
            </tbody>
        </table>
    </div>
</div>

<?php

/*Copyright © 2017 by SystemStatus.fr
All rights reserved. This file or any portion thereof MUST contain the following copyrights.*/

?>
<div class="col-sm-12 col-md-10 dzq-345 animated fadeIn">
  <div id="result"></div>

    <div class="row">
        <h3 class="text-center text-uppercase"><?=LANG["admin"]["themes"]["list-themes-installed"] ?></h3>
        <hr class="col-md-6 col-md-offset-3">
    </div>

    <div class="table-responsive">
        <table class="table table-striped">
            <thead>
            <tr>
                <th>#</th>
                <th><?=LANG["admin"]["themes"]["maj-name"] ?></th>
                <th><?=LANG["admin"]["themes"]["maj-author"] ?></th>
                <th><?=LANG["admin"]["themes"]["maj-version"] ?></th>
                <th><?=LANG["admin"]["themes"]["maj-compatible"] ?></th>
                <th><?=LANG["admin"]["themes"]["maj-status"] ?></th>
                <th><?=LANG["admin"]["themes"]["maj-action"] ?></th>
            </tr>
            </thead>

            <tbody id="themesTable">
              <?php $id = 0; foreach(Theme::selectAll() as $themes => $value){ $id++; ?>
                <tr id="tr_<?=$value['name'];?>">
                  <th><?=$id?></th>
                  <th><?=$value['name']?></th>
                  <th><?=$value['author']?></th>
                  <th><?=$value['version']?></th>
                  <th><?php if($value['compatible']){ ?><span class="label label-success"><?=LANG["admin"]["themes"]["maj-compatible"] ?></span><?php }else{ ?><span class="label label-danger"><?=LANG["admin"]["themes"]["not-compatible"] ?></span><?php }?></th>
                  <th><?php if($value['active']){ ?><span class="label label-success"><?=LANG["admin"]["themes"]["maj-active"] ?></span><?php }else{ ?><span class="label label-default"><?=LANG["admin"]["themes"]["not-active"] ?></span><?php }?></th>
                  <th>
                    <a class="btn btn-info btn-xs" href="<?=APP_URL?>/admin/themes/edit/<?=$value['name']?>"><i class="fa fa-edit"></i> <?=LANG["admin"]["themes"]["maj-edit"] ?></a>
                    <?php if($value['active']){ ?>
                    <a class="btn btn-primary btn-xs disableTheme" <?php if($value['name'] == 'deafult'){ ?> disabled data-toggle="tooltip" data-placement="top" title="<?=LANG["admin"]["themes"]["theme-default-dont-deactivate"] ?>" <?php }else{ ?> id="<?=$value['name'];?>" <?php } ?>><?=LANG["admin"]["themes"]["maj-deactivate"] ?></a>
                    <?php }else{ ?>
                      <?php if($value['compatible']){ ?>
                        <a class="btn btn-success btn-xs activeTheme" id="<?=$value['name'];?>"><?=LANG["admin"]["themes"]["maj-activate"] ?></a>
                      <?php } ?>
                      <a class="btn btn-danger btn-xs deleteTheme" <?php if($value['name'] == 'deafult'){ ?> disabled data-toggle="tooltip1" data-placement="top" title="<?=LANG["admin"]["themes"]["theme-default-dont-delete"] ?>" <?php }else{ ?> id="<?=$value['name'];?>" <?php }?>><?=LANG["admin"]["themes"]["maj-delete"] ?></a>
                    <?php }?>
                  </th>
                <tr/>
              <?php } ?>
            </tbody>
        </table>
    </div>
</div>

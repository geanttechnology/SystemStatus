<?php

/*Copyright © 2017 by SystemStatus.fr
All rights reserved. This file or any portion thereof MUST contain the following copyrights.*/

?>
<div class="col-md-10 dzq-345 animated fadeIn">

    <div id="result"></div>

    <div class="row">
        <h3 class="text-center text-uppercase"><?=LANG["admin"]["users"]["list-users"] ?></h3>
        <hr class="col-md-6 col-md-offset-3">
    </div>

    <div class="table-responsive">
        <table class="table table-striped">
            <thead>
            <tr>
                <th>#</th>
                <th><?=LANG["admin"]["users"]["maj-user"] ?></th>
                <th><?=LANG["admin"]["users"]["kind-account"] ?></th>
                <th><?=LANG["admin"]["themes"]["maj-action"] ?></th>
            </tr>
            </thead>

            <tbody id="usersTable">

            <?php
            $api = new API();
            $users = json_decode($api->getUsers());
            $users = json_decode(json_encode($users->data), True);

            //Initialize values
            $n_editModal = 1;
            $n_deleteModal = 1;
            $tmp = 0;


            foreach ($users as $key => $value):

              $tmp++

              ?>

                <tr id="users_<?=$users[$key]['id']?>">
                    <th scope="row"><?=$users[$key]['id']?></th>
                    <td><?=$users[$key]['username']?></td>
                    <td><?=Auth::getTypeAccount($users[$key]['rank'])?>
                    </td>
                    <td>
                        <button type="button" <?php if($tmp != 1 ): ?>data-toggle="modal" data-target="#editModal_<?= $n_editModal ?>"<?php endif; ?> class="btn btn-warning btn-xs <?php if($tmp == 1 ):?>disabled<?php endif; ?>" <?php if($tmp == 1 ):?>data-toggle="tooltip" data-placement="top" title="L'utilisateur par défaut ne peut être modifié"<?php endif; ?>>Modifier</button>
                        <button type="button" class="btn btn-danger btn-xs <?php if($tmp == 1 ):?>disabled<?php endif; ?>" style="margin-left: 3px;" <?php if($tmp != 1 ):?>data-toggle="modal" data-target="#deleteModal_<?=$n_deleteModal?>"<?php endif; ?> <?php if($tmp == 1 ):?>data-toggle="tooltip" data-placement="top" title="L'utilisateur par défaut ne peut être supprimé"<?php endif; ?>>Supprimer</button>
                    </td>
                </tr>

            <?php endforeach; ?>




            </tbody>
        </table>
    </div>

    <h4><?=LANG["admin"]["users"]["add-user"] ?></h4>
    <form id="addUserForm" class="col-md-4 col-sm-12">
        <div class="form-group" id="helpAddUser">
            <label for=""><?=LANG["admin"]["users"]["maj-user"] ?></label>
            <input id="username" type="text" class="form-control" placeholder="<?=LANG["admin"]["users"]["maj-user"] ?>" name="username" autocomplete="off" required>
            <span class="help-block" id="helpUsernameValue"></span>
        </div>
        <div class="form-group">
            <label for=""><?=LANG["global"]["maj-password"] ?></label>
            <input id="password" type="password" class="form-control" id="" placeholder="****************" name="password" autocomplete="off" required>
        </div>
        <div class="form-group">
            <label for=""><?=LANG["admin"]["users"]["kind-account"] ?></label>
            <select id="rank" class="form-control" name="rank" required>
                <!-- <option>1</option> -->
                <option value="2"><?=LANG["admin"]["users"]["maj-normal"] ?></option>
                <option value="3"><?=LANG["admin"]["users"]["maj-admin"] ?></option>
            </select>
        </div>
        <button id="addUserSubmit" type="submit" class="btn btn-primary col-md-12 full-width-mobile" name="submitAddUser" value=""><?=LANG["admin"]["users"]["maj-validate"] ?></button>
    </form>

    <div class="col-md-8 col-md-ofset-2">
        <h4 class="text-info"><i class="fa fa-info"></i> Comment ça marche ?</h4>
        <p>
            Il existe 2 types de comptes:<br>
        <ul>
            <li>
                Le compte <strong>normal</strong>:<br>
                Il est autorisé à toute modification de statut y compris la création d'incident mais <strong>ne permet pas</strong> la configuration du système telle que la gestion des catégories/services ou des utilisateurs.
            </li>
            <br>
            <li>
                Le compte <strong>administrateur</strong>:<br>
                Celui-ci dispose de tout les droits de configuration du système et des utilisateurs (ajout, modification et suppression). En raison de cela, <strong>il convient d'en limiter le nombre d'utilisateur</strong> afin d'éviter toutes failles de sécurité.
            </li>
        </ul>
        </p>
    </div>

</div>


<?php
/*
 * IMPORTANT :
 * The content above is written because of a bug between the fadeIn class and bootstrap modals
 *
 */
$tmp = 0;
$n_editModal = 0;
$n_deleteModal = 0;
?>
<?php foreach ($users as $key => $value): $tmp++

  ?>

    <!-- editModal -->
    <div class="modal fade editModal" id="editModal_<?=$n_editModal?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="myModalLabel">Edition de <?=$users[$key]['username']?></h4>
                </div>
                <form class="updateForm">
                    <input hidden name="ID" value="<?=$users[$key]['id']?>" required readonly/>
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="">Nom d'utilisateur</label>
                            <input type="text" class="form-control" name="username" value="<?=$users[$key]['username']?>" required>
                        </div>
                        <div class="form-group">
                            <label for="">Type de compte</label>
                            <select name="rank" class="form-control" required>
                                <option value="3" <?php if(intval($users[$key]['rank']) == 3){ echo "selected"; } ?>>Administrateur</option>
                                <option value="2" <?php if(intval($users[$key]['rank']) == 2){ echo "selected"; } ?>>Normal</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="">Mot de passe</label>
                            <input type="password" class="form-control" id="" placeholder="Password" name="password">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <span class="text-muted" style="float: left;">* au moins 1 champ doit être complété</span>
                        <button type="button" class="btn btn-default" data-dismiss="modal">Fermer</button>
                        <button type="submit" class="btn btn-primary" name="submitEditModal" value="<?=$users[$key]['id']?>">Valider</button>
                    </div>
                </form>

            </div>
        </div>
    </div>
    <!-- [END] editModal -->

  <?php if($users[$key]['id'] != 1): ?>
        <!-- deleteModal -->
        <div class="modal fade deleteModal" id="deleteModal_<?=$n_deleteModal?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title" id="myModalLabel">Suppression de <?=$users[$key]['username']?></h4>
                    </div>
                    <form class="deleteForm">
                        <input hidden readonly id="IDUSERS" name="ID" value="<?=$users[$key]['id']?>"/>
                        <div class="modal-body">
                            Etes-vous sur de vouloir supprimer le compte <strong><?=$users[$key]['username']?></strong> ?
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Fermer</button>
                            <button type="submit" class="btn btn-primary" name="submitDeleteModal">Valider</button>
                        </div>
                    </form>

                </div>
            </div>
        </div>
        <!-- [END] deleteModal -->
  <?php endif; ?>

  <?php
  $n_editModal += 1;
  $n_deleteModal += 1;
  ?>

<?php endforeach; ?>



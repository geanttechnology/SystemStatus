<?php SecurityController::checkAccess(3, 2); ?>
<?php $this->layout('layouts::admin'); ?>

<div class="col-md-10 col-sm-12">
    <ol class="breadcrumb">
        <li><a href="<?=APP_URL?>/admin">Accueil</a></li>
        <li><a  class="active" href="<?=APP_URL?>/admin/users">Utilisateurs</a></li>
    </ol>
</div>

<?php

echo Theme::loadView('admin/users');
?>

<script>
    $(function () {
        $('[data-toggle="tooltip"]').tooltip()
    })


    $(".updateForm").on("submit", function(e){
        e.preventDefault();
        $.ajax({
            url: "<?=APP_URL?>/admin/users/update",
            type: "POST",
            data: $(this).serialize(),
            success: function(data)
            {
                $('.editModal').modal('hide');
                $("#notification").html(data);
            }
        });
    });

    $(".deleteForm").on("submit", function(e){
        e.preventDefault();
        $.ajax({
            url: "<?=APP_URL?>/admin/users/delete",
            type: "POST",
            data: $(this).serialize(),
            success: function(data)
            {
                $('.deleteModal').modal('hide');
                $("#notification").html(data);
                $("#users_"+$("#IDUSERS").val()).hide();
            }
        });
    });


    $("#addUserForm").on("submit", function(e){
        e.preventDefault();
        $.ajax({
            url: "<?=APP_URL?>/admin/users/add",
            type: "POST",
            data: $(this).serialize(),
            success: function(data)
            {
                $("#notification").html(data);
            }
        });
    });
</script>
<?php
$api = new API();
$resultGetUsers = json_decode($api->getUsers());
$resultGetUsers = json_decode(json_encode($resultGetUsers->data), True);
?>
<script>
    var usernameList = [
      <?php
        foreach ($resultGetUsers as $key => $value):?> '<?=strtolower($resultGetUsers[$key]['username'])?>', <?php endforeach;
      ?>
    ];

    var value = $('#username').val().toLowerCase();

    function controllUsername(){
        setTimeout(function(){
            value = $('#username').val().toLowerCase();
            if(jQuery.inArray( value, usernameList ) !== -1){
                $("#helpAddUser").addClass("has-error");
                $("#addUserSubmit").prop('disabled', true);
                $("#helpUsernameValue").html("Ce nom est déjà utilisé !");
            }else{
                $("#helpAddUser").removeClass("has-error");
                $("#addUserSubmit").prop('disabled', false);
                $("#helpUsernameValue").html("");
            }

            controllUsername();
        }, 0);
    }
    controllUsername();
</script>
<!-- Username controll //////////////////////////////////////////////////////////////////////////////////////////////// -->

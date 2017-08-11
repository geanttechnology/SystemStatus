<?php
SecurityController::checkAccess(3, 2);
$this->layout('layouts::admin');
?>

<div class="col-md-10 col-sm-12">
    <ol class="breadcrumb">
        <li><a href="<?=APP_URL?>/admin">Accueil</a></li>
        <li><a  class="active" href="<?=APP_URL?>/admin/settings">Paramètres</a></li>
    </ol>
</div>

<?php Theme::loadView('admin/settings'); ?>

<script type="text/javascript">

    //Custom product name
    $("#updateProductNameForm").on("submit", function(e){
        e.preventDefault();
        $.ajax({
            url: "<?=APP_URL?>/admin/settings/update",
            type: "POST",
            data: $(this).serialize(),
            success: function(data)
            {
                $("#notification").append(data);
            }
        });
    });

    $("#reset").on("click", function(){
        $("#name").val("");
    });

    //Maintenance feature
    $('#toggleUpdateProductMaintenanceForm').change(function(e) {

        if($("#notif-panel-maintenance").attr("maintenance") === "true"){

            $(this)
                .hide()
                .attr("maintenance", "false");

        }else{

            $(this)
                .show()
                .addClass("animated fadeIn").attr("maintenance", "true");
        }

        e.preventDefault();

        $.ajax({
            url: "<?=APP_URL?>/admin/settings/maintenance",
            type: "POST",
            data: $(this).serialize(),
            success: function(data)
            {
                $("#notification").append(data);
            }
        });
    });

    //Reset feature
    $('#confirmResetCMS').click(function(e) {

        var username = $("#resetCMS-username").val();
        var password = $("#resetCMS-password").val();

        e.preventDefault();

        $.ajax({
            url: "<?=APP_URL?>/admin/settings/reset/"+username+"/"+password,
            type: "POST",
            data: $(this).serialize(),
            success: function(data)
            {
                $("#notification").append(data);
            }
        });
    });
</script>
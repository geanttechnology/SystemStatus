<?php $this->layout('layouts::admin'); ?>

<div class="col-md-10 col-sm-12">
    <ol class="breadcrumb">
        <li><a href="<?=APP_URL?>/admin">Accueil</a></li>
    </ol>
</div>

<?php Theme::loadView('admin/home'); ?>

<!-- create accident -->
<div class="modal fade" id="modalCreateAccident" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span>&times;</span></button>
                <h4 class="modal-title" id="myModalLabel"></h4>
            </div>

            <form id="accidentForm">
                <div class="modal-body">
                    <div class="form-group">
                        <input name="title" placeholder="Titre de l'incident" required class="form-control">
                        <input type="hidden" id="createAccidentStatus" name="serviceStatus" required>
                        <input type="hidden" id="createAccidentID" name="serviceID" required>
                    </div>
                    <div class="form-group">
                        <textarea id="createAccidentContent" name="content" rows="8" cols="80" class="form-control" placeholder="Rapport de l'incident" required></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Annuler</button>
                    <button id="createAccidentSubmit" class="btn btn-primary">Créer le rapport d'incident</button>
                </div>
            </form>

        </div>
    </div>
</div>

<script>
    $('#modalCreateAccident').on('show.bs.modal', function (event) {
        var button = $(event.relatedTarget);
        var serviceName = button.data('servicename');
        var serviceId = button.data('serviceid');
        var serviceStatus = button.data('servicestatus');
        var modal = $(this);
        modal.find('.modal-title').text("Rapport d'incident sur le service " + serviceName);
        modal.find("#createAccidentStatus").val(serviceStatus);
        modal.find("#createAccidentID").val(serviceId)
    })
</script>

<script>
    $("#accidentForm").on("submit", function(e){
        e.preventDefault();
        $.ajax({
            url: "<?=APP_URL?>/admin/accident/add",
            type: "POST",
            data: $(this).serialize(),
            success: function(data)
            {
                $('#modalCreateAccident').modal('hide');
                $("#notification").html(data);
            }
        });
    });

    $(".ope").on("click", function(){
        var id = $(this).attr("service");
        $(".status-update-loader-"+id).css("display", "inline");
        $.ajax({
            url: "<?=APP_URL?>/admin/update/services/1/"+$(this).attr("service"),
            type: "POST",
            data: "",
            success: function(data)
            {
                $("#notification").append(data);
                $("#statut_"+id).html('<span class="label label-success">Opérationnel</span>');
                $(".status-update-loader-"+id).css("display", "none");
            }
        });
    });

    $(".partielle").on("click", function(){
        var id = $(this).attr("service");
        $(".status-update-loader-"+id).css("display", "inline");
        $.ajax({
            url: "<?=APP_URL?>/admin/update/services/2/"+$(this).attr("service"),
            type: "POST",
            data: "",
            success: function(data)
            {
                $("#notification").append(data);
                $("#statut_"+id).html('<span class="label label-warning">Panne partielle</span>');
                $(".status-update-loader-"+id).css("display", "none");
            }
        });
    });

    $(".defaillant").on("click", function(){
        var id = $(this).attr("service");
        $(".status-update-loader-"+id).css("display", "inline");
        $.ajax({
            url: "<?=APP_URL?>/admin/update/services/3/"+$(this).attr("service"),
            type: "POST",
            data: "",
            success: function(data)
            {
                $("#notification").append(data);
                $("#statut_"+id).html('<span class="label label-danger">Défaillant</span>');
                $(".status-update-loader-"+id).css("display", "none");
            }
        });
    });

    $(".maintenance").on("click", function(){
        var id = $(this).attr("service");
        $(".status-update-loader-"+id).css("display", "inline");
        $.ajax({
            url: "<?=APP_URL?>/admin/update/services/4/"+$(this).attr("service"),
            type: "POST",
            data: "",
            success: function(data)
            {
                $("#notification").append(data);
                $("#statut_"+id).html('<span class="label label-info">Maintenance</span>');
                $(".status-update-loader-"+id).css("display", "none");
            }
        });
    });
</script>

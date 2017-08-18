<?php

/*Copyright © 2017 by SystemStatus.fr
All rights reserved. This file or any portion thereof MUST contain the following copyrights.*/

?>
<div class="row">


    <div id="loginbox" class="mainbox col-md-6 col-md-offset-3 col-sm-12">

        <div class="panel panel-default" style="margin-top: 40%;" >
            <div class="panel-heading">
                <div class="panel-title text-center">SystemStatus - Monitoring</div>
            </div>

            <div class="panel-body">
                <div id="result"></div>
                <form id="loginForm" class="form-horizontal" enctype="multipart/form-data">

                    <div class="input-group" style="margin-bottom:10px;">
                        <span class="input-group-addon"><i class="fa fa-user"></i></span>
                        <input id="user" type="text" class="form-control" name="username" placeholder="Utilisateur" required="">
                    </div>
                    <div class="input-group">
                        <span class="input-group-addon"><i class="fa fa-lock"></i></span>
                        <input id="password" type="password" class="form-control" name="password" placeholder="Mot de passe" required="">
                    </div>

                    <div class="form-group" style="margin-top:10px;">
                        <!-- Button -->
                        <div class="col-sm-12 controls">
                            <a href="<?=APP_URL?>/" class="pull-left fam-501" >Retourner au site</a>
                            <button type="submit" class="btn btn-primary btn-sm pull-right" id="loginBtn" data-loading-text="Connexion en cours..."><i class="fa fa-sign-in"></i> Se connecter</button>
                        </div>
                    </div>

                    <br>

                    <div class="text-center -align-center">
                        <a href="https://www.systemstatus.fr" target="_blank">
                      <span>
                        Powered by SystemStyatus
                      </span>
                        </a>
                    </div>

                </form>
            </div>
        </div>
    </div>

    <script>
        $("#loginForm").on("submit", function(e){
            e.preventDefault();

            var $btn = $("#loginBtn").button('loading');

            $.ajax({
                url: "<?=APP_URL?>/login",
                type: "POST",
                data: $(this).serialize(),
                success: function(data){
                    $("#notification").html(data);
                }
            });

            setTimeout(function(){
                $btn.button('reset')
            }, 1000);
        });
    </script>

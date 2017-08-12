<?php $this->layout('layouts::install'); ?>
<?php
$webProtocol = (isset($_SERVER['HTTPS']) ? "https://" : "http://");
$root = explode("/install", $_SERVER["REQUEST_URI"]);
$root = $webProtocol . $_SERVER["HTTP_HOST"] . $root[0];
?>
<style media="screen">
    #home {
        margin-top: 10%;
    }

    @media only screen and (max-width: 599px){
        #home {
            margin-top: 20%;
        }
    }
</style>

<div id="result"></div>
<br/>
<h4><?=LANG['install']['user-making']?></h4>
<p>
<form id="registerForm" class="col-sm-12">
    <div class="form-group col-sm-12 col-md-12">
        <h4 class="text-muted"><?=LANG['install']['credentials']?></h4>
        <label for="exampleInputEmail1"><?=LANG['install']['username-chat-limit']?></label>
        <input class="form-control" type="text" name="username" placeholder="<?=LANG['install']['username-placeholder']?>" required>
        <br>
        <label for="exampleInputEmail1"><?=LANG['global']['maj-password']?></label>
        <div class="input-group">
            <input id="Passcode" type="password" class="form-control" name="password" placeholder="<?=LANG['install']['password-placeholder']?>" required>
            <div id="PasscodeBtn" class="input-group-addon link"><i id="PasscodeIcon" class="fa fa-eye"></i></div>
        </div>
    </div>
    <div class="col-sm-12">
        <hr>
        <button type="submit" class="btn btn-primary pull-right" name="submit_userConfig"><?=LANG['global']['maj-next']?></button>
    </div>
</form>
</p>

<script type="text/javascript">
    $("#PasscodeBtn").click(function() {

        if($("#PasscodeIcon").hasClass("fa-eye")){ //showed

            $("#PasscodeIcon").removeClass("fa-eye");
            $("#PasscodeIcon").addClass("fa-eye-slash");
            $("#Passcode").attr("type", "text");
        }else{

            $("#PasscodeIcon").removeClass("fa-eye-slash"); //hidden
            $("#PasscodeIcon").addClass("fa-eye");
            $("#Passcode").attr("type", "password");
        }

    });

    $("#registerForm").on("submit", function(e){
        e.preventDefault();
        $.ajax({
            url: "<?=$root?>/install/user",
            type: "POST",
            data: $(this).serialize(),
            success: function(data)
            {
                $("#notification").html(data);
            }
        });
    });

    $(function () {
        $('[data-toggle="popover"]').popover()
    })
</script>

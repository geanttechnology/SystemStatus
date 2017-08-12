<?php $this->layout('layouts::install');?>
<?php
$webProtocol = (isset($_SERVER['HTTPS']) ? "https://" : "http://");
$root = explode("/install", $_SERVER["REQUEST_URI"]);
$root = $webProtocol . $_SERVER["HTTP_HOST"] . $root[0];
?><style media="screen">
    #home {
        margin-top: 5%;
    }

    @media only screen and (max-width: 599px){
        #home {
            margin-top: 0;
        }
        button {
            width: 100% !important;
        }
    }
</style>
<h4><?=LANG['global']['maj-tutorial']?></h4>

<h4><?=LANG['install']['finish-page-h4']?></h4>

<blockquote>
    <p>
      <?=LANG['install']['finish-page-blockquote']?>
    </p>
</blockquote>

<br>

<p class="text-center text-muted">
    <?=LANG['install']['finish-page-panel']?>
</p>

<div class="panel panel-default" id="amx-328">
    <?=LANG['install']['finish-page-div1']?>
</div>

<a href="../"><button type="button" class="btn btn-success center-block"><?=LANG['install']['understand']?> <i class="fa fa-check-circle"></i></button></a>

<script type="text/javascript">
    $("#amx-328")
        .hover(function (){
            $(".tutorial").fadeOut();
        })
        .mouseleave(function (){
            $(".tutorial").fadeIn();
        })
</script>

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
            margin-top: 30%;
        }
    }
</style>
<p>
    Bonjour, bienvenue dans l'assistant d'installation de SystemStatus.<br>
    Veuillez suivre les étapes décrites dans ce script d'installation afin de pouvoir utiliser votre système.
    <hr>

  <a href="<?=$root?>/install/cms"><button type="button" class="btn btn-primary pull-right">Suivant</button></a>
</p>

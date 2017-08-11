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
            margin-top: 0%;
        }
        button {
            width: 100% !important;
        }
    }
</style>
<h4>Tutoriel</h4>

<h4>Avant de vous lancer dans la configuration de vos services via votre <strong>panel d'administration</strong>, prenez le temps de bien comprendre comment fonctionne SystemStatus.</h4>

<blockquote>
    <p>
        Chaque infrastructure que vous controlez doit être identifiée comme un <i>groupe</i> (également appelé <i>catégorie</i>). Dans ce <i>groupe</i> seront listés tout les
        <i>services</i>, comme nous les appelons, pour chacun desquels un <i>statut</i> tel que <span class="text-success status_dot">Opérationnel</span>,
        <span class="text-warning status_dot">Panne partielle</span>, <span class="text-danger status_dot">Défaillant</span> ou encore <span class="text-info status_dot">Maintenance</span>
        sera mentionné afin de renseigner vos clients sur la disponibilité de ces-dits <i>services</i>.<br>
        Il vous est également possible de créer des <strong>rapports d'incident</strong> afin d'apporter une touche d'information supplémentaire à vos clients/visiteurs concernant le dysfonctionement de vos services.
    </p>
</blockquote>

<br>

<p class="text-center text-muted">
    Voici comment vos visiteurs visualiseront le statut de vos services<br>
    <i class="hidden-xs">Survolez la zone afin de cacher les indications</i>
</p>

<div class="panel panel-default" id="amx-328">

    <div class="panel-heading">
        Ma catégorie 1&nbsp;&nbsp;&nbsp;
        <span class="text-info tutorial hidden-xs">
            <i class="fa fa-question-circle"></i>&nbsp;Groupe de services. Permet de rassembler vos différentes infrastructures.
        </span>
        <span class="pull-right text-danger status_dot">
            <span class="text-info tutorial hidden-xs">Statut global du groupe de services&nbsp;
            <i class="fa fa-question-circle"></i>
            </span>
            &nbsp;&nbsp;&nbsp;<i class="fa fa-circle text-warning pull-right" style="margin-top: 5px;"></i>
        </span>
    </div>

    <div class="panel-body">
        Serveur Mail&nbsp;&nbsp;&nbsp;
        <span class="text-info tutorial hidden-xs">
            <i class="fa fa-question-circle"></i>&nbsp;Nom du service. Les services sont définis via votre panel d'administration.
        </span>
        <small class="pull-right text-success status_dot">Opérationnel</small>
    </div>

    <div class="panel-body">
        Infrastructure
        <span class="pull-right text-danger status_dot">
            <span class="text-info tutorial hidden-xs">Statut du service. Définit via le panel ou automatiquement grâce à des plugins&nbsp;
            <i class="fa fa-question-circle"></i></span><small>&nbsp;&nbsp;&nbsp;Défaillant</small>
        </span>
    </div>
</div>

<a href="../"><button type="button" class="btn btn-success center-block">J'ai compris <i class="fa fa-check-circle"></i></button></a>

<script type="text/javascript">
    $("#amx-328")
        .hover(function (){
            $(".tutorial").fadeOut();
        })
        .mouseleave(function (){
            $(".tutorial").fadeIn();
        })
</script>

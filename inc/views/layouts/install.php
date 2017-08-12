<?php
$webProtocol = (isset($_SERVER['HTTPS']) ? "https://" : "http://");
$root = explode("/install", $_SERVER["REQUEST_URI"]);
$root = $webProtocol . $_SERVER["HTTP_HOST"] . $root[0];

if(!file_exists(__DIR__ . "/../../../config/rootWebUrl")){
  file_put_contents(__DIR__ . "/../../../config/rootWebUrl", $root);
}
?>
<!-- Copyright © 2017 by SystemStatus.fr
All rights reserved. This file or any portion thereof MUST contain the following copyrights. -->

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">

    <title><?=LANG['install']['head-html']['title']?></title>
    <meta name="author" content="SystemStatus.fr">
    <meta name="description" content="<?=LANG['install']['head-html']['description']?>">

    <!-- Bootstrap -->
    <link href="<?=$root?>/inc/assets/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap theme -->
    <link href="<?=$root?>/inc/assets/css/bootstrap.theme.min.css" rel="stylesheet">
    <!-- Master CSS -->
    <link rel="stylesheet" href="<?=$root?>/inc/assets/css/master-install.css">
    <!-- Font Awesome -->
    <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet" integrity="sha384-wvfXpqpZZVQGK6TAh5PVlGOfQNHSoD2xbE+QkPxCAFlNEevoEH3Sl0sibVcOQVnN" crossorigin="anonymous">
    <!-- Animate CSS -->
    <link rel="stylesheet" href="<?=$root?>/inc/assets/css/animate.css">
    <!-- Notifications (https://github.com/CodeSeven/toastr) -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">

    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js" integrity="sha256-hwg4gsxgFZhOsEEamdOYGBf13FyQuiTwlAQgxVSNgt4=" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>

</head>

<body class="container" id="home">

<div id="notification"></div>

<div class="panel panel-primary">

    <div class="panel-heading">
        <?=LANG['install']['install_assistant']?>
        <span class="pull-right link hidden-xs hidden-sm" onclick="window.open('https://www.systemstatus.fr', '_blank')">
            <img src="<?=$root?>/inc/assets/img/logo.png" alt="" style="height: 25px;">
            <small><?=LANG['global']['copyrights-nolink']?></small>
        </span>
        <span class="link hidden-md hidden-lg text-right" style="display: block;" onclick="window.open('https://www.systemstatus.fr', '_blank')">
            <img src="<?=$root?>/inc/assets/img/logo.png" alt="" style="height: 25px;">
            <small><?=LANG['global']['copyrights-nolink']?></small>
        </span>
    </div>

    <div class="panel-body">
      <?=$this->section('content')?>
    </div>

</div>

<!-- Include all compiled plugins (below), or include individual files as needed -->
<script src="../inc/assets/js/bootstrap.min.js"></script>
</body>

</html>

<!-- Copyright © 2017 by AddictProject.fr
All rights reserved. This file or any portion thereof
may not be reproduced or used in any manner whatsoever
without the express written permission of the publisher. -->

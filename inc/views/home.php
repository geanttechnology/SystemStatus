<!--------------------------------------------------------------
  This website has been made using SystemStatus CMS.
  Creators website : www.systemstatus.fr (french dev. team)

  SystemStatus 2017. all rights reserved.

  [][][][][][][][][][][][][][][][][][][][][][][][]
  Registration Number: #<?=CMS_LICENCE?>

  [][][][][][][][][][][][][][][][][][][][][][][][]
  -------------------------------------------------------------->

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">

    <title><?=APP_NAME?></title>

    <!-- Custom Font -->
    <link href="https://fonts.googleapis.com/css?family=Raleway" rel="stylesheet">

    <!-- Bootstrap -->
    <link href="<?=APP_URL?>/inc/assets/css/bootstrap.min.css" rel="stylesheet">
    <link href="<?=APP_URL?>/inc/assets/css/bootstrap-theme.css" rel="stylesheet">

    <!-- Favicons -->
    <link rel="apple-touch-icon" sizes="57x57" href="<?=APP_URL?>/inc/assets/img/favicons/apple-icon-57x57.png">
    <link rel="apple-touch-icon" sizes="60x60" href="<?=APP_URL?>/inc/assets/img/favicons/apple-icon-60x60.png">
    <link rel="apple-touch-icon" sizes="72x72" href="<?=APP_URL?>/inc/assets/img/favicons/apple-icon-72x72.png">
    <link rel="apple-touch-icon" sizes="76x76" href="<?=APP_URL?>/inc/assets/img/favicons/apple-icon-76x76.png">
    <link rel="apple-touch-icon" sizes="114x114" href="<?=APP_URL?>/inc/assets/img/favicons/apple-icon-114x114.png">
    <link rel="apple-touch-icon" sizes="120x120" href="<?=APP_URL?>/inc/assets/img/favicons/apple-icon-120x120.png">
    <link rel="apple-touch-icon" sizes="144x144" href="<?=APP_URL?>/inc/assets/img/favicons/apple-icon-144x144.png">
    <link rel="apple-touch-icon" sizes="152x152" href="<?=APP_URL?>/inc/assets/img/favicons/apple-icon-152x152.png">
    <link rel="apple-touch-icon" sizes="180x180" href="<?=APP_URL?>/inc/assets/img/favicons/apple-icon-180x180.png">
    <link rel="icon" type="image/png" sizes="192x192"  href="<?=APP_URL?>/inc/assets/img/favicons/android-icon-192x192.png">
    <link rel="icon" type="image/png" sizes="32x32" href="<?=APP_URL?>/inc/assets/img/favicons/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="96x96" href="<?=APP_URL?>/inc/assets/img/favicons/favicon-96x96.png">
    <link rel="icon" type="image/png" sizes="16x16" href="<?=APP_URL?>/inc/assets/img/favicons/favicon-16x16.png">
    <link rel="manifest" href="<?=APP_URL?>/inc/assets/img/favicons/manifest.json">
    <meta name="msapplication-TileColor" content="#ffffff">
    <meta name="msapplication-TileImage" content="/ms-icon-144x144.png">
    <meta name="theme-color" content="#ffffff">

    <!-- FontAwesome -->
    <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet" integrity="sha384-wvfXpqpZZVQGK6TAh5PVlGOfQNHSoD2xbE+QkPxCAFlNEevoEH3Sl0sibVcOQVnN" crossorigin="anonymous">
    <!-- Theme css -->
  <?=Theme::loadCss('home');?>
    <!-- Additional theme -->
  <?=Theme::loadCss('custom');?>
    <!-- Timeline css -->
    <link rel="stylesheet" href="<?=APP_URL?>/inc/assets/css/timeline.css">
    <!-- Animated css -->
    <link rel="stylesheet" href="<?=APP_URL?>/inc/assets/css/animated.css">
    <!-- JQuery -->
    <script src="<?=APP_URL?>/inc/assets/js/jquery.min.js"></script>
    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
</head>
<body>

<!-- Header -->
<?php Theme::loadView('header'); ?>

<!-- Content -->
<?php
if(app::inMaintenance()){
  Theme::loadView('maintenance');
}else{
  Theme::loadView('home');
}
?>

<!-- Footer -->
<?php Theme::loadView('footer'); ?>

<!-- Scripts -->
<script src="<?=APP_URL?>/inc/assets/js/bootstrap.min.js"></script>

</body>
</html>

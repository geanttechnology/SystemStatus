<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title><?= APP_NAME ?> | <?= LANG["global"]["maj-admin"] ?></title>
    <meta name="author" content="AddictProject">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
    <!-- Custom Font -->
    <link href="https://fonts.googleapis.com/css?family=Raleway" rel="stylesheet">

    <!-- Bootstrap -->
    <link href="<?= APP_URL ?>/inc/assets/css/bootstrap.min.css" rel="stylesheet">
    <link href="<?= APP_URL ?>/inc/assets/css/bootstrap-theme.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.0.0-alpha.6/css/bootstrap.css.map">
    <link href="<?= APP_URL ?>/inc/assets/css/animated.css" rel="stylesheet">
    <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet"
          integrity="sha384-wvfXpqpZZVQGK6TAh5PVlGOfQNHSoD2xbE+QkPxCAFlNEevoEH3Sl0sibVcOQVnN" crossorigin="anonymous">

    <!-- Favicons -->
    <link rel="apple-touch-icon" sizes="57x57" href="<?= APP_URL ?>/inc/assets/img/favicons/apple-icon-57x57.png">
    <link rel="apple-touch-icon" sizes="60x60" href="<?= APP_URL ?>/inc/assets/img/favicons/apple-icon-60x60.png">
    <link rel="apple-touch-icon" sizes="72x72" href="<?= APP_URL ?>/inc/assets/img/favicons/apple-icon-72x72.png">
    <link rel="apple-touch-icon" sizes="76x76" href="<?= APP_URL ?>/inc/assets/img/favicons/apple-icon-76x76.png">
    <link rel="apple-touch-icon" sizes="114x114" href="<?= APP_URL ?>/inc/assets/img/favicons/apple-icon-114x114.png">
    <link rel="apple-touch-icon" sizes="120x120" href="<?= APP_URL ?>/inc/assets/img/favicons/apple-icon-120x120.png">
    <link rel="apple-touch-icon" sizes="144x144" href="<?= APP_URL ?>/inc/assets/img/favicons/apple-icon-144x144.png">
    <link rel="apple-touch-icon" sizes="152x152" href="<?= APP_URL ?>/inc/assets/img/favicons/apple-icon-152x152.png">
    <link rel="apple-touch-icon" sizes="180x180" href="<?= APP_URL ?>/inc/assets/img/favicons/apple-icon-180x180.png">
    <link rel="icon" type="image/png" sizes="192x192"
          href="<?= APP_URL ?>/inc/assets/img/favicons/android-icon-192x192.png">
    <link rel="icon" type="image/png" sizes="32x32" href="<?= APP_URL ?>/inc/assets/img/favicons/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="96x96" href="<?= APP_URL ?>/inc/assets/img/favicons/favicon-96x96.png">
    <link rel="icon" type="image/png" sizes="16x16" href="<?= APP_URL ?>/inc/assets/img/favicons/favicon-16x16.png">
    <link rel="manifest" href="<?= APP_URL ?>/inc/assets/img/favicons/manifest.json">
    <meta name="msapplication-TileColor" content="#ffffff">
    <meta name="msapplication-TileImage" content="/ms-icon-144x144.png">
    <meta name="theme-color" content="#ffffff">


    <!-- Custom CSS -->
    <link href="<?= APP_URL ?>/themes/<?= THEME_NAME ?>/css/admin.css" rel="stylesheet">

    <!-- Additional theme -->
    <link href="<?= APP_URL ?>/themes/<?= THEME_NAME ?>/css/custom.css" rel="stylesheet">

    <!-- Timeline css -->
    <link rel="stylesheet" href="<?= APP_URL ?>/inc/assets/css/timeline.css">

    <!-- Theme CSS -->
  <?= Theme::loadCss('admin') ?>

    <!-- Notifications (https://github.com/CodeSeven/toastr) -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">


    <!-- Loaded here beacause of scripts below -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>

    <!-- Autosizing script -->
    <script src="<?= APP_URL ?>/inc/assets/js/jquery.textarea_autosize.js"></script>

</head>

<body>

<div id="loader" style="position: fixed"></div>

<div id="notification"></div>

<!-- Header -->
<?php Theme::loadView('admin/header'); ?>

<div id="lom-452" class="">

    <!-- Sidebar -->
    <div class="col-md-2 col-sm-12" id="sidebar">

      <?php Theme::loadView('admin/layout'); ?>

        <div class="list-group">

            <button type="button" class="list-group-item"><?= LANG["admin"]["side-bar"]["info-license"] ?>.

              <?php
              $infoLicence = Api::getLicenceInfos();
              $type = $infoLicence->type;
              $ip = $infoLicence->ip_callback;
              $hostname = $infoLicence->host_callback;
              ?>

                <small class="pull-right"><?= LANG["admin"]["side-bar"]["maj-license"] ?>: <a
                            href="<?= CMS_LICENCE ?>"><?= CMS_LICENCE ?></a></small>

                <small class="pull-right"><?= LANG["admin"]["side-bar"]["kind-license"] ?>: <?= $type ?></small>

                <small class="pull-right"><?= LANG["admin"]["side-bar"]["assigned-ip"] ?>: <?= $ip ?></small>

                <small class="pull-right"><?= LANG["admin"]["side-bar"]["assigned-host"] ?>: <?= $hostname ?></small>
            </button>

            <button type="button" class="list-group-item"
                    onclick="window.open('https://account.systemstatus.fr', '_blank')"><?= LANG["admin"]["side-bar"]["account-manager"] ?>
                <i class="fa fa-cloud"></i>
            </button>

            <button type="button" class="list-group-item list-group-item-info"
                    onclick="document.location.href='<?= APP_URL ?>/'"><?= LANG["admin"]["side-bar"]["go-back-to-public-site"] ?>
                <i class="fa fa-home"></i>
            </button>

        </div>

        <div class="list-group hidden-sm hidden-xs">
            <button type="button" class="list-group-item"
                    onclick="document.location.href='<?= APP_URL ?>/admin'"><?= LANG["admin"]["side-bar"]["maj-home"] ?>
                <i class="fa fa-home pull-right nav-icon"></i>
            </button>
          <?php if (SecurityController::checkAccess(3)): ?>
              <button type="button" class="list-group-item"
                      onclick="document.location.href='<?= APP_URL ?>/admin/users'"><?= LANG["admin"]["side-bar"]["maj-users"] ?>
                  <i class="fa fa-user pull-right nav-icon"></i>
              </button>
              <button type="button" class="list-group-item"
                      onclick="document.location.href='<?= APP_URL ?>/admin/manageItems'"><?= LANG["admin"]["side-bar"]["maj-infra"] ?>
                  <i class="fa fa-align-justify pull-right nav-icon"></i>
              </button>
              <button type="button" class="list-group-item"
                      onclick="document.location.href='<?= APP_URL ?>/admin/monitoring'"><?= LANG["admin"]["side-bar"]["maj-monitoring"] ?>
                  <i class="fa fa-signal pull-right nav-icon"></i></button>
              <button type="button" class="list-group-item"
                      onclick="document.location.href='../../../themes'"><?= LANG["admin"]["side-bar"]["maj-themes"] ?>
                  <i class="fa fa-paint-brush pull-right nav-icon"></i>
              </button>
              <button type="button" class="list-group-item"
                      onclick="document.location.href='<?= APP_URL ?>/admin/settings'"><?= LANG["admin"]["side-bar"]["maj-config"] ?>
                  <i class="fa fa-cog pull-right nav-icon"></i>
              </button>
          <?php endif; ?>
        </div>

      <?php

      $globalNews = json_decode(json_encode(AdminController::getGlobalNews()), TRUE);

      if ($globalNews !== FALSE):?>

          <div class="panel panel-info">
              <div class="panel-heading"><i
                          class="fa fa-newspaper"></i>&nbsp;<?= LANG["admin"]["side-bar"]["maj-news"] ?></div>
              <div class="panel-body">

                  <div class="list-group">
                      <a class="list-group-item">
                          <h4 class="list-group-item-heading"><?= $globalNews['title'] ?></h4>
                          <p class="list-group-item-text"><?= $globalNews['content'] ?></p>
                      </a>
                  </div>

              </div>
          </div>

      <?php endif; ?>

      <?php if ($type == "Basic"): ?>
          <div class="panel panel-warning licence-panel-warning">
              <div class="panel-heading"><i class="fa fa-info"></i> <?= LANG["admin"]["side-bar"]["about-license"] ?>
              </div>
              <div class="panel-body">
                <?= LANG["admin"]["side-bar"]["info-license-basic"] ?>
                  <a href="https://www.systemstatus.fr" target="_blank"><?= LANG["admin"]["side-bar"]["website"] ?></a>.
                  <button type="button" class="list-group-item list-group-item-center"
                          onclick="window.open('https://account.systemstatus.fr', '_blank')"><?= LANG["admin"]["side-bar"]["account-manager"] ?>
                      <i class="fa fa-cloud"></i></button>
              </div>
          </div>
      <?php endif; ?>

    </div>
    <!-- END Sidebar -->

    <!-- Maintenance notification -->
  <?= AdminController::checkAvailableUpdate() ?>

  <?php if (App::inMaintenance()): ?>
      <!-- Maintenance notification -->
      <div class="col-md-10" id="notif-panel-maintenance" maintenance="true">
          <div class="panel panel-info">
              <div class="panel-heading"><i class="fa fa-wrench"></i> Mode maintenance activé</div>
              <div class="panel-body">
                  Le mode maintenance est activé. Pour le désactiver, cliquez sur le ien ci-dessous
                  <button type="button" class="list-group-item list-group-item-center"
                          onclick="document.location.href='<?= APP_URL ?>/admin/settings'">Page de configuration <i
                              class="fa fa-cogs"></i></button>
              </div>
          </div>
      </div>
  <?php endif; ?>

    <!-- Page content -->
  <?= $this->section('content') ?>


    <!-- Footer -->
  <?php Theme::loadView('admin/footer'); ?>

    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="<?= APP_URL ?>/inc/assets/js/bootstrap.min.js"></script>
    <script>
        // Add slideDown animation to Bootstrap dropdown when expanding.
        $('.dropdown').on('show.bs.dropdown', function () {
            $(this).find('.dropdown-menu').first().stop(true, true).slideDown();
        });

        // Add slideUp animation to Bootstrap dropdown when collapsing.
        $('.dropdown').on('hide.bs.dropdown', function () {
            $(this).find('.dropdown-menu').first().stop(true, true).hide();
        });
    </script>

</body>
</html>

<nav class="navbar navbar-default navbar-fixed-top">
    <div class="container-fluid">
        <div class="navbar-header">
            <a class="navbar-brand text-center" href="?refresh">
              <?php if(APP_NAME != "SystemStatus CMS"): ?>
                  <span class="header-logo custom-header-logo"><?=APP_NAME?></span>
              <?php else: ?>
                  <img src="<?=APP_URL?>/inc/assets/img/logo.png" alt="SystemStatus-logo" class="header-logo">&nbsp;SystemStatus
              <?php endif; ?>
            </a>
        </div>
    </div>
</nav>

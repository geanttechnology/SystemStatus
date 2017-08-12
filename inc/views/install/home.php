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

    @media only screen and (max-width: 599px) {
        #home {
            margin-top: 30%;
        }
    }
</style>
<p>
  <?=LANG['install']['home-page-welcome']?>

<hr>

<span class="text-left">
    <strong>Language: </strong>
          <?php

            $languages = InstallController::showLanguages();
            foreach ($languages as $languageKey => $languageValue):?>
                <a href="?lang=<?=$languages[$languageKey]?>"><img src="<?=$root?>/inc/assets/img/flags/<?=$languages[$languageKey]?>.png" alt="<?=$languages[$languageKey]?>"></a>
            <?php endforeach;

          ?>
</span>

<a href="<?= $root ?>/install/cms?lang=<?=$_COOKIE['lang']?>">
    <button type="button" class="btn btn-primary pull-right"><?=LANG['global']['maj-next']?></button>
</a>
</p>

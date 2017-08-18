<?php
/*Copyright © 2017 by SystemStatus.fr
All rights reserved. This file or any portion thereof MUST contain the following copyrights.*/
$theme = new Theme(THEME_NAME_);
if(!$theme->isTheme())
  Auth::alert("<strong>Erreur</strong>, ce thème n'existe pas !", "error");
?>

<div class="col-sm-12 col-md-10 dzq-345 animated fadeIn">

    <div class="row">
        <h3 class="text-center text-uppercase">Modification du thème <code><?=THEME_NAME_?></code></h3>
        <hr class="col-md-6 col-md-offset-3">
    </div>

  <form id="editForm">
    <div id="result"></div>

    <!-- VIEWS -->
    <h4 class="text-center"><strong>Vues</strong></h4>
    <?php foreach($theme->getFiles()['views'] as $key => $file){ ?>
      <div class="row">
        <div class="form-group col-sm-12 col-md-10">
            <label><?=$key?>.php</label>
            <textarea  style="resize:vertical;" class="js-auto-size form-control edit" id="<?=$file.$key?>.php" required><?php echo file_get_contents(__DIR__ . '/../../../'.THEME_NAME_.'/'.$file.$key.'.php');?></textarea>
        </div>
      </div>
    <?php } ?>

    <!-- CSS -->
      <h4 class="text-center"><strong>Css</strong></h4>
      <?php foreach($theme->getFiles()['style'] as $key1 => $file1){ ?>
        <div class="row">
          <div class="form-group col-sm-12 col-md-10 dzq-345 animated fadeIn">
              <label><?=$key1?>.css</label>
              <textarea  style="resize:vertical;" class="js-auto-size form-control edit" id="<?=$file1.$key1?>.css" required><?php echo file_get_contents(__DIR__ . '/../../../'.THEME_NAME_.'/'.$file1.$key1.'.css');?></textarea>
          </div>
        </div>
      <?php } ?>

      <!-- JS -->
      <h4 class="text-center"><strong>Javascript</strong></h4>
      <?php foreach($theme->getFiles()['javascript'] as $key2 => $file2){ ?>
        <div class="row">
          <div class="form-group col-sm-12 col-md-10 dzq-345 animated fadeIn">
              <label><?=$key2?>.js</label>
              <textarea  style="resize:vertical;" class="js-auto-size form-control edit" id="<?=$file2.$key2?>.js" required><?php echo file_get_contents(__DIR__ . '/../../../'.THEME_NAME_.'/'.$file2.$key2.'.js');?></textarea>
          </div>
        </div>
      <?php } ?>

  </form>

</div>

<!-- textarea auto sizing -->
<script>
  $('textarea.js-auto-size').textareaAutoSize();
</script>

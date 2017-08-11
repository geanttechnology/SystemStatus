<?php
// Copyright © 2017 by SystemStatus.fr
// All rights reserved. This file or any portion thereof MUST contain the following copyrights.

$status = 0;

if(!empty($_POST['action'])){
  switch($_POST['action'])
  {
    case 'checkDownload':
      if($status == 1){
        http_response_code(200);
        exit(0);
      }else{
        http_response_code(404);
        exit(0);
      }
    break;


    default:
      header('HTTP/1.0 404 Not Found');
      exit(0);
    break;
  }
}

function deleteDir($path)
{
    if (is_dir($path) === true)
    {
        $files = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($path), RecursiveIteratorIterator::CHILD_FIRST);

        foreach ($files as $file)
        {
            if (in_array($file->getBasename(), array('.', '..')) !== true)
            {
                if ($file->isDir() === true)
                {
                    rmdir($file->getPathName());
                }

                else if (($file->isFile() === true) || ($file->isLink() === true))
                {
                    unlink($file->getPathname());
                }
            }
        }

        return rmdir($path);
    }

    else if ((is_file($path) === true) || (is_link($path) === true))
    {
        return unlink($path);
    }

    return false;
}

$version = file_get_contents('https://api.systemstatus.fr/version.txt');
$config = require __DIR__ . '/config/app.php';

if(AdminController::checkAvailableUpdate(0) === FALSE){
    header("Location: ../");
    exit(0);
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">

    <title>SystemStatus | Mise à jour</title>
    <meta name="author" content="SystemStatus.fr">
    <meta name="description" content="This website has been made by the awesome SystemStatus CMS">

    <!-- Bootstrap -->
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
    <!-- Bootstrap theme -->
    <link href="https://dl.systemstatus.fr/storage/css/bootstrap-theme.css" rel="stylesheet">
    <!-- Master CSS -->
    <link rel="https://dl.systemstatus.fr/storage/css/master.css">
    <!-- Font Awesome -->
    <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet" integrity="sha384-wvfXpqpZZVQGK6TAh5PVlGOfQNHSoD2xbE+QkPxCAFlNEevoEH3Sl0sibVcOQVnN" crossorigin="anonymous">
    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js" integrity="sha256-hwg4gsxgFZhOsEEamdOYGBf13FyQuiTwlAQgxVSNgt4=" crossorigin="anonymous"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
</head>

<body class="container" id="home">

<div class="panel panel-primary">
    <div class="panel-heading">Assistant d'installation</div>

    <div class="panel-body">
      <style media="screen">
          #home {
            margin-top: 10%;
          }
      </style>

    <?php
    if(empty($_GET['step']))
      $_GET['step'] = '';

    switch($_GET['step'])
    {
      /** Step 1 **/
      case '1': ?>
        <p>
          Votre version : <a style="color:#e67e22"><?=$config['cms']['version']?></a><br/>
          Dernière version téléchargeable : <a style="color:#2ecc71"><?=file_get_contents('https://api.systemstatus.fr/version.txt')?></a>
          <hr>
          <a href="?step=2"><button type="button" id="nextBtn" class="btn btn-primary pull-right">Mettre à jour</button></a>
        </p>

        <!-- Modal -->
        <div id="loadingModal" class="modal fade" role="dialog">
          <div class="modal-dialog">
            <div class="modal-content">
              <div class="modal-header">
                <h4 class="modal-title"><i class="fa fa-download"></i> Mise à jour</h4>
              </div>
              <div class="modal-body">
                <p id="downloadText">La mise à jour peut prendre entre 1 et 5 min selon votre connexion.<br/>
                  Veuillez ne pas quitter cette page et ne pas cliquez sur le bouton ci-dessous.
                </p>
              </div>
              <div class="modal-footer">
                <a id="downloadLink"><button type="button" id="downloadBtn" class="btn btn-primary disabled">Suivant</button></a>
              </div>
            </div>
          </div>
        </div>

        <script>
          $("#nextBtn").on("click", function(){
            $('#loadingModal').modal({
              show: 'true',
              backdrop: 'static',
              keyboard: false
            });
          });
        </script>
      <?php break; ?>

      <!-- Step 2 -->
      <?php case '2': ?>
        <!-- Download -->
        <?php
          if(file_exists(__DIR__ . '/tmp')){
            deleteDir('tmp');
          }else{
            $file = file_get_contents('https://dl.systemstatus.fr/storage/SystemStatus-'.$version.'.zip');
            if(!file_exists(__DIR__.'/tmp'))
              mkdir(__DIR__.'/tmp');
            file_put_contents(__DIR__ . '/tmp/SystemStatus-'.$version.'.zip', $file);

            unlink(__DIR__ . '/.htaccess');
            unlink(__DIR__ . '/composer.json');
            unlink(__DIR__ . '/composer.lock');
            unlink(__DIR__ . '/index.php');
            unlink(__DIR__ . '/README.md');
            deleteDir(__DIR__ . '/inc');
            deleteDir(__DIR__ . '/plugins');
            deleteDir(__DIR__ . '/themes');
            deleteDir(__DIR__ . '/vendor');

            $zip = new ZipArchive;
            if ($zip->open(__DIR__ . '/tmp/SystemStatus-'.$version.'.zip') === TRUE) {
              $zip->extractTo(__DIR__);
              $zip->close();
              $status = 1;
              deleteDir(__DIR__ . '/tmp');
            }

            $search  = array($config['cms']['version']);
            $replace = array($version);

            $file = file_get_contents(__DIR__ . '/config/app.php');
            $file = str_replace($search, $replace, $file);
            file_put_contents(__DIR__ . '/config/app.php', $file);
          } ?>
          <p>
            <b>Bravo !</b><br/> SystemStatus version <?=file_get_contents('https://api.systemstatus.fr/version.txt')?> a été mise à jour avec succès ! <br/> Vous pouvez maintenant supprimer le fichier <code>update.php</code>.<br/>Cliquez <a href="<?=$config['url']?>/">ici</a> pour acceder à votre CMS. <br/><br/>Bonne utilisation !
          </p>

        <?php break; ?>

      <!-- Default -->
      <?php default : ?>
        <p>
          Bonjour, bienvenue dans l'assistant de mise à jour de SystemStatus.<br>
          Veuillez suivre les étapes décrites dans ce script de mise à jour afin mettre à jour le système.
          <hr>
          <a href="?step=1"><button type="button" class="btn btn-primary pull-right">Suivant</button></a>
        </p>
        <?php break; ?>
      <?php } ?>
    </div>

    <!-- Download script -->
    <script>
      $(document).ready(function(){
        $("#downloadBtn").html('<span id="downloadIcon"><i class="fa fa-refresh fa-spin fa-fw"></i> Mise à jour en cours ...</span>');
        checkDownload();
      });

      function checkDownload()
      {
        $.ajax({
          url: "",
          type: "POST",
          data: "action=checkDownload",
          success: function()
          {
            $("#downloadBtn").removeClass('disabled');
            $("#downloadLink").attr("href", "?step=3");
            $("#downloadText").html("La mise à jour a été effectué avec succès.<br/> Vous pouvez passer à l'étape suivant dés maintenant.");
            $("#downloadIcon").html("Suivant");
          },
          error: function()
          {
            $("#downloadLink").removeAttr("href");
            $("#downloadBtn").html('<span id="downloadIcon"><i class="fa fa-refresh fa-spin fa-fw"></i> Mise à jour en cours ...</span>').removeClass('disabled').addClass('disabled');
            $("#downloadText").html('La mise à jour peut prendre entre 1 et 5 min selon votre connexion.<br/>Veuillez ne pas quitter cette page et ne pas cliquez sur le bouton ci-dessous.');
          }
        });
        window.setTimeout(function() { checkDownload() }, 5000)
      }
    </script>


</div>

</body>

</html>

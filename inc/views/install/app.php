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
            margin-top: 25%;
        }
    }
</style>

<p>
<h4><?=LANG['install']['cms-config']?></h4>

<div id="result"></div>

<form id="appForm" class="col-sm-12">
    <div class="form-group col-sm-12 col-md-12">
        <label for="exampleInputEmail1"><?=LANG['install']['cms-url']?></label>
        <input class="form-control" type="text" name="url" value="<?=$root?>"  placeholder="<?=LANG['install']['cms-url-placeholder']?>" required>
        <br>
        <label for="exampleInputEmail1"><?=LANG['global']['maj-name']?></label>
        <input class="form-control" type="text" name="name" placeholder="<?=LANG['install']['cms-name-placeholder']?>" required>
    </div>
    <div class="col-sm-12">
        <hr>
        <button type="submit" class="btn btn-primary pull-right" name="submit_dbConfig"><?=LANG['global']['maj-next']?></button>
    </div>
</form>
</p>

<script type="text/javascript">
    $("#appForm").on("submit", function(e){
      e.preventDefault();
      $.ajax({
        url: "<?=$root?>/install/cms",
        type: "POST",
        data: $(this).serialize(),
        success: function(data)
        {
          $("#notification").html(data);
        },
        error: function(data)
        {
          $("#notification").html(data);
        }
      })
    });
</script>

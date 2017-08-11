<footer class="footer">
  <div class="container">
    <p class="text-muted">Powered by <a href="https://www.systemstatus.fr">SystemStatus &copy;</a><span class="pull-right">Version : <?=CMS_VERSION?></span></p>
  </div>
</footer>

<script>
    $("button[type='submit']").on('click', function () {
        var $btn = $(this).button('loading');
        setTimeout(function(){
            $btn.button('reset')
        }, 1500);
        // business logic...
    })
</script>

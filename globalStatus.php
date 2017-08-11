<?php

  $api = new API();
  $services = json_decode($api->getServices());
  $services = json_decode(json_encode($services->data), True);

  //Initialize values
  $status1 = 0;
  $status2 = 0;
  $status3 = 0;
  $status4 = 0;

  if(is_array($services)) {

    foreach ($services as $serviceKey => $serviceValue) {

        switch ($services[$serviceKey]['status']){
          case 1:
            ++$status1;
            break;
          case 2:
            ++$status2;
            break;
          case 3:
            ++$status3;
            break;
          case 4:
            ++$status4;
            break;
        }

      }

  }

  $globalStatus = ($status4 > 0) ? "info" : ($status3 > 0) ? "danger" : ($status2 > 0) ? "warning" : "success";

  ?>
<link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet" integrity="sha384-wvfXpqpZZVQGK6TAh5PVlGOfQNHSoD2xbE+QkPxCAFlNEevoEH3Sl0sibVcOQVnN" crossorigin="anonymous">
<style> .globalStatus-success {  color: #18bc9c;  }  .globalStatus-info {  color: #3498db;  }  .globalStatus-warning {  color: #f39c12;  }  .globalStatus-danger {  color: #e74c3c;  }</style>

<?php if(isset($_GET['darkTheme'])): ?>
<span style="background: rgba(0, 0, 0, 0.79); padding: 5px 30px; border-radius: 3px; display: block; color: white; border: 1px solid black;">
  <?=APP_NAME?>&nbsp;<i class="fa fa-signal globalStatus-<?=$globalStatus?>"></i>
</span>
<?php else: ?>
<span style="background: rgb(255, 255, 255); padding: 5px 30px; border-radius: 3px; color: black; border: 1px solid black; display: block;">
  <?=APP_NAME?>&nbsp;<i class="fa fa-signal globalStatus-<?=$globalStatus?>"></i>
</span>
<?php endif; ?>

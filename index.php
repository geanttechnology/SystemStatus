<?php
// Copyright © 2017 by SystemStatus.fr
// All rights reserved. This file or any portion thereof MUST contain the following copyrights.

$debug = 1;

//Show errors
if($debug == 1){error_reporting(-1);}

//Dev stats mode only
$time_start = microtime(true);

//Run App
require __DIR__ . '/inc/class/App.php'; // including app class
new App(); // creating new app

//Dev stats mode only
if($debug == 1){$time_end = microtime(true);}

if($debug == 1){
  die(var_dump("App generated within " . ($time_end - $time_start) . " seconds" . var_dump($_COOKIE) . var_dump($_GET) . var_dump($_POST)));
}

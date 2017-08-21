<?php
// Copyright © 2017 by SystemStatus.fr
// All rights reserved. This file or any portion thereof MUST contain the following copyrights.

//Show errors
error_reporting(-1);

//Dev stats mode only
$time_start = microtime(true);

//Run App
require __DIR__ . '/inc/class/App.php'; // including app class
new App(); // creating new app

//Dev stats mode only
$time_end = microtime(true);

die(var_dump(($time_end - $time_start) . " seconds"));

<?php
// Copyright © 2017 by SystemStatus.fr
// All rights reserved. This file or any portion thereof MUST contain the following copyrights.

// Home
$router->get('/install', 'InstallController@home');

// Cms
$router->get('/install/cms', 'InstallController@app');
$router->post('/install/cms', 'InstallController@app_');

// User
$router->get('/install/user', 'InstallController@createUser');
$router->post('/install/user', 'InstallController@createUser_');

// Finish
$router->get('/install/finish', 'InstallController@finish');

<?php
// Copyright © 2017 by SystemStatus.fr
// All rights reserved. This file or any portion thereof MUST contain the following copyrights.

$router->get('/', 'HomeController@home');

// Auth
Auth::routes($router);

// Admin
$router->get('/admin', 'AdminController@home');
$router->get('/admin/update', 'AdminController@update');
$router->post('/admin/update', 'AdminController@update_');
$router->post('/admin/update/download', 'AdminController@download');
$router->get('/getGlobalStatus', function(){ include(__DIR__ . "/../../globalStatus.php"); exit(0); });

// USERS
$router->get('/admin/users', 'UsersController@users');
$router->post('/admin/users/update', 'UsersController@updateUser');
$router->post('/admin/users/add', 'UsersController@addUser');
$router->post('/admin/users/delete', 'UsersController@deleteUser');

// MONITORING
$router->get('/admin/monitoring', 'MonitoringController@monitoring');
$router->post('/admin/monitoring/add', 'MonitoringController@add');
$router->post('/admin/monitoring/delete', 'MonitoringController@delete');
$router->get('/admin/monitoring/ping/(\w+)/(\w.+)/(\d+)', 'MonitoringController@externalPing');

// SETTINGS
$router->get('/admin/settings', 'SettingsController@settings');
$router->post('/admin/settings/update', 'SettingsController@update');
$router->post('/admin/settings/maintenance', 'SettingsController@maintenance');
$router->post('/admin/settings/reset/(\w+)/(\w+)', 'SettingsController@reset');

// ACCIDENTS
$router->get('/admin/accidents/([A-Z0-9_-]+)', 'AccidentsController@accident');
$router->post('/admin/accidents/update', 'AccidentsController@update');
$router->post('/admin/accidents/close', 'AccidentsController@close');
$router->post('/admin/accidents/delete', 'AccidentsController@delete');
$router->post('/admin/accident/add', 'AccidentsController@add');

// CATEGORY
$router->post('/admin/add/category', 'CategoryController@add');
$router->post('/admin/delete/category/all/(\d+)', 'CategoryController@deleteAll');
$router->post('/admin/delete/category/(\d+)', 'CategoryController@delete');


// SERVICES
$router->post('/admin/add/services', 'ServicesController@add');
$router->post('/admin/update/services/(\d+)/(\d+)', 'ServicesController@update');
$router->get('/admin/delete/services/(\d+)', 'ServicesController@delete');
$router->get('/admin/assign/services/(\d+)/to/(\d+)', 'ServicesController@assignService');

// ITEMS
$router->get('/admin/manageItems', 'AdminController@manageItems');

// PLUGINS
$router->get('/admin/plugins', 'PluginsController@home');

// THEMES
$router->get('/admin/themes', 'ThemesController@home');
$router->get('/admin/themes/edit/(\w+)', 'ThemesController@edit');
$router->post('/admin/themes/edit', 'ThemesController@edit_');
$router->post('/admin/themes/delete/(\w+)', 'ThemesController@delete');
$router->post('/admin/themes/active/(\w+)', 'ThemesController@active');
$router->post('/admin/themes/disable/(\w+)', 'ThemesController@disable');

//BAN
$router->get('/banned', 'HomeController@banned');
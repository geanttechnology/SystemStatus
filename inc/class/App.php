<?php
// Copyright © 2017 by SystemStatus.fr
// All rights reserved. This file or any portion thereof MUST contain the following copyrights.

  class App
  {

    public function __construct()
    {
      if (!isset($_SESSION)) {
        session_start();
      }

      require_once __DIR__ . '/../../vendor/autoload.php';
      require_once __DIR__ . '/Autoloader.php';

      define('API_URL', 'http://api.systemstatus.fr/v2/');

      if (App::isInstalled()) {
        $this->loadConfig();
      }

      // APP_URL AND ROOT DIRECTORY
      if (file_exists(__DIR__ . '/../../config/app.php') && App::isInstalled()) {
        $config = include_once __DIR__ . '/../../config/app.php';
        if (!defined('APP_URL')) {
          define('APP_URL', $config['url']);
        }
        if (!defined('APP_ROOT')) {
          define('APP_ROOT', $config['root']);
        }
      } else if (!App::isInstalled()) {
        define('APP_URL', (isset($_SERVER['HTTPS']) ? "https" : "http") . "://$_SERVER[HTTP_HOST]");
      }



      $this->loadClass();
      $this->loadMiddlewares();
      $this->loadControllers();
      if(!App::isInstalled()){
        define('LANG', $this->loadLanguageWCookie());
      }else{
        define('LANG', $this->loadLanguage());
      }
      $this->loadRoutes();
      if (App::isInstalled())
        $this->loadTheme();
    }

    private function loadTheme()
    {
      if (defined('THEME_NAME')) {
        $theme = new Theme(THEME_NAME);
      }
    }

    private function loadConfig()
    {
      $app = require_once __DIR__ . '/../../config/app.php';

      define('CMS_VERSION', $app['cms']['version']);
      define('CMS_LICENCE', $app['cms']['licence']);
      define('CMS_API', $app['cms']['api_key']);
      define('THEME_NAME', $app['theme']['name']);
      define('APP_NAME', $app['name']);
      define('CMS_LANGUAGE', $app['language']);
      // APP_URL AND ROOT DIRECTORY
      if (file_exists(__DIR__ . '/../../config/app.php') && App::isInstalled()) {
        define('APP_URL', $app['url']);
        define('APP_ROOT', $app['root']);
      } else if (!App::isInstalled()) {
        define('APP_URL', (isset($_SERVER['HTTPS']) ? "https" : "http") . "://$_SERVER[HTTP_HOST]");
      }

    }

    private function loadLanguageWCookie()
    {
      return LanguageController::preloadWCookie();
    }

    private function loadLanguage()
    {
      return LanguageController::preload();
    }

    private function loadRoutes()
    {
      $router = new \Bramus\Router\Router(); // creating router

      // loading routes
      Autoloader::loadRoute('web', $router); // web
      Autoloader::loadRoute('install', $router); // install
      Autoloader::loadRoute('plugins', $router); // plugins

      $router->run(); // running routes
    }

    private function loadControllers()
    {
      Autoloader::loadController('Controller');
      Autoloader::loadController('LanguageController');
      Autoloader::loadController('HomeController');
      Autoloader::loadController('InstallController');
      Autoloader::loadController('AuthController');
      Autoloader::loadController('AdminController');
      Autoloader::loadController('UsersController');
      Autoloader::loadController('MonitoringController');
      Autoloader::loadController('SettingsController');
      Autoloader::loadController('AccidentsController');
      Autoloader::loadController('CategoryController');
      Autoloader::loadController('ServicesController');
      Autoloader::loadController('PluginsController');
      Autoloader::loadController('ThemesController');
      Autoloader::loadController('SecurityController');
    }

    private function loadMiddlewares()
    {
      Autoloader::loadMiddleware('Middleware');
      Autoloader::loadMiddleware('InstallMiddleware');
      Autoloader::loadMiddleware('InstallationCheckMiddleware');
      Autoloader::loadMiddleware('AuthMiddleware');
      Autoloader::loadMiddleware('StatusMiddleware');
      Autoloader::loadMiddleware('APIMiddleware');
    }

    private function loadClass()
    {
      Autoloader::loadClass('Auth');
      Autoloader::loadClass('Api');
      Autoloader::loadClass('Theme');
      Autoloader::loadClass('Plugin');
    }

    public static function isInstalled()
    {
      if (file_exists(__DIR__ . '/../../storage/installed'))
        return TRUE;
      else
        return FALSE;
    }

    public static function inMaintenance()
    {
      if (file_exists(__DIR__ . '/../../storage/maintenance'))
        return TRUE;
      else
        return FALSE;
    }

  }
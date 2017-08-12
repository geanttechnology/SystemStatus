<?php

  class LanguageController extends Controller
  {

    public function __construct()
    {

    }

    public static function preloadWCookie()
    {
      if (isset($_GET['lang']) && !empty($_GET['lang']) && strlen($_GET['lang']) == 2) {

        setcookie("lang", $_GET['lang']);
        return $lang = LanguageController::load($_GET['lang']);

      } else if (isset($_COOKIE['language']) && !empty($_COOKIE['language']) && strlen($_COOKIE['language']) == 2) {

        return $lang = LanguageController::load($_COOKIE['language']);

      } else {

        return $lang = LanguageController::load('fr');

      }
    }

    public static function showInstallList()
    {
      return array_diff(scandir(__DIR__ . "/../../lang", 1), ['..', '.']);
    }

    public static function load($language)
    {
      return $lang = require(__DIR__ . "/../../lang/" . $language . "/translations.php");
    }

  }

?>
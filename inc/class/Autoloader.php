<?php
// Copyright © 2017 by SystemStatus.fr
// All rights reserved. This file or any portion thereof MUST contain the following copyrights.

class Autoloader
{

    /**
     * Enregistre notre autoloader
     */
    static function register()
    {
        spl_autoload_register(array(__CLASS__, 'autoload'));
    }

    /**
     * Inclue le fichier correspondant à notre classe
     * @param $class string Le nom de la classe à charger
     */
    static function loadClass($class)
    {
        require __DIR__.'/'.$class.'.php';
    }

    /**
     * Inclue le fichier correspondant à notre classe
     * @param $class string Le nom de la classe à charger
     */
    static function loadRoute($class, $router)
    {
        require __DIR__.'/../routes/'.$class.'.php';
    }

    /**
     * Inclue le fichier correspondant à notre classe
     * @param $class string Le nom de la classe à charger
     */
    static function loadController($class)
    {
        require __DIR__.'/../controllers/'.$class.'.php';
    }

    /**
     * Inclue le fichier correspondant à notre classe
     * @param $class string Le nom de la classe à charger
     */
    static function loadMiddleware($class)
    {
        require __DIR__.'/../middlewares/'.$class.'.php';
    }


}

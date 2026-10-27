<?php

// dont use, no need with require
class CancionesSingleton
{
    private static $instance = null;
    /** @var Cancion[] $songs */
    public static $canciones;

    public static function getInstance()
    {
        if (is_null(self::$instance)) {
            self::$instance = new CancionesSingleton();
        }
        return self::$instance;
    }
}

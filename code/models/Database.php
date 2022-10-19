<?php

class Database
{
    private $_bdd = null;
    private static $_instance = null;

    private function __construct()
    {
        $this->_bdd = new PDO('mysql:host=' . BD_HOST . '; dbname=' . BD_DBNAME . '; charset=utf8', BD_USER, BD_PWD);
        $this->_bdd->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }

    public static function getInstance()
    {
        if (is_null(self::$_instance))
            self::$_instance = new Database();
        return self::$_instance;
    }

    public function getBdd()
    {
        return $this->_bdd;
    }
}
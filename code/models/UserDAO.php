<?php
require_once (PATH_MODELS."DAO.php");
abstract class UserDAO extends DAO
{
    protected $_username;

    public function __construct($debug, $username)
    {
        $this->_debug = $debug;
        $this->_username = $username;
    }
}
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

    public function getAllSalle(){
        $result = $this->queryAll("SELECT * FROM SALLE");
        $data = [];
        foreach ($result as $res){
            $data[] = $res['id'];
        }
        return $data;
    }
}
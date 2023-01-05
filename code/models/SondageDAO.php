<?php
require_once (PATH_MODELS."DAO.php");
class SondageDAO extends DAO
{
    public $id;
    public $login;

    private function __construct($id, $username){
        print_r($username, $id);
        $data = $this->queryRow("SELECT * FROM `SONDAGE` NATURAL JOIN PARTICIPER NATURAL JOIN AFFECTER WHERE LOGINETU = ? AND IDSONDAGE = ?", [$username,$id]);
        if(!$data){
            throw new Exception("Pas de sondage");
        } else {
            $this->id = $id;
            $this->login = $username;
        }
    }

    public static function getSondage($id, $username){
        try {
            return new SondageDAO($id, $username);
        } catch (Exception $e) {
            return false;
        }
    }

    public function getReponseSondage(){
        $res = $this->queryRow("SELECT CONTENUREPONSE FROM REPONDRE WHERE LOGINETU = ? AND IDSONDAGE = ?", [$this->login,$this->id]);
        return $res;
    }

    public function InsertOrUpdateReponseSondage($msg){
    $this->insertRow("INSERT INTO REPONDRE VALUES (?,?,?) ON DUPLICATE KEY UPDATE CONTENUREPONSE = ?",[$this->login,$this->id,$msg,$msg]); 
    }
}

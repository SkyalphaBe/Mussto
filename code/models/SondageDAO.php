<?php
require_once (PATH_MODELS."DAO.php");
class SondageDAO extends DAO
{
    public $id;
    public $login;
    public $data;

    private function __construct($id, $username){
        $data = $this->queryRow("SELECT * FROM SONDAGE NATURAL JOIN MODULE NATURAL JOIN RECEVOIR NATURAL JOIN AFFECTER LEFT OUTER JOIN REPONDRE USING (IDSONDAGE, LOGINETU) WHERE LOGINETU = ? AND IDSONDAGE = ?", [$username,$id]);
        if(!$data){
            throw new Exception("Pas de sondage");
        } else {
            if($data['CONTENUSONDAGE']){
                $data['CONTENUSONDAGE'] = json_decode($data['CONTENUSONDAGE'], true);
            }
            if($data['CONTENUREPONSE']) {
                $data['CONTENUREPONSE'] = json_decode($data['CONTENUREPONSE'], true);
            }
            $this->id = $id;
            $this->login = $username;
            $this->data = $data;
        }
    }

    public static function getSondage($id, $username){
        try {
            return new SondageDAO($id, $username);
        } catch (Exception $e) {
            return false;
        }
    }

    public function getData(){
        return $this->data;
    }

    public function InsertOrUpdateReponse($msg){
        $this->insertRow("INSERT INTO REPONDRE (LOGINETU, IDSONDAGE, CONTENUREPONSE) VALUES (?,?,?) ON DUPLICATE KEY UPDATE CONTENUREPONSE = ?",[$this->login,$this->id,$msg,$msg]); 
    }
}

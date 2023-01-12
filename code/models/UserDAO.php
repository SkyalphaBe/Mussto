<?php
require_once (PATH_MODELS."DAO.php");
class UserDAO extends DAO
{
    protected $_username;

    public function __construct($debug, $username)
    {
        parent::__construct($debug);
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

    public function getAllInfo(){
        $data = [];
        $data['user'] = $this->queryRow("SELECT * FROM ETUDIANT WHERE LOGINETU = ?", [$this->_username]);
        $data['groups'] = $this->queryAll("SELECT GROUPE.* FROM GROUPE NATURAL JOIN AFFECTER WHERE LOGINETU  = ?", [$this->_username]);
        $data['modules'] = $this->queryAll("SELECT MODULE.* FROM MODULE NATURAL JOIN PARTICIPER NATURAL JOIN AFFECTER WHERE LOGINETU = ?", [$this->_username]);
        $data['marks'] = $this->queryAll("SELECT * FROM NOTER RIGHT OUTER JOIN ( SELECT LOGINETU, DEVOIR.* FROM DEVOIR NATURAL JOIN EVALUER NATURAL JOIN AFFECTER WHERE LOGINETU = ?) as ELEVE USING (LOGINETU, IDDEVOIR) NATURAL JOIN ETUDIANT", [$this->_username]);
        $data['responses'] = $this->queryAll("SELECT * FROM REPONDRE WHERE LOGINETU = ?", [$this->_username]);

        return $data;
    }
}
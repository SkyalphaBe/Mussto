<?php
require_once (PATH_MODELS.'UserDAO.php');
class AdminDAO extends UserDAO
{
    public function getAllModules(){
        $res = $this->queryAll("SELECT REFMODULE, NOMMODULE FROM MODULE");
        return $res;
    }

    public function getAllGroupes(){
        $res =  $this->queryAll("SELECT ANNEEGROUPE, INTITULEGROUPE FROM GROUPE");
        return $res;
    }

    public function getAllEtudiants(){
        $res = $this->queryAll("SELECT PRENOMETU,NOMETU FROM ETUDIANT");
        return $res;
    }

    public function getAllProfesseurs(){
        $res = $this->queryAll("SELECT PRENOMPROF, NOMEPROF FROM PROFESSEUR");
        return $res;
    }
}
?>
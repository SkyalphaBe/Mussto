<?php
require_once (PATH_MODELS.'UserDAO.php');
class EtuDAO extends UserDAO
{
    public function getNames(){
        $res = $this->queryRow("SELECT PRENOMETU, NOMETU FROM ETUDIANT WHERE loginetu = ?",  [$this->_username]);
        return $res;
    }

    public function getGroups(){
        $res = $this->queryAll("SELECT intitulegroupe, anneegroupe FROM AFFECTER WHERE loginetu = ?",  [$this->_username]);
        return $res;
    }

    public function getModules(){
        $result = [];
        $groups = $this->getGroups();
        foreach ($groups as $group){
            $data = $this->queryAll("SELECT MODULE.REFMODULE, NOMMODULE, DESCRIPTIONMODULE 
            FROM MODULE JOIN PARTICIPER ON MODULE.REFMODULE = PARTICIPER.REFMODULE 
            WHERE PARTICIPER.intitulegroupe = ? AND PARTICIPER.anneegroupe = ?", [$group['intitulegroupe'], $group['anneegroupe']]);
            if ($data){
                $result = array_merge($result, $data);
            }
        }

        return $result;
    }

    public function getDS(){
        $result = [];
        $groups = $this->getGroups();
        foreach ($groups as $group){
            $data = $this->queryAll("SELECT IDDEVOIR, NOMMODULE, CONTENUDEVOIR, SALLE, DATE_FORMAT(DATEDEVOIR, '%d/%m/%Y') as DATEDEVOIR
            FROM DEVOIR JOIN MODULE USING(REFMODULE)
            WHERE intitulegroupe = ? AND anneegroupe = ? AND CURRENT_DATE() < DATEDEVOIR", [$group['intitulegroupe'], $group['anneegroupe']]);
            if ($data){
                $result = array_merge($result, $data);
            }
        }
        return $result;
    }

    public function getSondage(){

    }

    public function getNotes($login){
        $result = [];
        $result[] = $this->queryRow("SELECT NOTE, NOMMODULE 
        FROM NOTER JOIN MODULE USING(REFMODULE)
        WHERE LOGINETU = ?",[$this->_username]);
        return $result;
    }
}
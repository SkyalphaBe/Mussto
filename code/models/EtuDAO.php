<?php
require_once (PATH_MODELS.'UserDAO.php');
class EtuDAO extends UserDAO
{
    public function getGroups(){
        $res = $this->queryRow("SELECT intitulegroupe, anneegroupe FROM AFFECTER WHERE loginetu = ?",  [$this->_username]);
        return $res;
    }

    public function getModules(){
        $result = [];
        $groups = $this->getGroups();
        foreach ($groups as $group){
            $result[] = $this->queryRow("SELECT REFMODULE, NOMMODULE, DESCRIPTIONMODULE 
            FROM MODULE JOIN PARTICIPER ON MODULE.REFMODULE = PARTICIPER.REFMODULE 
            WHERE PARTICIPER.intitulegroupe = ? AND PARTICIPER.anneegroupe = ?", [$group['intitulegroupe'], $group['anneegroupe']]);
        }

        return $result;
    }
}
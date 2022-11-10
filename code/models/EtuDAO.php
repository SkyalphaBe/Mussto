<?php
require_once (PATH_MODELS.'UserDAO.php');
class EtuDAO extends UserDAO
{
    public function getNames(){
        $res = $this->queryRow("SELECT PRENOMETU, NOMETU FROM ETUDIANT WHERE loginetu = ?",  [$this->_username]);
        return $res;
    }

    /**
     * @return array|false|null
     */
    public function getGroups(){
        $res = $this->queryAll("SELECT intitulegroupe, anneegroupe FROM AFFECTER WHERE loginetu = ?",  [$this->_username]);
        return $res;
    }

    /**
     * @return array Listes des Modules suivi par l'étudiant (suivi par les groupes dans lequel l'étudiant est) Le tableau est vide si il n'y a pas de modules
     */
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

    /**
     * @return array Liste des Devoir à venir pour l'étudiant (les devoirs passés ne sont pas retournées) Le tableau est vide si il n'y a pas de DS
     */
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
        $result[] = $this->queryAll("SELECT NOTE, NOMMODULE,DATE_FORMAT(DATEDEVOIR, '%d septembre %Y') as DATEDEVOIR
        FROM NOTER 
        JOIN DEVOIR USING(IDDEVOIR)
        JOIN MODULE using(REFMODULE)
        WHERE LOGINETU = ?",[$this->_username]);
        return $result[0];
    }
}
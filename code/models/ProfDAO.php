<?php
require_once (PATH_MODELS.'UserDAO.php');
class ProfDAO extends UserDAO
{
    public function getNames(){
        $res = $this->queryRow("SELECT PRENOMPROF FROM PROFESSEUR WHERE loginprof = ?",  [$this->_username]);
        return $res;
    }
    public function getModule($ref){
        $data = $this->queryRow("SELECT NOMMODULE, REFMODULE
        FROM MODULE
        JOIN ENSEIGNER USING(REFMODULE)
        WHERE LOGINPROF = ? AND REFMODULE = ?", [$this->_username, $ref]);
        return $data;
    }

    /**
     * @param $ref ID du module
     * @return array|false|null Renvoie tous les étudiants pour lesquels le prof enseigne le module
     */
    public function getAllEtuForModule($ref){
        $data = $this->queryAll("SELECT PRENOMETU, NOMETU FROM MODULE NATURAL JOIN ENSEIGNER NATURAL JOIN PARTICIPER NATURAL JOIN AFFECTER NATURAL JOIN ETUDIANT WHERE LOGINPROF = ? AND REFMODULE = ?", [$this->_username, $ref] );
        return $data;
    }

    /**
     * @param $id Id du devoir
     * @return array|false|null Renvoie la liste des résultat pour chaque éleve de ce DS (Si l'élève n'as pas encore de notes, sa note est null)
     */
    public function getResultsForDS($id){
        $data = $this->queryAll("SELECT PRENOMETU, NOMETU, NOTE, DATE_ENVOIE, COMMENTAIRE FROM NOTER RIGHT OUTER JOIN ( SELECT LOGINETU, IDDEVOIR FROM DEVOIR NATURAL JOIN EVALUER NATURAL JOIN AFFECTER WHERE IDDEVOIR = ? AND LOGINPROF = ? ) as ELEVE USING (LOGINETU, IDDEVOIR) NATURAL JOIN ETUDIANT", [ $id, $this->_username] );
        return $data;
    }

    public function getGroups($UE){
        $data = [];
        $result=$this->queryAll("select INTITULEGROUPE
        from GROUPE
        join PARTICIPER using(INTITULEGROUPE)
        where REFMODULE = ?",[$UE]);
        foreach ($result as $line){
            $data[] = $line['INTITULEGROUPE'];
        }
        return $data;
    }
    public function getModules(){
        $result = $this->queryAll("select NOMMODULE,REFMODULE
        from MODULE
        join ENSEIGNER using(REFMODULE)
        where LOGINPROF = ?",[$this->_username]);
        $i = 0;
        foreach ($result as $module){
            $group = $this->getGroups($module['REFMODULE']);
            if ($group){
                $result[$i]['GROUPS'] = $group;
            }
            $i++;
        }
        return $result;
    }

    public function getDSForModule($ref){
        $data = $this->queryAll("SELECT NOMMODULE,IDDEVOIR,CONTENUDEVOIR,DATEDEVOIR,REFMODULE
        FROM DEVOIR
        join MODULE using(REFMODULE)
        WHERE LOGINPROF = ? AND REFMODULE = ?", [$this->_username, $ref]);
        return $data;
    }

    public function insertDS($argument){
        $res = $this->insertRow("INSERT INTO DEVOIR
        (REFMODULE, CONTENUDEVOIR, COEF, DATEDEVOIR, SALLE,LOGINPROF)
        VALUES (?,?,?,?,?,?);",$argument);

        return $res;
    }

    public function insertNote($argument){
        $res = $this->insertRow("INSERT INTO NOTER 
        (LOGINETU,IDDEVOIR,NOTE,DATE_ENVOIE,COMMENTAIRE) 
        VALUES (?,?,?,NOW(),?)",$argument);
    }
}
?>
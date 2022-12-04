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

    public function getDevoir($sujet){
        $data = $this->queryRow("SELECT IDDEVOIR FROM DEVOIR
        WHERE CONTENUDEVOIR = ?", [$sujet]);
        return $data;
    }

    public function insertDS($argument){
        $res = $this->insertRow("INSERT INTO `DEVOIR`(`INTITULEGROUPE`, `ANNEEGROUPE`, `REFMODULE`, `CONTENUDEVOIR`, `COEF`, `DATEDEVOIR`, `SALLE`) VALUES (?,YEAR(NOW()),?,?,?,?,?);",$argument);
    }

    public function insertNote($argument){
        $res = $this->insertRow("INSERT INTO `NOTER` (`LOGINETU`,`IDDEVOIR`,`NOTE`,`DATE_ENVOIE`,`COMMENTAIRE`) VALUES (?,?,?,NOW(),?)",$argument);
    }
}
?>
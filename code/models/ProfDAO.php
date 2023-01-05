<?php
require_once (PATH_MODELS.'UserDAO.php');
require_once (PATH_MODELS.'DevoirDAO.php');
class ProfDAO extends UserDAO
{
    public function getNames(){
        $res = $this->queryRow("SELECT PRENOMPROF FROM PROFESSEUR WHERE loginprof = ?",  [$this->_username]);
        return $res;
    }
    /**
     * @param $ref Id du module
     * @return array|false|null
     */
    public function getModule($ref){
        $data = $this->queryRow("SELECT NOMMODULE, REFMODULE, DESCRIPTIONMODULE
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
     * 
     */
    public function getProfsForModule($ref){
        $data = $this->queryAll("SELECT LOGINPROF, PRENOMPROF, NOMEPROF FROM ENSEIGNER NATURAL JOIN PROFESSEUR WHERE REFMODULE = ?", [$ref]);
        return $data;
    }

    /**
     *  @param $ref id du module
     *  @return array Renvoie tout les groupes concerné par un module
     */
    public function getGroups($ref){  ///A CORRIGER !!!!!! (PEUT RENVOYER QUELQUE CHOSE SI LE PROF N'ENSEIGNE PAS LE MODULE)
        $data = [];
        $result=$this->queryAll("select *
        from GROUPE
        natural join PARTICIPER
        where REFMODULE = ?",[$ref]);
        foreach ($result as $line){
            $data[] = $line['INTITULEGROUPE'];
        }
        return $data;
    }

    /**
     * @return array Renvoie la liste des modules ensigner par le prof
     */
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

    public function insertSondage($ref, $title, $content, $groups){
        $this->beginTransaction();
        $res = $this->insertRow("INSERT INTO SONDAGE (REFMODULE, LOGINPROF, CONTENUSONDAGE, DATESONDAGE, TITLESONDAGE) VALUES (?, ?, ?, NOW(), ?)", [$ref, $this->_username, $content, $title]);
        if ($res){
            foreach($groups as $group){
                $this->insertRow("INSERT RECEVOIR (IDSONDAGE, INTITULEGROUPE) VALUES (?, ?)", [$res, $group]);
            }
            $this->commitTransaction();
        } else {
            $this->rollbackTransaction();
        }
        return $res;
    }

    public function deleteSondage($id){
        $res = $this->execQuery("DELETE FROM SONDAGE WHERE IDSONDAGE = ? AND LOGINPROF = ?", [$id, $this->_username]);
        return $res;
    }

    public function getSondage($id){
        $res = $this->queryRow("SELECT * FROM SONDAGE WHERE LOGINPROF = ? AND IDSONDAGE = ?", [$this->_username, $id]);
        if ($res){
            $res['CONTENUSONDAGE'] = json_decode($res['CONTENUSONDAGE'], true);
            $res['GROUPS'] = array_map(fn($val) => $val['INTITULEGROUPE'], $this->queryAll("SELECT INTITULEGROUPE FROM RECEVOIR WHERE IDSONDAGE = ?", [$id]));
        }
        return $res;
    }

    public function getResultSondage($id){
        $res = $this->queryAll("SELECT * FROM REPONDRE NATURAL JOIN ETUDIANT WHERE IDSONDAGE = ?", [$id]);
        if ($res){
            $callback = function($line){
                $line['CONTENUREPONSE'] = json_decode($line['CONTENUREPONSE'], true);
                return $line;
            };
            $res = array_map($callback, $res);
        }
        return $res;
    }

    public function getAllSondage($ref){
        $res = $this->queryAll("SELECT * FROM SONDAGE WHERE LOGINPROF = ? AND REFMODULE = ?", [$this->_username, $ref]);
        return $res;
    }

}
?>
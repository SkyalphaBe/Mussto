<?php
require_once (PATH_MODELS.'UserDAO.php');
class EtuDAO extends UserDAO
{
    /**
     * @return false|mixed|null Renvoie le nom de l'étudiant
     */
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
     * @param $ref Reference du module
     * @return array Renvoie les informations sur un module uniquement si il est suivi par l'étudiant
     */
    public function getModule($ref){
        $result = [];
        $groups = $this->getGroups();foreach ($groups as $group){
            $data = $this->queryRow("SELECT MODULE.REFMODULE, NOMMODULE, DESCRIPTIONMODULE 
            FROM MODULE JOIN PARTICIPER ON MODULE.REFMODULE = PARTICIPER.REFMODULE 
            WHERE PARTICIPER.intitulegroupe = ? AND PARTICIPER.anneegroupe = ? AND MODULE.REFMODULE = ?", [$group['intitulegroupe'], $group['anneegroupe'], $ref]);
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
            FROM DEVOIR JOIN MODULE USING(REFMODULE) NATURAL JOIN EVALUER
            WHERE CURRENT_DATE() < DATEDEVOIR AND INTITULEGROUPE = ? ORDER BY DATEDEVOIR ASC", [$group['intitulegroupe']]);
            if ($data){
                $result = array_merge($result, $data);
            }
        }
        return $result;
    }

    public function getDSForModule($ref){
        $groups = $this->getGroups();
        $result = [];
        foreach ($groups as $group){
            $data = $this->queryAll("SELECT * FROM DEVOIR NATURAL JOIN EVALUER WHERE CURRENT_DATE() < DATEDEVOIR AND REFMODULE = ? AND INTITULEGROUPE = ?", [$ref, $group['intitulegroupe']]);
            if ($data){
                $result = array_merge($result, $data);
            }
        }
        return $result;
    }

    /**
     * @return array Liste des sondages concernant l'étudiant. Le tableau est vide si il n'y a pas de sondage pour cet étudiant
     */
    public function getSondages(){
        return $this->queryAll("SELECT * FROM SONDAGE NATURAL JOIN MODULE NATURAL JOIN RECEVOIR NATURAL JOIN AFFECTER WHERE LOGINETU = ?", [$this->_username]);
    }

    /**
     * @param $module
     * @return array|false|null renvoie la liste des nom-prenoms + login qui enseigne un module
     */
    public function getProfsForModule($module){
        $result = $this->queryAll("SELECT LOGINPROF, PRENOMPROF, NOMEPROF FROM PROFESSEUR NATURAL JOIN ENSEIGNER WHERE REFMODULE = ?", [$module]);
        return $result;
    }

    /*
    public function getGroupsForModule($module){
        $result = $this->queryAll("SELECT ");
    }*/

    /**
     * @param $module
     * @return array|false|null renvoie les notes pour un module
     */
    public function getNotesForModule($module){
        $result = $this->queryAll("SELECT * FROM (SELECT *, RANK() OVER (PARTITION BY IDDEVOIR ORDER BY NOTE DESC) AS RANG FROM `NOTER` NATURAL JOIN DEVOIR NATURAL JOIN MODULE WHERE REFMODULE = ?) t WHERE LOGINETU = ?" , [ $module, $this->_username]);
        return $result;
    }

    /**
     * @param $module
     * @return false|mixed|null renvoie la dernière note relative à un module
     */
    public function getLastNoteForModule($module){
        $result = $this->queryRow("SELECT NOTE, DATE_ENVOIE, max(IDDEVOIR) as id
        FROM NOTER 
        JOIN DEVOIR USING (IDDEVOIR) 
        JOIN MODULE USING (REFMODULE) 
        WHERE LOGINETU = ? AND NOMMODULE = ?", [$this->_username, $module]);
        return $result;
    }

    /**
     * @param $module
     * @return float|int|null renvoie la moyenne pour un module
     */
    public function getAverageForModule($module){
        $avg = null;
        $result = $this->queryAll("SELECT NOTE, COEF FROM NOTER NATURAL JOIN DEVOIR NATURAL JOIN MODULE WHERE LOGINETU = ? AND REFMODULE = ?", [$this->_username, $module]);
        if ($result){
            $sum = 0;
            $sum_coef = 0;
            foreach ($result as $note){
                $sum = $sum + ($note['NOTE'] * $note['COEF']);
                $sum_coef = $sum_coef + $note['COEF'];
            }

            $avg = $sum / $sum_coef;
        }

        return $avg;
    }

    /**
     * @return array|false|null Renvoie toutes les notes d'un élève
     */
    public function getNotes(){
        $result = $this->queryAll("SELECT REFMODULE, NOTE, NOMMODULE,DATE_FORMAT(DATEDEVOIR, '%d %M %Y') as DATEDEVOIR_FORM, DATE_FORMAT(DATE_ENVOIE, '%d %M %Y') as DATE_ENVOIE_FORM, CONTENUDEVOIR
        FROM NOTER 
        JOIN DEVOIR USING(IDDEVOIR)
        JOIN MODULE using(REFMODULE)
        WHERE LOGINETU = ? AND DATEDIFF(DATE_ENVOIE, NOW()) > -32 ORDER BY DATE_ENVOIE",[$this->_username]);
        return $result;
    }
}
<?php
require_once (PATH_MODELS."DAO.php");
class DevoirDAO extends DAO
{
    public $id;
    public $username;
    public $data;

    public function __construct($debug, $id, $username){
        parent::__construct($debug);
        $this->id = $id;
        $this->username = $username;
        $res = $this->queryRow("SELECT IDDEVOIR FROM DEVOIR NATURAL JOIN ORGANISER_DEVOIR WHERE IDDEVOIR = ? AND LOGINPROF = ?", [$this->id, $this->username]);
        if (!$res){
            throw new Exception("Pas de devoir accesible");
        }
    }

    public static function insertDS($data, $username){
        $res = false;
        if ($data && array_key_exists("module", $data) && $data['module']){
            require_once(PATH_MODELS."ProfDAO.php");
            $prof_dao = new ProfDAO(false, $username);
            if ($prof_dao->getModule($data['module'])){
                if (array_key_exists("content", $data) && $data['content'] && 
                array_key_exists("date", $data) && $data['date'] && 
                array_key_exists("salle", $data) && $data['salle'] && 
                array_key_exists("groups", $data) && $data['groups'] && is_array($data['groups']) &&
                array_key_exists("orga", $data) && is_array($data['orga']) && 
                array_key_exists("coef", $data) && $data['coef'] && 
                array_key_exists("module", $data) && $data['module']){
                    $prof_dao->beginTransaction();
                    $idInsert = $prof_dao->insertRow("INSERT INTO DEVOIR (REFMODULE, CONTENUDEVOIR, COEF, DATEDEVOIR, SALLE) VALUES (?, ?, ?, ?, ?)", [$data['module'], $data['content'], $data['coef'], $data['date'], $data['salle']]);
                    if ($idInsert > 0){
                        if ($prof_dao->execQuery("INSERT INTO ORGANISER_DEVOIR VALUES (?, ?)", [$username, $idInsert])){ //On insert au moins celui qui fait la requete
                            foreach($data['orga'] as $orga){
                                $prof_dao->execQuery("INSERT INTO ORGANISER_DEVOIR VALUES (?, ?)", [$orga, $idInsert]);
                            }

                            foreach($data['groups'] as $group){
                                $prof_dao->execQuery("INSERT INTO EVALUER VALUES (?, 2022, ?)", [$group, $idInsert]);
                            }
                            
                            $prof_dao->commitTransaction();
                            $res = $idInsert;
                        } else {
                            $prof_dao->rollbackTransaction();
                            throw new Exception("Erreur insertion", 5);
                        }

                    } else {
                        $prof_dao->rollbackTransaction();
                        throw new Exception("Erreur insertion", 4);
                    }
                } else {
                    throw new Exception("Pas assez de données", 3);
                }
            } else {
                throw new Exception("Module innaccesible pour le professeur", 2);
            }
        } else {
            throw new Exception("Pas de ref module", 1);
        }

        return $res;
    }

    public static function getDS($id, $username){
        try{
            return new DevoirDAO(false, $id, $username);
        } catch (Exception $e){
            error_log($e->getMessage());
            return false;
        }
    }

    /**
     * @return array|false renvoie toutes les infos d'un ds
     */
    public static function getAllInfoDS($id, $username){
        $ds = DevoirDAO::getDS($id, $username);
        $res = false;
        if ($ds){
            $res = $ds->getAllInfo();
        }
        return $res;
    }

    /**
     * @return array recupere toutes les infos du devoir
     */
    public function getAllInfo(){
        $data = $this->queryRow("SELECT IDDEVOIR, REFMODULE, CONTENUDEVOIR, COEF, DATEDEVOIR, SALLE FROM DEVOIR NATURAL JOIN ORGANISER_DEVOIR WHERE IDDEVOIR = ? AND LOGINPROF = ?", [$this->id, $this->username]);
        
        $data['GROUPES'] = $this->getGroupsForDS($data['IDDEVOIR']);
        $data['ORGANISATEUR'] = $this->getOrganisteurForDS($data['IDDEVOIR']);

        $this->data = $data;

        return $data;
    }

     /**
     * @param $id Id du devoir
     * @return array Renvoie la liste des organisateur d'un devoir
     */
    public function getOrganisteurForDS(){
        $data = $this->queryAll("SELECT LOGINPROF, PRENOMPROF, NOMEPROF FROM ORGANISER_DEVOIR NATURAL JOIN PROFESSEUR WHERE IDDEVOIR = ?", [$this->id]);
        return $data;
    }

    /**
     * 
     */
    public function getGroupsForDS(){
        $data = [];
        $result = $this->queryAll("SELECT * FROM DEVOIR NATURAL JOIN EVALUER WHERE IDDEVOIR = ?", [$this->id]);
        foreach ($result as $line){
            $data[] = $line['INTITULEGROUPE'];
        }
        return $data;
    }

    /**
     * @param $id Id du devoir
     * @param $ref Id du module
     * @return array|false|null Renvoie la liste des résultat pour chaque éleve de ce DS (Si l'élève n'as pas encore de notes, sa note est null)
     */
    public function getResultsForDS(){
        $data = $this->queryAll("SELECT LOGINETU, PRENOMETU, NOMETU, NOTE, DATE_ENVOIE, COMMENTAIRE FROM NOTER RIGHT OUTER JOIN ( SELECT LOGINETU, IDDEVOIR FROM DEVOIR NATURAL JOIN EVALUER NATURAL JOIN AFFECTER WHERE IDDEVOIR = ? ) as ELEVE USING (LOGINETU, IDDEVOIR) NATURAL JOIN ETUDIANT", [$this->id] );
        return $data;
    }

    public function updateDevoir($new){
        $this->beginTransaction();
        try {
            $res = $this->execQuery("UPDATE DEVOIR SET COEF = ?, DATEDEVOIR = ?, SALLE = ?, CONTENUDEVOIR = ? WHERE IDDEVOIR = ?", [$new['coef'], $new['date'], $new['salle'], $new['content'], $this->id]);
            if ($res === false){ throw new Exception("Erreur update devoir");}

            $res = $this->execQuery("DELETE FROM ORGANISER_DEVOIR WHERE IDDEVOIR = ? AND NOT LOGINPROF = ?", [$this->id, $this->username]); //Suppression de tous les organisateur sauf celui qui fait la requete
            if ($res === false){ throw new Exception("Erreur suppression prof");}

            foreach($new['orga'] as $prof){
                if ($prof !== $this->username){
                    $res = $this->execQuery("INSERT INTO ORGANISER_DEVOIR (iddevoir, loginprof) VALUES (?, ?)", [$this->id, $prof]); //Insertion de tout les nouveaux organisateurs
                    if ($res === false){ throw new Exception("Erreur insertion prof");}
                }
            }

            $res = $this->execQuery("DELETE FROM EVALUER WHERE IDDEVOIR = ?", [$this->id]); //Suppression de tous les groupes
            if ($res === false){ throw new Exception("Erreur suppression groupes");}

            foreach($new['groups'] as $grp){
                $res = $this->execQuery("INSERT INTO EVALUER (INTITULEGROUPE, ANNEEGROUPE, IDDEVOIR) VALUES (?, 2022, ?)", [$grp, $this->id]);
                if ($res === false){ throw new Exception("Erreur insertion groupes");}
            }
            
            return $this->commitTransaction();
        } catch (Exception $e) {
            $this->rollbackTransaction();

            return false;
        }
        
    }

    public function insertOrUpdateNote($note){
        $res = $this->execQuery("INSERT INTO NOTER (LOGINETU, IDDEVOIR, NOTE, DATE_ENVOIE, COMMENTAIRE) VALUES (?, ?, ?, NOW(), ?) ON DUPLICATE KEY UPDATE NOTE = ?, COMMENTAIRE = ?", [$note['loginetu'], $this->id, $note['note'], $note['comment'], $note['note'], $note['comment']]);
        return $res;
    }

    public function deleteDS(){
        $res = $this->execQuery("DELETE FROM DEVOIR WHERE IDDEVOIR = ?", [$this->id]);
        return $res;
    }

    
}

class AllDevoirDAO extends DevoirDAO{
    public $list;

    private function __construct($debug, $ref, $username){
        $devoirs = $this->queryAll("SELECT IDDEVOIR, REFMODULE, CONTENUDEVOIR, DATEDEVOIR  FROM DEVOIR NATURAL JOIN ORGANISER_DEVOIR join MODULE using(REFMODULE) WHERE REFMODULE = ? AND LOGINPROF = ? ORDER BY DATEDEVOIR DESC", [$ref, $username]);
        if ($devoirs){
            for ($i = 0; $i < count($devoirs); $i++){
                $this->id = $devoirs[$i]['IDDEVOIR'];
                $devoirs[$i]['GROUPES'] = $this->getGroupsForDS();
            }
            $this->list = $devoirs;
        }
        
    }

    public static function getAllDSForModule($ref, $username){
        return (new AllDevoirDAO(true, $ref, $username))->list;
    }

}
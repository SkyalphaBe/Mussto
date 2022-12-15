<?php
require_once (PATH_MODELS."DAO.php");
class DevoirDAO extends DAO
{
    public $id;
    public $DS;

    private function __construct($debug, $id, $username){
        parent::__construct($debug);
        $data = $this->queryRow("SELECT IDDEVOIR, REFMODULE, CONTENUDEVOIR, COEF, DATEDEVOIR, SALLE FROM DEVOIR NATURAL JOIN ORGANISER_DEVOIR WHERE IDDEVOIR = ? AND LOGINPROF = ?", [$id, $username]);
        if (!$data){
            throw new Exception("Pas de devoir");
        } else {
            $this->id = $id;

            $data['GROUPES'] = $this->getGroupsForDS($data['IDDEVOIR']);
            $data['ORGANISATEUR'] = $this->getOrganisteurForDS($data['IDDEVOIR']);

            $this->DS = $data;
        }
    }

    public static function getDS($id, $username){
        try {
            return new DevoirDAO(true, $id, $username);
        } catch (Exception $e) {
            return false;
        }
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

    
}

class AllDevoirDAO extends DevoirDAO{
    public $list;

    private function __construct($debug, $ref, $username){
        $devoirs = $this->queryAll("SELECT IDDEVOIR, REFMODULE, CONTENUDEVOIR, DATEDEVOIR  FROM DEVOIR NATURAL JOIN ORGANISER_DEVOIR join MODULE using(REFMODULE) WHERE REFMODULE = ? AND LOGINPROF = ?", [$ref, $username]);
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
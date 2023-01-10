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

    public function getAllEtudiants($search = ""){
        $search = "%".$search."%";
        $res = $this->queryAll("SELECT LOGINETU,PRENOMETU,NOMETU,PASSWORD_HASH FROM ETUDIANT WHERE CONCAT(PRENOMETU, ' ', NOMETU) LIKE ?", [$search]);
        return $res;
    }

    public function getAllProfesseurs($search = ""){
        $search = "%".$search."%";
        $res = $this->queryAll("SELECT LOGINPROF,PRENOMPROF,NOMEPROF,PASSWORD_HASH FROM PROFESSEUR WHERE CONCAT(PRENOMPROF, ' ', NOMEPROF) LIKE ?", [$search]);
        return $res;

    }

    public function getModulesProf($loginProf){
        $res = $this->queryAll("SELECT REFMODULE FROM ENSEIGNER WHERE LOGINPROF = ?",[$loginProf]);
        return $res;
    }

    public function createCompte($login,$password,$prenom,$nom,$typeCompte){
        $mdp = password_hash($password, PASSWORD_DEFAULT);
        if($typeCompte == "PROFESSEUR"){
            $this->insertRow("insert into PROFESSEUR values (?,?,?,?)",[$login,$mdp,$prenom,$nom]);
        }
        else if($typeCompte == "ETUDIANT"){
            $this->insertRow("insert into ETUDIANT values (?,?,?,?)",[$login,$mdp,$prenom,$nom]);
        }
    }

    public function getGroupes($semesters){
        $res =  $this->queryAll("SELECT ANNEEGROUPE, INTITULEGROUPE FROM GROUPE
                WHERE INSTR(INTITULEGROUPE,?) != 0 or INSTR(INTITULEGROUPE,?) != 0",$semesters);
        return $res;
    }

    public function createGroupe($intituleGroupe,$anneGroupe){
        $this->insertRow("insert into GROUPE values (?,?)",[$intituleGroupe,$anneGroupe]);
    }
    public function createModule($refModules,$nomModule,$descModules){
        $this->insertRow("insert into MODULE values (?,?,?)",[$refModules,$nomModule,$descModules]);
    }
    public function assignerGroupe($intiuleGroupe,$anneGroupe,$refModule){
        $this->insertRow("insert into PARTICIPER values(?,?,?)",[$intiuleGroupe,$anneGroupe,$refModule]);
    }

    public function assignerProf($loginProf,$refModule){
        $this->insertRow("insert into ENSEIGNER values (?,?)",[$loginProf,$refModule]);
    }

    public function updateStudent($firstName,$lastName,$login){
        $this->updateRow("UPDATE ETUDIANT SET PRENOMETU=?,NOMETU=? WHERE LOGINETU=?",[$firstName,$lastName,$login]);
    }

    public function updateGroup($login,$newGroup){
        $this->updateRow("UPDATE AFFECTER SET INTITULEGROUPE=? WHERE LOGINETU=?",[$newGroup,$login]);
    }

    public function updateTeacher($firstName,$lastName,$login){
        $this->updateRow("UPDATE PROFESSEUR SET PRENOMPROF=?,NOMEPROF=? WHERE LOGINPROF=?",[$firstName,$lastName,$login]);
    }

    public function deleteAccount($login,$typeCompte){
        $res = false;
        if ($typeCompte == "ETUDIANT"){
            $res = $this->updateRow("DELETE from ETUDIANT where LOGINETU = ?",[$login]);
        }
        else if ($typeCompte == "PROFESSEUR"){
            $res = $this->updateRow("DELETE from PROFESSEUR where LOGINPROF = ?",[$login]);
        }
        return $res;
    }

    public function deleteAffectation($login,$typeCompte){
        $res = false;
        if($typeCompte == "ETUDIANT")
            $res = $this->updateRow("DELETE from AFFECTER where LOGINETU = ?",[$login]);
        if($typeCompte == "PROFESSEUR")
            $res = $this->updateRow("DELETE from ENSEIGNER where LOGINPROF = ?",[$login]);
        return $res;
    }

    public function deleteDevoirNote($login,$typeCompte)
    {
        $res = false;
        if ($typeCompte == "ETUDIANT")
            $res = $this->updateRow("DELETE from NOTER where LOGINETU = ?", [$login]);
        if ($typeCompte == "PROFESSEUR")
            $res = $this->updateRow("DELETE from ORGANISER_DEVOIR where LOGINPROF = ?", [$login]);
        return $res;
    }
}
?>
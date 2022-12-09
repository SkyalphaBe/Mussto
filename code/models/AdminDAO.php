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

    public function getAllEtudiants(){
        $res = $this->queryAll("SELECT PRENOMETU,NOMETU FROM ETUDIANT");
        return $res;
    }

    public function getAllProfesseurs(){
        $res = $this->queryAll("SELECT PRENOMPROF, NOMEPROF FROM PROFESSEUR");
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
}
?>
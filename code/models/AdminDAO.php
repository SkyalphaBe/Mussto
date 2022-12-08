<?php
require_once (PATH_MODELS.'UserDAO.php');
class AdminDAO extends UserDAO
{
    public function createProf($login,$password,$prenom,$nom,$typeCompte){
        $mdp = password_hash($password, PASSWORD_DEFAULT);
        if($typeCompte == "PROFESSEUR"){
            $this->insertRow("insert into PROFESSEUR values (?,?,?,?)",[$login,$mdp,$prenom,$nom]);
        }
        else if($typeCompte == "ETUDIANT"){
            $this->insertRow("insert into ETUDIANT values (?,?,?,?)",[$login,$mdp,$prenom,$nom]);
        }
    }
}
?>
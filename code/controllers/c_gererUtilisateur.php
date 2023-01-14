<?php
    if($_SERVER['REQUEST_METHOD'] === "POST" && array_key_exists('login', $_POST)
        && array_key_exists('prenom', $_POST )&& array_key_exists('nom', $_POST)
        && array_key_exists('type', $_POST)){
        require_once (PATH_MODELS.'AdminDAO.php');
        $dao = new AdminDAO(true, $_SESSION['login']);
        if (isset($_POST["create"]) && $_POST["create"]=="créer"){
            $dao->createCompte($_POST["login"],$_POST["mdp"],$_POST["prenom"],$_POST["nom"],$_POST["type"]);
        }
        else{
            if($_POST['type']=='ETUDIANT'){
                $dao->updateStudent($_POST['prenom'],$_POST['nom'],$_POST['login']);
                if(isset($_POST['year'])&&isset($_POST['groups'])){
                    $res= $dao->updateGroup($_POST['login'],$_POST['groups'],$_POST['year']);
                    $listGroups= $dao->getStudentGroups($_POST['login']);
                    $newGroup = ['ANNEEGROUPE' => $_POST['year'],
                    'INTITULEGROUPE' =>$_POST['groups']];

                    if($res->rowCount()==0 && !in_array($newGroup,$listGroups)){
                        $dao->insertAffectation($_POST['login'],$_POST['groups'],$_POST['year']);
                    }
                }
            }
            if($_POST['type']=='PROFESSEUR'){
                $dao->updateTeacher($_POST['prenom'],$_POST['nom'],$_POST['login']);
                if(isset($_POST['affect1'])){
                    $dao->deleteAffectation($_POST['login'],$_POST['type']);
                    for($i=1;$i<sizeof($_POST)-3;$i++){
                        $dao->assignerProf($_POST['login'],$_POST['affect'.$i]);
                    }
                }

            }
        }
    }

require_once (PATH_VIEWS.'gererUtilisateur.php');
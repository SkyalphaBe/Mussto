<?php
    if($_SERVER['REQUEST_METHOD'] === "POST" && array_key_exists('newlogin', $_POST)&& array_key_exists('mdp', $_POST)
        && array_key_exists('prenom', $_POST )&& array_key_exists('nom', $_POST) && array_key_exists('type', $_POST)){
        require_once (PATH_MODELS.'AdminDAO.php');
        $dao = new AdminDAO(true, $_SESSION['login']);
//        if($_POST['type']=='ETUDIANT'){
//            $dao->updateStudent($_POST['newlogin'],$_POST['prenom'],$_POST['nom'],$_POST['mdp']);
//        }
//        if($_POST['type']=='PROFESSEUR'){
//            $dao->updateTeacher($_POST['newlogin'],$_POST['prenom'],$_POST['nom'],$_POST['mdp']);
//            echo "toto";
//        }

    }

require_once (PATH_VIEWS.'gererUtilisateur.php');


?>

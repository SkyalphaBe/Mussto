<?php
    if($_SERVER['REQUEST_METHOD'] === "POST" && array_key_exists('login', $_POST)
        && array_key_exists('prenom', $_POST )&& array_key_exists('nom', $_POST)
        && array_key_exists('type', $_POST)){
        require_once (PATH_MODELS.'AdminDAO.php');
        $dao = new AdminDAO(true, $_SESSION['login']);

        if($_POST['type']=='ETUDIANT'){
            $dao->updateStudent($_POST['prenom'],$_POST['nom'],$_POST['login']);
            $dao->updateGroup($_POST['login'],$_POST['groups']);
            print_r($_POST);
        }
        if($_POST['type']=='PROFESSEUR'){
            $dao->updateTeacher($_POST['prenom'],$_POST['nom'],$_POST['login']);
            $dao->deleteAffectation($_POST['login'],$_POST['type']);
            for($i=1;$i<sizeof($_POST)-3;$i++){
                $dao->assignerProf($_POST['login'],$_POST['module'.$i]);
            }

        }

    }

require_once (PATH_VIEWS.'gererUtilisateur.php');


?>

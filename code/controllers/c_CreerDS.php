<?php
//if ($_SERVER['REQUEST_METHOD'] === "POST" && array_key_exists('sujet', $_POST) && array_key_exists('date', $_POST)
//    && array_key_exists('groupe', $_POST) && array_key_exists('salle', $_POST)){
//    require_once(PATH_MODELS."ProfDAO.php");
//    $dao = new ProfDAO(true,$_SESSION['login']);
//
//    //$dao->insertDS($_POST['groupe'],[$match['param']['ue'],$_POST['sujet'],$_POST['coef'],$_POST['date'],$_POST['salle']]);
//}

    require_once(PATH_MODELS."ProfDAO.php");
    $dao = new ProfDAO(true,$_SESSION['login']);

    $module = $dao->getModule($match['params']['ue']);

    require_once(PATH_VIEWS."CreerDS.php");
?>
<?php
if ($_SERVER['REQUEST_METHOD'] === "POST" && array_key_exists('ressource', $_POST) && array_key_exists('sujet', $_POST) 
    && array_key_exists('date', $_POST) && array_key_exists('groupe', $_POST)){
    require_once(PATH_MODELS."ProfDAO.php");
    $dao = new ProfDAO(true,$_SESSION['login']);

    //$dao->insererNote([$_POST['ressource'],$_POST['sujet'],$_POST['date'],$_POST['groupe']]);
}
    require_once(PATH_VIEWS."CreerDS.php");
?>
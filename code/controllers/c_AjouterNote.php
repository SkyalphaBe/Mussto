<?php
require_once(PATH_MODELS."ProfDAO.php");
require_once(PATH_MODELS."DevoirDAO.php");
$dao = new ProfDAO(true,$_SESSION['login']);
$devoir = DevoirDAO::getDS($match['params']['id'], $_SESSION['login']); //$dao->getDS($match['params']['id']);

if ($devoir){
    $salle_available = $dao->getAllSalle();
    $module = $dao->getModule($devoir->DS['REFMODULE']);
    if ($module){
        $profs_available = $dao->getCollegueForModule($module['REFMODULE']);
        $groups_available = $dao->getGroups($module['REFMODULE']);
    }

    require_once(PATH_VIEWS."AjouterNote.php");
} else {
    http_response_code(404);
    if (isset($router)){
        header('Location: '.$router->generate('home'));
    } else {
        header('Location: ./');
    }
}

?>
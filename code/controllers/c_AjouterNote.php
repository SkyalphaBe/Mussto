<?php
require_once(PATH_MODELS."ProfDAO.php");
$dao = new ProfDAO(true,$_SESSION['login']);

$devoir = $dao->getDS($match['params']['id']);
if ($devoir){
    $salle_available = $dao->getAllSalle();
    $module = $dao->getModule($devoir['REFMODULE']);
    if ($module){
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
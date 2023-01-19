<?php
require_once(PATH_MODELS."DevoirDAO.php");
$devoir = DevoirDAO::getAllInfoDS($match['params']['id'], $_SESSION['login']); //$dao->getDS($match['params']['id']);
if ($devoir){
    require_once(PATH_VIEWS."gererDevoir.php");
} else {
    http_response_code(404);
    if (isset($router)){
        header('Location: '.$router->generate('accueil'));
    } else {
        header('Location: ./');
    }
}
?>
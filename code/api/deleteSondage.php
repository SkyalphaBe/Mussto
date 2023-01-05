<?php
header('Content-Type: text/plain; charset=utf-8');
if (isset($match) && array_key_exists( 'id', $match['params'])){
    require_once(PATH_MODELS."ProfDAO.php");
    $dao = new ProfDAO(true,$_SESSION['login']);
    $sondage = $dao->getSondage($match['params']['id']);
    if ($sondage){
        if ($dao->deleteSondage($match['params']['id'])){
            echo $router->generate("listeDsUe", ['ue' => $sondage['REFMODULE']]);
        } else {
            echo "Erreur de suppresion";
            http_response_code(500);
        }
    } else {
        echo "Sondage introuvable";
        http_response_code(404);
    }
} else {
    http_response_code(400);
}
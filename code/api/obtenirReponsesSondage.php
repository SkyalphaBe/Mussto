<?php
require_once(PATH_MODELS."SondageDAO.php");
if (isset($match) && array_key_exists( 'id', $match['params'])){
    $sondagedao = SondageDAO::getSondage($match['params']['id'], $_SESSION['login']);
    $reponse = $sondagedao->getReponseSondage();
    echo json_encode($reponse);
} else {
    http_response_code(400);
    die();
}

   
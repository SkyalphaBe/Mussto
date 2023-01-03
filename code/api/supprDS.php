<?php
header('Content-Type: text/plain; charset=utf-8');
require_once(PATH_MODELS."DevoirDAO.php");
if (isset($match) && array_key_exists( 'id', $match['params'])){
    $devoir = DevoirDAO::getDS($match['params']['id'], $_SESSION['login']);
    if ($devoir){
        $ue = $devoir->getAllInfo()['REFMODULE'];
        if ($devoir->deleteDS()){
            echo $router->generate("listeDsUe",['ue' => $ue]);
        } else {
            http_response_code(500);
        }
    } else {
        http_response_code(404);
    }
} else {
    http_response_code(400);
}
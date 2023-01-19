<?php
require_once(PATH_MODELS."DevoirDAO.php");
if (isset($match) && array_key_exists( 'id', $match['params'])){
    $devoir = DevoirDAO::getAllInfoDS($match['params']['id'], $_SESSION['login']);
    if ($devoir){
        echo json_encode($devoir);
    } else {
        http_response_code(404);
    }
} else {
    http_response_code(400);
}
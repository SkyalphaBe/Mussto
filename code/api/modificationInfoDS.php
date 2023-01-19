<?php
header('Content-Type: text/plain; charset=utf-8');
require_once(PATH_MODELS."DevoirDAO.php");
//$dao = new ProfDAO(true,$_SESSION['login']);
if (isset($match) && array_key_exists( 'id', $match['params'])){
    $data = json_decode(file_get_contents('php://input'), true);
    if (array_key_exists('content', $data) && array_key_exists('salle', $data) && array_key_exists('date', $data) && array_key_exists('coef', $data) && array_key_exists('groups', $data) && array_key_exists('orga', $data) && is_array($data['groups']) && is_array($data['orga'])){
        $ds = DevoirDAO::getDS($match['params']['id'], $_SESSION['login']);
        if ($ds){
            $res = $ds->updateDevoir($data);
            if ($res){
                http_response_code(200);
            } else {
                http_response_code(500);
            }
        } else {
            http_response_code(400);
        }
    } else {
        http_response_code(400);
    }
} else {    
    http_response_code(404);
}


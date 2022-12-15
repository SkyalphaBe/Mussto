<?php
header('Content-Type: text/plain; charset=utf-8');
require_once(PATH_MODELS."DevoirDAO.php");
if (isset($match) && array_key_exists( 'id', $match['params'])){
    $data = json_decode(file_get_contents('php://input'), true);
    if (is_array($data)){
        foreach($data as $note){
            if (is_array($note) && array_key_exists('loginetu', $note) && array_key_exists('nom', $note) && array_key_exists('prenom', $note) && array_key_exists('comment', $note) && array_key_exists('note', $note) && $note['note']){
                echo (new DevoirDAO(true, $match['params']['id'], $_SESSION['login']))->insertOrUpdateNote($note);
            }
        }
        
    } else {
        http_response_code(400);
    }
} else {
    http_response_code(404);
}


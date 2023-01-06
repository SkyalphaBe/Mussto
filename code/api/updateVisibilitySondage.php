<?php
header('Content-Type: text/plain; charset=utf-8');
if (isset($match) && array_key_exists( 'id', $match['params'])){
    $data = json_decode(file_get_contents('php://input'), true);
    #var_dump($data);
    if (array_key_exists("show", $data)){
        require_once(PATH_MODELS."ProfDAO.php");
        $dao = new ProfDAO(true,$_SESSION['login']);
        $sondage = $dao->getSondage($match['params']['id']);
        if ($sondage){
            if ($dao->changeVisibilitySondage($match['params']['id'], $data['show'])){
                echo "OK";
            } else {
                echo "Erreur de suppresion";
                http_response_code(500);
            }
        } else {
            echo "Sondage introuvable";
            http_response_code(404);
        }
    } else {
        echo "Requete mal formé";
        http_response_code(400);
    }
    
} else {
    http_response_code(400);
}
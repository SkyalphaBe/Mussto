<?php
require_once(PATH_MODELS."ProfDAO.php");
require_once(PATH_MODELS."DevoirDAO.php");
/* $dao = new ProfDAO(true,$_SESSION['login']); */
if (isset($match) && array_key_exists( 'id', $match['params'])){
    $devoir = DevoirDAO::getDS($match['params']['id'], $_SESSION['login']);
    if ($devoir){
        if ((new DateTime(($devoir->getAllInfo())['DATEDEVOIR'])) <= new DateTime()){
            $res = $devoir->getResultsForDS($match['params']['id']);
            echo json_encode($res);
        } else {
            http_response_code(403);
            echo "Le devoir n'est pas passé";
        }
    } else {
        http_response_code(404);
        echo "Le devoir n'est pas accessible";
    }
} else {
    http_response_code(400);
    echo "La requête est mal formé";
    die();
}
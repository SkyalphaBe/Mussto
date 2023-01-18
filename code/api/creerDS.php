<?php
header('Content-Type: text/plain; charset=utf-8');
$data = json_decode(file_get_contents('php://input'), true);
require_once(PATH_MODELS."DevoirDAO.php");
if ($data){
    try {
        $res = DevoirDAO::insertDS($data, $_SESSION['login']);
        if ($res) {
            echo $router->generate("ajouterNote", ['id' => $res]);
        } else {
            http_response_code(500);
        }
    } catch (Exception $e) {
        http_response_code(400);
        echo $e->getMessage();
    }
} else {
    http_response_code(400);
}
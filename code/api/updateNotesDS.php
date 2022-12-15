<?php
header('Content-Type: text/plain; charset=utf-8');
require_once(PATH_MODELS."ProfDAO.php");
$dao = new ProfDAO(true,$_SESSION['login']);
if (isset($match) && array_key_exists( 'id', $match['params'])){
    $data = json_decode(file_get_contents('php://input'), true);
    print_r($data);
}


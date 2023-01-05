<?php
header('Content-Type: text/plain; charset=utf-8');
$data = json_decode(file_get_contents('php://input'), true);
var_dump($data);
if ($data && array_key_exists("module", $data) && $data['module'] && array_key_exists("fields", $data) && is_array($data['fields']) && array_key_exists("title", $data) && $data['title'] && array_key_exists("groups", $data) && is_array($data['groups'])){
    require_once(PATH_MODELS."ProfDAO.php");
    $dao = new ProfDAO(true,$_SESSION['login']);
    $module = $dao->getModule($data['module']);
    if ($module){
        echo $dao->insertSondage($data['module'], $data['title'], json_encode($data['fields']), $data['groups']);
    }
} else {
    http_response_code(400);
}
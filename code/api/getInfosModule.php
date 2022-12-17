<?php
require_once(PATH_MODELS."ProfDAO.php");
$dao = new ProfDAO(true,$_SESSION['login']);
if (isset($match) && array_key_exists( 'ue', $match['params'])){
    $module = $dao->getModule($match['params']['ue']);
    if ($module){
        echo json_encode($module);
    } else {
        echo "id not found";
        http_response_code(404);
    }
}
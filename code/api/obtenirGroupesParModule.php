<?php
require_once(PATH_MODELS."ProfDAO.php");
$dao = new ProfDAO(true,$_SESSION['login']);
if (isset($match) && array_key_exists( 'ue', $match['params'])){
    if ($dao->getModule($match['params']['ue'])){
        echo json_encode($dao->getGroups($match['params']['ue']));
    } else {
        http_response_code(404);
    }
}
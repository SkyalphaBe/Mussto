<?php
require_once(PATH_MODELS."ProfDAO.php");
$dao = new ProfDAO(true,$_SESSION['login']);
if (isset($match) && array_key_exists( 'id', $match['params']) && array_key_exists( 'ue', $match['params'])){
    echo json_encode($dao->getResultsForDS($match['params']['id'], $match['params']['ue']));
} else {
    http_response_code(404);
    die();
}
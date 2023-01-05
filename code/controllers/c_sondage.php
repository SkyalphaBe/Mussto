<?php
require_once(PATH_MODELS."ProfDAO.php");
$dao = new ProfDAO(true, $_SESSION["login"]);
$sondage = $dao->getSondage($match['params']['id']);

if ($sondage){
    
    $result = $dao->getResultSondage($sondage['IDSONDAGE']);
    /* echo "<pre>";
    var_dump($sondage);
    var_dump($result);
    echo "</pre>"; */
    require_once(PATH_VIEWS."sondage.php");
} else {
    http_response_code(404);
    if (isset($router)){
        header('Location: '.$router->generate('home'));
    } else {
        header('Location: ./');
    }
}
?>
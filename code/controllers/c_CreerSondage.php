<?php

    require_once(PATH_MODELS."ProfDAO.php");
    $dao = new ProfDAO(true,$_SESSION['login']);
    $module = $dao->getModule($match['params']['ue']);
    if ($module){
        require_once(PATH_VIEWS."CreerSondage.php");
        
    } else {
        http_response_code(404);
        if (isset($router)){
            header('Location: '.$router->generate('home'));
        } else {
            header('Location: ./');
        }
    }

?>
<?php
    require_once(PATH_MODELS."ProfDAO.php");
    $dao = new ProfDAO(true, $_SESSION["login"]);

    $module = $dao->getModule($match['params']['ue']);
    if ($module){
        $devoirs = $dao->getAllDSForModule($match['params']['ue']);
        
        require_once (PATH_VIEWS."ListeDS.php");
    }  else {
        if (isset($router)){
            header('Location: '.$router->generate('home'));
        } else {
            header('Location: ./');
        }
    }

    
?>
<?php
    require_once(PATH_MODELS."ProfDAO.php");
    require_once(PATH_MODELS."DevoirDAO.php");
    $dao = new ProfDAO(true, $_SESSION["login"]);

    $module = $dao->getModule($match['params']['ue']);
    if ($module){
        $devoirs = AllDevoirDAO::getAllDSForModule($match['params']['ue'], $_SESSION["login"]);
        $sondages = $dao->getAllSondage($module['REFMODULE']);
        
        require_once (PATH_VIEWS."ListeDS.php");
    }  else {
        if (isset($router)){
            header('Location: '.$router->generate('home'));
        } else {
            header('Location: ./');
        }
    }

    
?>
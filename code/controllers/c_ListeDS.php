<?php
    require_once(PATH_MODELS."ProfDAO.php");
    $dao = new ProfDAO(true, $_SESSION["login"]);

    $devoirs = $dao->getDevoirs($match['params']['ue']);
    /*echo '<pre>';
        print_r($devoirs);
    echo '</pre>';*/

    if ($devoirs){
        require_once (PATH_VIEWS."ListeDS.php");
    } else {
        if (isset($router)){
            header('Location: '.$router->generate('home'));
        } else {
            header('Location: ./');
        }
    }
?>
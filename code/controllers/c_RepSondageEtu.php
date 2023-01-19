<?php
if (isset($match) && array_key_exists("id", $match['params'])){

    require_once(PATH_MODELS.'SondageDAO.php');
    $sondage = SondageDAO::getSondage($match['params']['id'], $_SESSION['login']);
    if ($sondage){
        $data = $sondage->getData();

        require_once(PATH_VIEWS.'RepSondageEtu.php');
        
    } else {
         if (isset($router)){
            header('Location: '.$router->generate('accueil'));
        } else {
            header('Location: ./');
        }
    }

} else {
    if (isset($router)){
        header('Location: '.$router->generate('accueil'));
    } else {
        header('Location: ./');
    }
}
?>
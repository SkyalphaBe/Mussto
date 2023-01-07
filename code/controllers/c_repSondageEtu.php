<?php
if (isset($match) && array_key_exists("id", $match['params'])){

    require_once(PATH_MODELS.'SondageDAO.php');
    $sondage = SondageDAO::getSondage($match['params']['id'], $_SESSION['login']);
    if ($sondage){
        $data = $sondage->getData();
        /* echo "<pre>";
        var_dump($data);
        echo "</pre>"; */

        require_once(PATH_VIEWS.'repSondageEtu.php');
        
    } else {
        /* if (isset($router)){
            header('Location: '.$router->generate('home'));
        } else {
            header('Location: ./');
        } */
        var_dump($sondage);
    }

} else {
    if (isset($router)){
        header('Location: '.$router->generate('home'));
    } else {
        header('Location: ./');
    }
}
?>
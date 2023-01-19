<?php

    require_once(PATH_MODELS."ProfDAO.php");
    $dao = new ProfDAO(true,$_SESSION['login']);
    $module = $dao->getModule($match['params']['ue']);
    if ($module){
        require_once(PATH_VIEWS."CreerDS.php");
    } else {
        http_response_code(404);
        if (isset($router)){
            header('Location: '.$router->generate('accueil'));
        } else {
            header('Location: ./');
        }
    }

    /* if ($_SERVER['REQUEST_METHOD'] === "POST" && array_key_exists('sujet', $_POST) && array_key_exists('date', $_POST)
        && array_key_exists('coef', $_POST) && array_key_exists('salle', $_POST)){

        $res = $dao->insertDS([$match['params']['ue'],$_POST['sujet'],$_POST['coef'],$_POST['date'],$_POST['salle'],$_SESSION['login']]);
        print_r([$match['params']['ue'],$_POST['sujet'],$_POST['coef'],$_POST['date'],$_POST['salle'],$_SESSION['login']]);
        if($res)
        {
            header('Location: '.$router->generate('listeDsUe',['ue' => $module['REFMODULE']]));
        }
        else{
            $error = 'erreur lors de la création du DS';
        }
    } */



?>
<?php
if ($_SERVER['REQUEST_METHOD'] === "POST" && array_key_exists('login', $_POST) && array_key_exists('pswd', $_POST)){
    require_once (PATH_MODELS.'LoginDAO.php');
    
    $logDAO = new LoginDAO(true);
    $log = $logDAO->verifyUser($_POST['login'], $_POST['pswd']);
    if ($log){
        $_SESSION['logged'] = $log;
        if ($_SESSION['logged'] === 'etu'){
            require_once (PATH_MODELS.'EtuDAO.php');
            $etu= new EtuDAO(true,$_POST['login']);
            $names=$etu->getNames();
            $_SESSION['firstname'] = $names['PRENOMETU'];
            $_SESSION['lastname'] = $names['NOMETU'];
            
        } else if ($_SESSION['logged'] === 'prof'){
            $prof= new ProfDAO(true,$_POST['login']);
            $names=$prof->getNames();
            $_SESSION['firstname'] = $names['PRENOMETU'];
            $_SESSION['lastname'] = $names['NOMETU'];
        } else if ($_SESSION['logged'] === 'admin'){
            $_SESSION['name']=$_POST['login'];
        }
        
        if (isset($router)){
            header('Location: '.$router->generate('home'));
        } else {
            header('Location: ./');
        }
    } else {
        ##Appel de l'erreur : Authentification a échoué
    }
}
    require_once(PATH_VIEWS.'PageConnexion.php');
?>
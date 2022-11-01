<?php
if ($_SERVER['REQUEST_METHOD'] === "POST" && array_key_exists('login', $_POST) && array_key_exists('pswd', $_POST)){
    require_once (PATH_MODELS.'LoginDAO.php');
    $logDAO = new LoginDAO(true);
    $log = $logDAO->verifyUser($_POST['login'], $_POST['pswd']);
    if ($log){
        $_SESSION['logged'] = $log;
        $_SESSION['name'] = $_POST['login'];
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
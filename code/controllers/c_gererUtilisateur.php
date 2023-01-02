<?php
    if($_SERVER['REQUEST_METHOD'] === "POST" && array_key_exists('login', $_POST)&& array_key_exists('mdp', $_POST)
        && array_key_exists('prenom', $_POST )&& array_key_exists('nom', $_POST) && array_key_exists('type', $_POST)){

        require_once (PATH_MODELS.'AdminDAO.php');
        $dao = new AdminDAO(true, $_SESSION['login']);
        $dao->createCompte($_POST["login"],$_POST["mdp"],$_POST["prenom"],$_POST["nom"],$_POST["type"]);
    }
    require_once (PATH_VIEWS.'gererUtilisateur.php');

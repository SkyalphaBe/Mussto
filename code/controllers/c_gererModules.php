<?php
    if($_SERVER['REQUEST_METHOD'] === "POST" && array_key_exists('refmodule', $_POST)
        && array_key_exists('nommodule', $_POST )&& array_key_exists('description', $_POST)) {
        require_once(PATH_MODELS . 'AdminDAO.php');
        $dao = new AdminDAO(true, $_SESSION['login']);
        if (isset($_POST["create"]) && $_POST["create"] == "créer") {
            $dao->createModule($_POST["refmodule"], $_POST["nommodule"], $_POST["description"]);
        }
    }
    require_once (PATH_VIEWS.'GestionModules.php');
<?php
    if($_SERVER['REQUEST_METHOD'] === "POST" && array_key_exists('intitule', $_POST)
        && array_key_exists('annee', $_POST )) {
        require_once(PATH_MODELS . 'AdminDAO.php');
        $dao = new AdminDAO(true, $_SESSION['login']);
        if (isset($_POST["create"]) && $_POST["create"] == "créer") {
            $dao->createGroupe($_POST["intitule"], $_POST["annee"]);
        }
    }
    require_once (PATH_VIEWS.'GestionGroupes.php');

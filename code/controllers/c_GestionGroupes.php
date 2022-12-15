<?php
    require_once (PATH_MODELS.'AdminDAO.php');
    $dao = new AdminDAO(true,$_SESSION['login']);

    require_once (PATH_VIEWS.'GestionGroupes.php');

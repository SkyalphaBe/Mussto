<?php
    require_once (PATH_MODELS.'AdminDAO.php');
    $dao = new AdminDAO(true,$_SESSION['login']);
    echo json_encode($dao->getAllModules());


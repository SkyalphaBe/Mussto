<?php
    require_once (PATH_MODELS.'AdminDAO.php');
    $dao = new AdminDAO(true,$_SESSION['login']);

    if (isset($match)){
        echo json_encode($dao->getGroupes(['S3','S4']));
    }
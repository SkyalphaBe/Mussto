<?php
    require_once (PATH_MODELS.'AdminDAO.php');
    $dao = new AdminDAO(true,$_SESSION['login']);
    $res['module'] = $dao->getAllModules();

    echo json_encode($res);


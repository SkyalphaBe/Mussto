<?php
    echo '<pre>';
    /*print_r($_SESSION);*/
    require_once(PATH_MODELS.'EtuDAO.php');
    $dao = new EtuDAO(true, $_SESSION['login']);

    /*print_r($_SESSION['login']);
    print_r($dao->getGroups());
    print_r($dao->getModules());
    print_r($dao->getDS());*/

    /*print_r($dao->getNotes($_SESSION['login']));*/

    $devoir_coming = $dao->getDS();
    $other_devoir =$dao->getNotes($_SESSION['login']);

    echo '</pre>';
    require_once(PATH_VIEWS.'AcceuilEtu.php');
?>
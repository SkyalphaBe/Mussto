<?php
    /*echo '<pre>';
    print_r($_SESSION);
    print_r($_SERVER);
    print_r($match);
    echo '</pre>';*/


    require_once(PATH_MODELS.'EtuDAO.php');
    $dao = new EtuDAO(true, $_SESSION['login']);

    $devoir_coming = $dao->getDS();
    $other_devoir = $dao->getNotes();
    $last_devoir = $dao->getLastNotes();

    require_once(PATH_VIEWS.'AcceuilEtu.php');
?>
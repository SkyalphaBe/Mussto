<?php
    /*echo '<pre>';
    print_r($_SESSION);
    echo '</pre>';*/


    require_once(PATH_MODELS.'EtuDAO.php');
    $dao = new EtuDAO(true, $_SESSION['login']);

    $devoir_coming = $dao->getDS();
    $other_devoir = $dao->getNotes();
    $last_devoir = $dao->getLastNotes();

    require_once(PATH_VIEWS.'AcceuilEtu.php');
?>
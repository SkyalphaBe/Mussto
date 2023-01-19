<?php


    require_once(PATH_MODELS.'EtuDAO.php');
    $dao = new EtuDAO(true, $_SESSION['login']);

    $devoir_coming = $dao->getDS();
    $other_devoir = $dao->getNotes();
    
    $other_devoir = array_reverse($other_devoir);
    $last_devoir = array_shift($other_devoir);

    $sondages = $dao->getSondages();

    require_once(PATH_VIEWS.'AccueilEtu.php');
?>
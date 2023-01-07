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
    /* echo "<pre>";
    var_dump($other_devoir);
    echo "</pre>"; */
    $last_devoir = array_shift($other_devoir);

    $sondages = $dao->getSondages();

    require_once(PATH_VIEWS.'AccueilEtu.php');
?>
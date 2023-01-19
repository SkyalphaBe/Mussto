<?php
    require_once(PATH_MODELS.'ProfDAO.php');

    $dao = new ProfDAO(true, $_SESSION['login']);
    $modules = $dao->getModules();
/*
    echo '<pre>';
    print_r($modules = $dao->getModules());
    echo '</pre>';*/
    require_once(PATH_VIEWS.'AccueilProf.php');

?>
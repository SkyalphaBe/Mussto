<?php
    require_once(PATH_MODELS.'EtuDAO.php');
    $dao = new EtuDAO(true, $_SESSION['login']);

    $mes_modules = $dao->getModules();

    require_once(PATH_VIEWS.'ModuleEtu.php');
?>
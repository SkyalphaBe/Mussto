<?php
    require_once(PATH_MODELS.'EtuDAO.php');
    $dao = new EtuDAO(true, $_SESSION['login']);

    $mes_modules = $dao->getModules();
    $mes_notes_dates = array();

    $i = 0;
    foreach($mes_modules as $module){
        $mes_modules[$i]["NOTE"] = $dao->getLastNoteForModule($module["NOMMODULE"])["NOTE"];
        $mes_modules[$i]["DATE"] = $dao->getLastNoteForModule($module["NOMMODULE"])["DATE_ENVOIE"];
        $i += 1;
    }
    

    require_once(PATH_VIEWS.'ModuleEtu.php');
?>
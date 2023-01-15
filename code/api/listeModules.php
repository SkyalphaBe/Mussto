<?php
    require_once (PATH_MODELS.'AdminDAO.php');
    $dao = new AdminDAO(true,$_SESSION['login']);
    $res['module'] = $dao->getAllModules();
    $res['groupe'] = $dao->getAllGroupes();
    $res['affect'] =[];
    for($i=0;$i<sizeof($res['module']);$i++){
        $res['affect'][$res['module'][$i]['REFMODULE']] = $dao->getParticipationModules($res['module'][$i]['REFMODULE']);
    }

    echo json_encode($res);


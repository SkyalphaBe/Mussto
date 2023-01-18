<?php
    header('Content-Type: application/json; charset=utf-8');
    require_once (PATH_MODELS.'AdminDAO.php');
    $data = json_decode(file_get_contents('php://input'), true);
    $response = [
        'code'=> 400
    ];
    $dao = new AdminDAO(true, $_SESSION['login']);
    $cpt = 0;
    foreach ($data as $module){
        if (array_key_exists('refmodule', $module) && array_key_exists('nommodule', $module) && array_key_exists('description', $module)){
            $response["code"] = 200;
            $dao->createModule($module["refmodule"],$module["nommodule"],$module["description"]);
            $cpt++;
        }
        else{
            $response['code'] = 400;
        }
    }
    echo json_encode($response);
    exit(0);

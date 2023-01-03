<?php
    header('Content-Type: text/plain; charset=utf-8');
    require_once (PATH_MODELS.'AdminDAO.php');
    $data = json_decode(file_get_contents('php://input'), true);
    $response = [
        'code'=> 200
    ];
    if (!$data || json_last_error() === JSON_ERROR_NONE){
        $response['code'] = 400;
    }
    if ($response['code']===200){
        $dao = new AdminDAO(true, $_SESSION['login']);
        $cpt = 0;
        foreach ($data as $compte){
            if ($compte["type"]==="ETUDIANT" || $compte["type"]==="PROFESSEUR"){
                $dao->createCompte($compte["login"],$compte["mdp"],$compte["prenom"],$compte["nom"],$compte["type"]);
                $cpt++;
            }
            else{
                $response['code'] = 400;
            }
        }
    }
    echo json_encode($response);
    exit(0);
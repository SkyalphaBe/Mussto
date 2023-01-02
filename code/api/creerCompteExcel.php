<?php
    header('Content-Type: text/plain; charset=utf-8');
    require_once (PATH_MODELS.'AdminDAO.php');
    $data = json_decode(file_get_contents('php://input'), true);
    $response = [
        'code'=> 200
    ];
    if (!$data){
        $response['code'] = 400;
    }
    if ($response['code']===200){
        $dao = new AdminDAO(true, $_SESSION['login']);
        $cpt = 0;
        foreach ($data as $compte){
            $dao->createCompte($compte["login"],$compte["mdp"],$compte["prenom"],$compte["nom"],$compte["type"]);
            $cpt++;
        }
    }
    echo json_encode($response);
    exit(0);
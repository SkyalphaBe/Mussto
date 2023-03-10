<?php
    header('Content-Type: application/json; charset=utf-8');
    require_once (PATH_MODELS.'AdminDAO.php');
    $data = json_decode(file_get_contents('php://input'), true);
    $response = [
        'code'=> 400
    ];
    $dao = new AdminDAO(true, $_SESSION['login']);
    $cpt = 0;
    foreach ($data as $compte){
        if (array_key_exists('login', $compte) && array_key_exists('mdp', $compte) && array_key_exists('prenom', $compte) && array_key_exists('nom', $compte) && array_key_exists('type', $compte)){
            $response["code"] = 200;
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
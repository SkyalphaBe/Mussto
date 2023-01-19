<?php  
    header('Content-Type: text/plain; charset=utf-8');
    require_once(PATH_MODELS."SondageDAO.php");
    if(isset($match) && array_key_exists('id', $match['params'])){
        $data = json_decode(file_get_contents('php://input'), true);
        $sondage = SondageDAO::getSondage($match['params']['id'], $_SESSION['login']);
        if($sondage){        
            if($data){
                $reponse = [];
                foreach((($sondage->getData())['CONTENUSONDAGE']) as $quest){  ///Filtration pour garder uniquement les réponses aux questions
                    if ((array_key_exists($quest['question'], $data))){
                        $reponse[$quest['question']] = $data[$quest['question']];
                    }
                }

                $sondage->InsertOrUpdateReponse(json_encode($reponse));
            } else {
                http_response_code(400);
            }
        } else {
            http_response_code(404);
        }
    } else {
        http_response_code(404);
    }
<?php  
    header('Content-Type: text/plain; charset=utf-8');
    require_once(PATH_MODELS."SondageDAO.php");
    if(isset($match) && array_key_exists('id', $match['params'])){
        $data = json_decode(file_get_contents('php://input'), true);
        if(is_array($data) && array_key_exists('msg', $data)){
            $sondage = SondageDAO::getSondage($match['params']['id'], $_SESSION['login']);
            if($sondage){        
                $sondage->InsertOrUpdateReponseSondage($data['msg']);
            } else {
                http_response_code(404);
            }
        } else {
            http_response_code(400);
        }
    } else {
        http_response_code(404);
    }
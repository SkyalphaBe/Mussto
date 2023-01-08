<?php
    header('Content-Type: application/json; charset=utf-8');
    require_once (PATH_MODELS.'AdminDAO.php');
    $data = json_decode(file_get_contents('php://input'), true);
    $response['code']=400;
    $dao = new AdminDAO(true, $_SESSION['login']);
    $res = $dao ->deleteRow("DELETE FROM AFFECTER WHERE INTITULEGROUPE = ? AND ANNEEGROUPE = ?",[$data[0],$data[1]]);
    if($res){
        $res = $dao ->deleteRow("DELETE FROM PARTICIPER WHERE INTITULEGROUPE = ? AND ANNEEGROUPE = ?",[$data[0],$data[1]]);
        if($res){
            $res = $dao->deleteRow("DELETE FROM EVALUER WHERE INTITULEGROUPE = ? AND ANNEEGROUPE = ?", [$data[0], $data[1]]);
            if ($res){
                $res = $dao->deleteRow("DELETE FROM RECEVOIR WHERE INTITULEGROUPE = ? AND ANNEEGROUPE = ?", [$data[0], $data[1]]);
                if ($res) {
                    $res = $dao->deleteRow("DELETE FROM GROUPE WHERE INTITULEGROUPE = ? AND ANNEEGROUPE = ?", [$data[0], $data[1]]);
                    if ($res)
                        $response['code'] = 200;
                }
            }
        }
    }
    echo json_encode($response);
    exit(0);
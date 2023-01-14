<?php
header('Content-Type: application/json; charset=utf-8');
require_once (PATH_MODELS.'AdminDAO.php');
$data = json_decode(file_get_contents('php://input'), true);
$response['code']=400;
$dao = new AdminDAO(true, $_SESSION['login']);
$res = $dao ->deleteRow("DELETE FROM PARTICIPER WHERE REFMODULE = ?",[$data[0]]);
if($res){
    $res = $dao ->deleteRow("DELETE FROM ENSEIGNER WHERE REFMODULE = ?",[$data[0]]);
    if($res){
        $res = $dao->deleteRow("DELETE FROM DEVOIR WHERE REFMODULE = ?", [$data[0]]);
        if ($res){
            $res = $dao->deleteRow("DELETE FROM SONDAGE WHERE REFMODULE = ?", [$data[0]]);
            if ($res) {
                $res = $dao->deleteRow("DELETE FROM MODULE WHERE REFMODULE = ?", [$data[0]]);
                if ($res)
                    $response['code'] = 200;
            }
        }
    }
}
echo json_encode($response);
exit(0);
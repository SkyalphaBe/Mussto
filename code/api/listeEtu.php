<?php
    require_once (PATH_MODELS.'AdminDAO.php');

    $search = "";
    if (array_key_exists("query", $_GET)){
        $search = $_GET['query'];
    }

    $dao = new AdminDAO(true,$_SESSION['login']);
    $res['user']=$dao->getAllEtudiants($search);
    $res['groups'] = $dao->getAllGroupes();
    echo json_encode($res);
?>



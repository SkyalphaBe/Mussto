<?php
    require_once (PATH_MODELS.'AdminDAO.php');
    $dao = new AdminDAO(true,$_SESSION['login']);
    $data['user']=$dao->getAllEtudiants();
    $data['groups'] = $dao->getAllGroupes();
    echo json_encode($data);
?>



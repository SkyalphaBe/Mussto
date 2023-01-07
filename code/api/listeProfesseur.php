<?php
require_once (PATH_MODELS.'AdminDAO.php');
$dao = new AdminDAO(true,$_SESSION['login']);
$data['user']=$dao->getAllProfesseurs();
$data['module'] = $dao->getAllModules();
echo json_encode($data);
?>
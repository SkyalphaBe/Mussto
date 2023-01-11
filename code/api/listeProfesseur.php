<?php
$search = "";
if (array_key_exists("query", $_GET)){
    $search = $_GET['query'];
}

require_once (PATH_MODELS.'AdminDAO.php');
$dao = new AdminDAO(true,$_SESSION['login']);
$data['user']=$dao->getAllProfesseurs($search);
$data['module'] = $dao->getAllModules();
$data['assign'] = [];
for($i=0;$i<sizeof($data['user']);$i++){
    $data['assigns'][$data['user'][$i]['LOGINPROF']] = $dao->getModulesProf($data['user'][$i]['LOGINPROF']);
}

echo json_encode($data);
?>
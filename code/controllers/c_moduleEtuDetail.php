
<?php

//print_r($match['params']['ue']);
require_once(PATH_MODELS.'EtuDAO.php');
$dao = new EtuDAO(true, $_SESSION['login']);

$module = $dao->getModule($match['params']['ue']);

$enseignants = $dao->getProfsForModule($module['REFMODULE']);
$notes = $dao->getNotesForModule($module['REFMODULE']);
/* 
echo '<pre>';
var_dump($notes);
echo '</pre>'; */

$devoirs = $dao->getDSForModule($module['REFMODULE']);
$avg = $dao->getAverageForModule($module['REFMODULE']);

if ($module){
    require_once (PATH_VIEWS."ModuleEtuDetail.php");
} else {
    if (isset($router)){
        header('Location: '.$router->generate('module'));
    } else {
        header('Location: ./');
    }
}

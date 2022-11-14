
<?php

echo '<pre>';
//print_r($match['params']['ue']);
require_once(PATH_MODELS.'EtuDAO.php');
$dao = new EtuDAO(true, $_SESSION['login']);

$module = $dao->getModule($match['params']['ue']);


echo '</pre>';


if ($module){
    require_once (PATH_VIEWS."ModuleEtuDetail.php");
} else {
    if (isset($router)){
        header('Location: '.$router->generate('module'));
    } else {
        header('Location: ./');
    }
}

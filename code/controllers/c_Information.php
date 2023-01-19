<?php

require_once(PATH_MODELS."UserDAO.php");
$dao = new UserDAO(false, $_SESSION['login']);
header('Content-Description: File Transfer');
header('Content-Disposition: attachment; filename=info.txt');
header('Expires: 0');
header('Cache-Control: must-revalidate');
header('Pragma: public');
header("Content-Type: text/plain"); 

print_r($dao->getAllInfo())

?>
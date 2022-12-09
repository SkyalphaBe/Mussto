<?php
    require_once(PATH_MODELS.'AdminDAO.php');

    $dao = new AdminDAO(true, $_SESSION['login']);

    /*$testP = $dao->createCompte("bensligoat","1234","djamal","benslimane","PROFESSEUR");
    $testE =$dao->createCompte("Basti","1234","Bastien","Puscedo","ETUDIANT");*/
    require_once(PATH_VIEWS.'AccueilAdmin.php');
?>
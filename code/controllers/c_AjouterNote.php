<?php
//if ($_SERVER['REQUEST_METHOD'] === "POST" && array_key_exists('etudiant', $_POST)
//&& array_key_exists('note', $_POST) && array_key_exists('commentaire', $_POST)){
//    require_once(PATH_MODELS."ProfDAO.php");
//    $dao = new ProfDAO(true,$_SESSION['login']);
//
//    $idDevoir = $dao -> getDevoir($_POST['sujet']);
//
//    $res = $dao->insertNote($_POST['etudiant'],$idDevoir,$_POST['note'],$_POST['commentaire']);
//
//}
    require_once(PATH_VIEWS."AjouterNote.php");
?>
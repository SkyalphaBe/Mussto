<?php
    if($_SERVER['REQUEST_METHOD'] === "POST" && array_key_exists('refmodule', $_POST)
        && array_key_exists('nommodule', $_POST )&& array_key_exists('description', $_POST)) {
        require_once(PATH_MODELS . 'AdminDAO.php');
        $dao = new AdminDAO(true, $_SESSION['login']);
        if (isset($_POST["create"]) && $_POST["create"] == "créer") {
            $dao->createModule($_POST["refmodule"], $_POST["nommodule"], $_POST["description"]);
        }
        elseif (isset($_POST["modif"]) && $_POST["modif"] == "modifier"){
            $dao->updateModule($_POST['refmodule'],$_POST['nommodule'],$_POST['description']);
            if(isset($_POST['affect1'])){
                $dao->deleteParticipation($_POST['refmodule']);
                for($i=1;$i<sizeof($_POST)-3;$i++){
                    $group=explode("-",$_POST['affect'.$i]);
                    $dao->assignerGroupe($group[0],$group[1],$_POST['refmodule']);
                }
            }
        }
    }
    require_once (PATH_VIEWS.'GererModules.php');
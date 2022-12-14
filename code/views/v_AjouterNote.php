<?php
//Tableau des fichiers CSS nécessaire
$style = ["sideBarre.css", "main.css", "ajouterNote.css"];

//Appel de l'header
require_once(PATH_VIEW_COMPONENT.'header.php');

//Appel du composant SideBarre
//Définition du contenu de la sideBar

require_once(PATH_VIEW_COMPONENT.'sideBarre.php');

?>
<script src="/assets/scripts/gestionnotes.js"></script>

<div style="background-color: <?=CSScolorByName($module['NOMMODULE'])?>" class="ajoutNote" id="ajoutNote">
    <div id="title">
        <h1><?= $module['NOMMODULE']?> : Ajouter une Note</h1>
        <div class="buttonTopBox">
            <a class="buttonFormFile" href="<?=$router->generate('download')?>">Télécharger l'Excel</a>
            <a class="buttonFormFile" href="<?=$router->generate('listeDsUe',['ue' => $module['REFMODULE']])?>">Retour</a>
        </div>

    </div>
    <script>
        notes(<?=$match['params']['id']?> ,"ajoutNote");
    </script>


    <!-- <form method="post">
        <div class="formContent">
            <label id="labelfile" for="file">Déposer un fichier :</label>
            <input id="file" type="file" name="file" accept="xls" class="form-control">
        </div>
        <input type="submit" value="Valider" id="valideButton">
    </form> -->


</div>

<?php 
    //Appel du footer
    require_once(PATH_VIEW_COMPONENT.'footer.php');
?>
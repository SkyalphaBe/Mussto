<?php
//Tableau des fichiers CSS nécessaire
$style = ["sideBarre.css", "main.css", "ajouterNote.css"];

//Appel de l'header
require_once(PATH_VIEW_COMPONENT.'header.php');

//Appel du composant SideBarre
//Définition du contenu de la sideBar

require_once(PATH_VIEW_COMPONENT.'sideBarre.php');
?>

<section style="background-color: <?=CSScolorByName($module['NOMMODULE'])?>" class="ajoutNote">
    <h1><?= $module['NOMMODULE']?> : Ajouter une Note</h1>
    <a id="download" href="<?=$router->generate('download')?>">Télécharger l'Excel</a>
    <form method="post">
        <label for="file">Choisir fichier :</label>
        <input id="file" type="file" name="file" accept="xls" class="form-control">
        <input type="submit" value="Valider" id="valideButton">
    </form>
</section>

<?php 
    //Appel du footer
    require_once(PATH_VIEW_COMPONENT.'footer.php');
?>
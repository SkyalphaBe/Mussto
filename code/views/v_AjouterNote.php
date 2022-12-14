<?php
//Tableau des fichiers CSS nécessaire
$style = ["sideBarre.css", "main.css", "ajouterNote.css"];

//Appel de l'header
require_once(PATH_VIEW_COMPONENT.'header.php');

//Appel du composant SideBarre
//Définition du contenu de la sideBar

require_once(PATH_VIEW_COMPONENT.'sideBarre.php');

?>
<script> 
const ref = "<?=$module['REFMODULE']?>";
const id = "<?=$match['params']['id']?>";
</script>
<script src="/assets/scripts/gestionnotes.js" defer></script>

<div style="background-color: <?=CSScolorByName($module['NOMMODULE'])?>" class="ajoutNote">
    <div id="title">
        <h1><?= $module['NOMMODULE']?> : Ajouter une Note</h1>
        <div class="buttonTopBox">
            <a class="buttonFormFile" href="<?=$router->generate('download')?>">Télécharger l'Excel</a>
            <a class="buttonFormFile" href="<?=$router->generate('listeDsUe',['ue' => $module['REFMODULE']])?>">Retour</a>
        </div>

    </div>
    
    <div id="ajout-note-table"></div>
</div>

<?php 
    //Appel du footer
    require_once(PATH_VIEW_COMPONENT.'footer.php');
?>
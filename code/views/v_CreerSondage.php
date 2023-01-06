<?php
//Tableau des fichiers CSS nécessaire
$style = ["sideBarre.css", "main.css", "creerDS.css", "selecteur.css", "loader.css", "creerSondage.css"];

//Appel de l'header
require_once(PATH_VIEW_COMPONENT.'header.php');

//Appel du composant SideBarre
//Définition du contenu de la sideBar

require_once(PATH_VIEW_COMPONENT.'sideBarre.php');
?>

<script>
    const id = "<?=$module['REFMODULE']?>"
</script>
<script type="module" src="/assets/scripts/sondage/creer_sondage.js"></script>

<div style="background-color: <?=CSScolorByName($module['REFMODULE'])?>" id="sondage">
    <div class="header">
        <h1><?=$module['NOMMODULE']?> : Creation sondage</h1>
        <a class="button" href="<?=$router->generate("listeDsUe", ['ue' => $module['REFMODULE']])?>">Retour</a>
    </div>
    <div id="creer-sondage">

    </div>
</div>

<?php 
    //Appel du footer
    require_once(PATH_VIEW_COMPONENT.'footer.php');
?>


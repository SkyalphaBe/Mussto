<?php
//Tableau des fichiers CSS nécessaire
$style = ["sideBarre.css", "main.css", "creerDS.css"];

//Appel de l'header
require_once(PATH_VIEW_COMPONENT.'header.php');

//Appel du composant SideBarre
//Définition du contenu de la sideBar

require_once(PATH_VIEW_COMPONENT.'sideBarre.php');
?>
<script>
    const id = "<?=$module['REFMODULE']?>"
</script>
<script type="module" src="/assets/scripts/creer_devoir/creer_devoir.js"></script>

<div style="background-color: <?=CSScolorByName($module['REFMODULE'])?>" id="creer-devoir"></div>

<?php 
    //Appel du footer
    require_once(PATH_VIEW_COMPONENT.'footer.php');
?>


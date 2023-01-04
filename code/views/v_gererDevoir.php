<?php
//Tableau des fichiers CSS nécessaire
$style = ["sideBarre.css", "main.css", "ajouterNote.css", "selecteur.css", "formulaire_info_devoir.css"];

//Appel de l'header
require_once(PATH_VIEW_COMPONENT.'header.php');

//Appel du composant SideBarre
require_once(PATH_VIEW_COMPONENT.'sideBarre.php');

?>
<script>
    const devoir = <?=json_encode($devoir)?>;
</script>
<script  type="module" src="/assets/scripts/gestion_devoir/gestion_devoir.js"></script>

<div style="background-color: <?=CSScolorByName($devoir['REFMODULE'])?>" class="ajoutNote">
    <div id="title">
        <h1>Gérer le devoir</h1>
        <a class="button" href="<?=$router->generate("listeDsUe", ['ue' => $devoir['REFMODULE']])?>">Retour</a>
    </div>
    <div class="devoir-info">
        <h2>Information sur le devoir</h2>
        <div id="form-info-devoir"></div>
    </div>

    <div>
        <h2>Résultats du devoir</h2>
        <div id="result-devoir"></div>
    </div>
</div>

<?php 
    //Appel du footer
    require_once(PATH_VIEW_COMPONENT.'footer.php');
?>
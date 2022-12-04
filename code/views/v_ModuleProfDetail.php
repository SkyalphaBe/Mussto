<?php
//Tableau des fichiers CSS nécessaire
$style = ["main.css", "sideBarre.css", "moduleProf.css"];

//Appel de l'header
require_once(PATH_VIEW_COMPONENT.'header.php');

//Appel du composant SideBarre

require_once(PATH_VIEW_COMPONENT.'sideBarre.php');
?>
<div style="background-color: <?=CSScolorByName($module['NOMMODULE'])?>" class="module-detail">
    <div class="top">
        <h1><?=$module['NOMMODULE']?></h1>
        <a class="button" href="<?=$router->generate('home')?>">Retour à la liste des modules</a>
    </div>
    <div class="bottom">
        <a class="button" href="<?=$router->generate('CreerDSProf', ['ue' => $module['REFMODULE']])?>">Créer un DS</a>
        <a class="button" href="<?=$router->generate('home')?>">Liste des DS</a>
        <a class="button" href="<?=$router->generate('home')?>">Entrer une note</a>
    </div>
</div>


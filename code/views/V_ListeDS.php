<?php

//Tableau des fichiers CSS nécessaire
$style = ["main.css", "sideBarre.css", "moduleProf.css"];

//Appel de l'header
require_once(PATH_VIEW_COMPONENT.'header.php');

//Appel du composant SideBarre

require_once(PATH_VIEW_COMPONENT.'sideBarre.php');

?>
<?php
    if (isset($devoirs)&& $devoirs){
        for ($i = 0;$i<count($devoirs);$i++){?>
            <div style="background-color: <?=CSScolorByName($devoirs[$i]['NOMMODULE'])?>" class="devoirModule">
        <?php } $nbDevoir = 0 ;?>
        <?php foreach ($devoirs as $allDevoirs){$nbDevoir++?>
                <div class="devoir">
                    <h2 class="devoirProf-nb">DS : <?=$nbDevoir?></h2>
                    <p class="devoirProf-titre"><?=$allDevoirs['CONTENUDEVOIR']?></p>
                    <p class="devoirProf-nom"><?=$allDevoirs['REFMODULE']?></p>
                    <p class="devoirProf-group">Groupe : <?=$allDevoirs['INTITULEGROUPE']?></p>
                    <p class="devoirProf-date">Date : <?=$allDevoirs['DATEDEVOIR']?></p>
                    <a class="button" href="">Ajouter notes</a>
                </div>
        <?php } } else { ?>
        <p>Aucune DS pour le moment</p>
    <?php } ?>
                <a class="button" href="<?=$router->generate("moduleDetail", ['ue' => $devoirs[0]['REFMODULE']])?>">Retour</a>
         </div>
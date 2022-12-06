<?php

    //Tableau des fichiers CSS nécessaire
    $style = ["main.css", "sideBarre.css","listeDS.css"];

    //Appel de l'header
    require_once(PATH_VIEW_COMPONENT.'header.php');

    //Appel du composant SideBarre

    require_once(PATH_VIEW_COMPONENT.'sideBarre.php');
    $nbDevoir = 0;
?>
    <?php if (isset($devoirs)&& $devoirs){?>
        <div style="background-color: <?=CSScolorByName($devoirs[0]['NOMMODULE'])?>" class="devoirModuleProf">
            <div class="topBoxProf">
                <h1 class="moduleProfTitle"><?=$devoirs[0]['NOMMODULE']?></h1>
                <a class="button" href="<?=$router->generate("moduleDetail", ['ue' => $devoirs[0]['REFMODULE']])?>">Retour</a>
            </div>
        <?php foreach ($devoirs as $allDevoirs){$nbDevoir++?>
                <div class="devoirProf">
                    <h2 class="devoirProf-nb">DS : <?=$nbDevoir?></h2>
                    <p class="devoirProf-titre"><?=$allDevoirs['CONTENUDEVOIR']?></p>
                    <p class="devoirProf-group">Groupe : <?=$allDevoirs['INTITULEGROUPE']?></p>
                    <p class="devoirProf-date">Date : <?=$allDevoirs['DATEDEVOIR']?></p>
                    <a class="button" href="<?=$router->generate("AjouterNote", ['ue' => $devoirs[0]['REFMODULE']])?>" style="background-color: <?=CSScolorByName($devoirs[0]['NOMMODULE'])?>">Ajouter notes</a>
                </div>
        <?php } } else { ?>
        <p>Aucune DS pour le moment</p>
    <?php } ?>
         </div>

<?php
require_once (PATH_VIEW_COMPONENT.'footer.php');
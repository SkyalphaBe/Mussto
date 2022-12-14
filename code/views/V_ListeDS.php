<?php

    //Tableau des fichiers CSS nécessaire
    $style = ["main.css", "sideBarre.css","listeDS.css"];

    //Appel de l'header
    require_once(PATH_VIEW_COMPONENT.'header.php');

    //Appel du composant SideBarre

    require_once(PATH_VIEW_COMPONENT.'sideBarre.php');
    $nbDevoir = 0;
?>
    
    <div style="background-color: <?=CSScolorByName($devoirs[0]['NOMMODULE'])?>" class="devoirModuleProf">
        <div class="topBoxProf">
            <h1 class="moduleProfTitle"><?=$module['NOMMODULE']?></h1>
            <a class="button" href="<?=$router->generate("CreerDSProf", ['ue' => $devoirs[0]['REFMODULE']])?>">Créer un DS</a>
            <a class="button" href="<?=$router->generate("home")?>">Retour</a>
        </div>
    <?php if (isset($devoirs)&& $devoirs){?>
        <?php foreach ($devoirs as $devoir){$nbDevoir++?>
                <div class="devoirProf">
                    <p class="devoirProf-titre"><?=$devoir['CONTENUDEVOIR']?></p>
                    <p class="devoirProf-group">Groupe : <?=$devoir['INTITULEGROUPE']?></p>
                    <p class="devoirProf-date">Date : <?=$devoir['DATEDEVOIR']?></p>
                    <a class="button" href="<?=$router->generate("AjouterNote", ['ue' => $match['params']['ue'], 'id' => $devoir['IDDEVOIR']])?>" style="background-color: <?=CSScolorByName($devoirs[0]['NOMMODULE'])?>">Ajouter notes</a>
                </div>
        <?php } } else { ?>
        <p>Aucune DS pour le moment</p>
    <?php } ?>
    </div>

<?php
require_once (PATH_VIEW_COMPONENT.'footer.php');
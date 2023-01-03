<?php
    //Tableau des fichiers CSS nécessaire
    $style = ["main.css", "sideBarre.css","listeDS.css"];

    //Appel de l'header
    require_once(PATH_VIEW_COMPONENT.'header.php');

    //Appel du composant SideBarre
    require_once(PATH_VIEW_COMPONENT.'sideBarre.php');
    $nbDevoir = 0;
?>
    
    <div style="background-color: <?=CSScolorByName($module['REFMODULE'])?>" class="devoirModuleProf">
        <div class="topBoxProf">
            <h1 class="moduleProfTitle"><?=$module['NOMMODULE']?></h1>
            <a class="button" href="<?=$router->generate("CreerDSProf", ['ue' => $devoirs[0]['REFMODULE']])?>">Créer un DS</a>
            <a class="button" href="<?=$router->generate("home")?>">Retour</a>
        </div>
    <?php if (isset($devoirs)&& $devoirs){?>
        <?php foreach ($devoirs as $devoir){$nbDevoir++?>
                <div class="devoirProf">
                    <p class="devoirProf-titre"><?=$devoir['CONTENUDEVOIR']?></p>
                    <p class="devoirProf-group">Groupe : <?php foreach($devoir['GROUPES'] as $grp){ echo $grp." "; }?></p>
                    <p class="devoirProf-date">Date : <?=$devoir['DATEDEVOIR']?></p>
                    <a class="button" href="<?=$router->generate("AjouterNote", ['id' => $devoir['IDDEVOIR']])?>" style="background-color: <?=CSScolorByName($module['REFMODULE'])?>">Gérer</a>
                </div>
        <?php } } else { ?>
        <p>Aucune DS pour le moment</p>
    <?php } ?>
    </div>

<?php
require_once (PATH_VIEW_COMPONENT.'footer.php');
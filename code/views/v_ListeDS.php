<?php
    //Tableau des fichiers CSS nécessaire
    $style = ["main.css", "sideBarre.css","listeDS.css"];

    //Appel de l'header
    require_once(PATH_VIEW_COMPONENT.'header.php');

    //Appel du composant SideBarre
    require_once(PATH_VIEW_COMPONENT.'sideBarre.php');
    $nbDevoir = 0;
?>
    
    <div style="--color: <?=DegreeColorByName($module['REFMODULE'])?>" class="devoirModuleProf">
        <div class="topBoxProf">
            <h1 class="moduleProfTitle"><?=$module['NOMMODULE']?></h1>
            <a class="button" href="<?=$router->generate("home")?>">Retour</a>
        </div>
        <div class="devoir-div section">
            <div class="topBoxProf">
                <h2>Devoirs</h2>
                <a class="button" href="<?=$router->generate("CreerDSProf", ['ue' => $module['REFMODULE']])?>">Créer un DS</a>
            </div>
            <div class="devoir-list list">
                <?php if (isset($devoirs)&& $devoirs){?>
                    <?php foreach ($devoirs as $devoir){$nbDevoir++?>
                            <div class="devoirProf">
                                <p class="devoirProf-titre"><?=$devoir['CONTENUDEVOIR']?></p>
                                <p class="devoirProf-group">Groupe : <?php foreach($devoir['GROUPES'] as $grp){ echo $grp." "; }?></p>
                                <p class="devoirProf-date">Date : <?=$devoir['DATEDEVOIR']?></p>
                                <a class="button" href="<?=$router->generate("AjouterNote", ['id' => $devoir['IDDEVOIR']])?>">Gérer</a>
                            </div>
                    <?php } } else { ?>
                    <p>Aucun devoir pour le moment</p>
                    
                <?php } ?>
            </div>
        </div>
        <div class="sondage-div section">
            <div class="topBoxProf">
                <h2>Sondages</h2>
                <a class="button" href="<?=$router->generate("CreerSondage", ['ue' => $module['REFMODULE']])?>">Créer un sondage</a>
            </div>
            <div class="sondage-list list">
                <?php if (isset($sondages)&& $sondages){?>
                    <?php foreach ($sondages as $sondage){?>
                            <div class="devoirProf">
                                <p class="sondage-titre"><?=$sondage['TITLESONDAGE']?></p>
                                <p class="sondage-date">Date : <?=$sondage['DATESONDAGE']?></p>
                                <a class="button" href="<?=$router->generate("sondage", ['id' => $sondage['IDSONDAGE']])?>">Gérer</a>
                            </div>
                    <?php } } else { ?>
                    <p>Aucun sondage pour le moment</p>
                    
                <?php } ?>
            </div>
        </div>
    </div>

<?php
require_once (PATH_VIEW_COMPONENT.'footer.php');
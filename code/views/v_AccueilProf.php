<?php
//Tableau des fichiers CSS nécessaire
$style = ["main.css", "sideBarre.css","accueilProf.css"];

//Appel de l'header
require_once(PATH_VIEW_COMPONENT.'header.php');


//Appel du composant SideBarre

require_once(PATH_VIEW_COMPONENT.'sideBarre.php');
?>
<h1>Mes modules enseignés</h1>
<div id="modules">
<?php
    if(isset($modules) && $modules){
        foreach ($modules as $allmodules){?>
            <a  href="<?=$router->generate("listeDsUe", ['ue' => $allmodules['REFMODULE']])?>" style="--color: <?=DegreeColorByName($allmodules['REFMODULE'])?>" class="modulesP">
                <h2 class="modulesP-titre"><?=$allmodules['NOMMODULE']?></h2>
                <div class="modulesP-classe">
                    <h3>Groupes : </h3>
                    <div class="groups">
                        <?php
                        if(isset($allmodules['GROUPS']) !=0 ){
                        foreach ($allmodules['GROUPS'] as $allgroups){?>
                            <p><?=$allgroups?></p>
                        <?php } }else{ ?>
                            <p>None</p>
                        <?php }?>
                    </div>
                </div>
            </a>
        <?php } } else { ?>
        <p>Aucune modules pour le moment</p>
    <?php } ?>
</div>

<?php
//Appel du footer
require_once(PATH_VIEW_COMPONENT.'footer.php');
?>

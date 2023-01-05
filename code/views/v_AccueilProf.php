<?php
//Tableau des fichiers CSS nécessaire
$style = ["main.css", "sideBarre.css","accueilProf.css"];

//Appel de l'header
require_once(PATH_VIEW_COMPONENT.'header.php');


//Appel du composant SideBarre

require_once(PATH_VIEW_COMPONENT.'sideBarre.php');
?>
<?php
    if(isset($modules) && $modules){
        foreach ($modules as $allmodules){?>
            <div style="background-color: <?=CSScolorByName($allmodules['REFMODULE'])?>" class="modulesP">
                <h2 class="modulesP-titre"><?=$allmodules['NOMMODULE']?></h2>
                <div class="modulesP-classe">
                    <h3>Classe : </h3>
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
                <a href="<?=$router->generate("listeDsUe", ['ue' => $allmodules['REFMODULE']])?>" class="modulesP-detail">detail</a>
            </div>
        <?php } } else { ?>
        <p>Aucune modules pour le moment</p>
    <?php } ?>
<?php
//Appel du footer
require_once(PATH_VIEW_COMPONENT.'footer.php');
?>

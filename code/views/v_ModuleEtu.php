<?php 
//Tableau des fichiers CSS nécessaire
$style = ["sideBarre.css", "main.css", "module.css"];

//Appel de l'header
require_once(PATH_VIEW_COMPONENT.'header.php');

//Appel du composant SideBarre
require_once(PATH_VIEW_COMPONENT.'sideBarre.php');


require_once(PATH_MODELS.'EtuDAO.php');

/* echo '<pre>';
print_r($dao->getModules());
echo '</pre>'; */

?>

<div class="modules">
    <?php 
    if (isset($mes_modules) && $mes_modules){
        foreach($mes_modules as $module){
        ?>
        <div class="module" style="background-color : <?=CSScolorByName($module['NOMMODULE'])?>">
            <h1> <?= $module['NOMMODULE'] ?></h1>
            <p>Dernière note : </p>
            <h1><?= $module['NOTE'] ?> / 20</h1>
            <p>Date : <?= $module['DATE'] ?></p>
            <a class="button" href="<?=$router->generate("moduleDetail", ['ue' => $module['REFMODULE']])?>"> Détails du module</a>
        </div><?php 
        }
    }?>
</div>

<?php
//Appel du footer
require_once(PATH_VIEW_COMPONENT.'footer.php');
?>


    

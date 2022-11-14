<?php 
//Tableau des fichiers CSS nécessaire
$style = ["sideBarre.css", "main.css", "moduleEtu.css"];

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
        for($i=0;$i<3;$i++){
            foreach($mes_modules as $module){
            ?>
            <div class="module">
                <h1> <?= $module['NOMMODULE'] ?></h1>
                <p>Dernière note : </p>
                <h1><?= $module['NOTE'] ?></h1>
                <p>Date : <?= $module['DATE'] ?></p>
                <button> Détails du module</button>
            </div><?php 
            }
            
        
        }  
    }?>
</div>

<?php
//Appel du footer
require_once(PATH_VIEW_COMPONENT.'footer.php');
?>


    

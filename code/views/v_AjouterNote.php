<?php
//Tableau des fichiers CSS nécessaire
$style = ["sideBarre.css", "main.css", "ajouterNote.css"];

//Appel de l'header
require_once(PATH_VIEW_COMPONENT.'header.php');

//Appel du composant SideBarre
require_once(PATH_VIEW_COMPONENT.'sideBarre.php');

?>
<script> 
const ref = "<?=$module['REFMODULE']?>";
const id = "<?=$match['params']['id']?>";
</script>
<script src="/assets/scripts/gestion_devoir.js"></script>

<div style="background-color: <?=CSScolorByName($module['NOMMODULE'])?>" class="ajoutNote">
    <div id="title">
        <h1><?= $module['NOMMODULE']?> : Gérer le devoir</h1>
        <a class="buttonFormFile" href="<?=$router->generate('listeDsUe',['ue' => $module['REFMODULE']])?>">Retour</a>
    </div>
    <div class="devoir-info">
        <h2>Information sur le devoir</h2>
        <div class="devoir-salle">
            <label for="salle-select">Salle : </label>
            <select class="devoir-info-input" name="salle" id="salle-select">
                <?php if ($salle_available){
                    foreach ($salle_available as $salle){
                        if ($salle === $devoir['SALLE']){
                            echo "<option selected value=".$salle.">".$salle."</option>";
                        } else {
                            echo "<option value=".$salle.">".$salle."</option>";
                        }
                    }
                }?>
            </select>
        </div>
        <div class="devoir-date">
            <label for="devoir-date-input">Date : </label> 
            <input class="devoir-info-input" id="devoir-date-input" name="date" type="date" value="<?=$devoir['DATEDEVOIR']?>"/>
        </div>
        <div class="devoir-group" id="devoir-group">
            <script>
                var groups_selected = <?=json_encode($devoir['GROUPES'])?>;
                var groups_available = <?=json_encode($groups_available)?>;
            </script>
            <!-- Groupe : <?php foreach($devoir['GROUPES'] as $grp){ echo $grp." "; }?> -->
            
            <!-- <select id="devoir-group-select"></select>
            <button>Ajouter</button> -->
        </div>
        <div class="devoir-coef">
            <label for="devoir-coef-input">Coefficient : </label> 
            <input class="devoir-info-input" id="devoir-coef-input" name="coef" type="number" min="1" step="0.01" value="<?=$devoir['COEF']?>"/>
        </div>
        <button id="devoir-info-submit">Enregistrer</button>
        <script>
            gestion_info();
        </script>
    </div>

    <div>
        <h2>Résultats du devoir</h2>
        <?php if (date_create($devoir['DATEDEVOIR']) > new DateTime()) { ?>
            <p>Le devoir n'est pas encore passé</p>
        <?php } else if (!$devoir['GROUPES']){ ?>
            <p>Aucun groupe inscrit</p>
        <?php } else { ?>
            <div id="ajout-note-table">
            <script>gestion_notes("ajout-note-table")</script>
            </div>
        <?php } ?>
    </div>
</div>

<?php 
    //Appel du footer
    require_once(PATH_VIEW_COMPONENT.'footer.php');
?>
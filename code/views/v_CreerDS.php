<?php
//Tableau des fichiers CSS nécessaire
$style = ["sideBarre.css", "main.css", "creerDS.css"];

//Appel de l'header
require_once(PATH_VIEW_COMPONENT.'header.php');

//Appel du composant SideBarre
//Définition du contenu de la sideBar

require_once(PATH_VIEW_COMPONENT.'sideBarre.php');
?>

<section style="background-color: <?=CSScolorByName($module['NOMMODULE'])?>" class="creationDS">
    <h1><?= $module['NOMMODULE']?> : Créer un DS</h1>

    <form method="post">
        <label>Sujet</label>
        <input type="text" name="sujet" required>
        <label>Date du DS</label>
        <input type="text" name="date" required>
        <label>Coefficient</label>
        <input type="text" name="coef" pattern="[0-5]" required>
        <label>Type de salle</label>
        <select name="typeSalle">
            <option>--Séléctionnez une salle--</option>
            <option value="Amphi">Amphithéatre</option>
            <option value="TD">TD</option>
            <option value="TP">TP</option>
            <option value="Examen">Examen</option>
        </select>
        <div class="groupe">
            <label>Groupe</label>
            <select name="groupe">
                <option value="G1">G1</option>
                <option value="G2">G2</option>
                <option value="G3">G3</option>
                <option value="G4">G4</option>
                <option value="G5">G5</option>
            </select>
            <label>Semestre</label>
            <select name="semestre">
                <option value="S1">S1</option>
                <option value="S2">S2</option>
                <option value="S3">S3</option>
                <option value="S4">S4</option>
                <option value="S5">S5</option>
                <option value="S5">S5</option>
            </select>
        </div>
        <div class="bouton">
            <input type="submit" value="Valider" id="valideButton">
            <a href="<?=$router->generate('listeDsUe',['ue' => $module['REFMODULE']])?>" id="annuleButton">Annuler</a>
        </div>
        
    </form>
</section>
<script src="<?php echo PATH_SCRIPTS?>salle.js"></script>
<?php 
    //Appel du footer
    require_once(PATH_VIEW_COMPONENT.'footer.php');
?>


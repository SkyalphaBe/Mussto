<?php
//Tableau des fichiers CSS nécessaire
$style = ["sideBarre.css", "main.css", "creerDS.css"];

//Appel de l'header
require_once(PATH_VIEW_COMPONENT.'header.php');

//Appel du composant SideBarre
//Définition du contenu de la sideBar

require_once(PATH_VIEW_COMPONENT.'sideBarre.php');
?>

<section class="creationDS">
    <h1><?= $match['params']['ue']?> : Créer un DS</h1>

    <form method="post">
        <label>Sujet</label>
        <input type="text" name="sujet" required>
        <label>Date du DS</label>
        <input type="text" name="date" required>
        <label>Coefficient</label>
        <input type="text" name="coef" pattern="[0-5]" required>
        <select name="salle">
            <option value="Amphi1">Amphi1</option>
            <option value="Amphi2">Amphi2</option>
            <option value="S01">S01</option>
            <option value="S03">S03</option>
            <option value="S10">S10</option>
            <option value="S12">S12</option>
            <option value="S13">S13</option>
            <option value="S14">S14</option>
            <option value="S15">S15</option>
            <option value="S16">S16</option>
            <option value="S17">S17</option>
            <option value="S22">S22</option>
            <option value="S24">S24</option>
            <option value="S26">S26</option>
            <option value="040">040</option>
            <option value="026">026</option>
            <option value="028">028</option>
        </select>
        <select name="groupe">
            <option value="G1S1">G1S1</option>
            <option value="G2S1">G2S1</option>
            <option value="G3S1">G3S1</option>
            <option value="G4S1">G4S1</option>
            <option value="G5S1">G5S1</option>
            <option value="G1S2">G1S2</option>
            <option value="G2S2">G2S2</option>
            <option value="G3S2">G3S2</option>
            <option value="G4S2">G4S2</option>
            <option value="G5S2">G5S2</option>
            <option value="G1S3">G1S3</option>
            <option value="G2S3">G2S3</option>
            <option value="G3S3">G3S3</option>
            <option value="G4S3">G4S3</option>
            <option value="G5S4">G5S3</option>
            <option value="G1S4">G1S4</option>
            <option value="G2S4">G2S4</option>
            <option value="G3S4">G3S4</option>
            <option value="G4S4">G4S4</option>
            <option value="G5S5">G5S4</option>
            <option value="G1S5">G1S5</option>
            <option value="G2S5">G2S5</option>
            <option value="G3S5">G3S5</option>
            <option value="G4S5">G4S5</option>
            <option value="G5S5">G5S5</option>
        </select>
        <div class="bouton">
            <input type="submit" value="Valider" id="valideButton">
            <input type="submit" value="Annuler" id="annuleButton">
        </div>
        
    </form>
</section>

<?php 
    //Appel du footer
    require_once(PATH_VIEW_COMPONENT.'footer.php');
?>
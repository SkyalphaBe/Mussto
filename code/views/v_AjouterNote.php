<?php
//Tableau des fichiers CSS nécessaire
$style = ["sideBarre.css", "main.css", "ajouterNote.css"];

//Appel de l'header
require_once(PATH_VIEW_COMPONENT.'header.php');

//Appel du composant SideBarre
//Définition du contenu de la sideBar

require_once(PATH_VIEW_COMPONENT.'sideBarre.php');
?>

<section class="ajoutNote">
    <h1><?= $match['params']['ue']?> : Ajouter une Note</h1>

    <form method="post">
        <label>Sujet</label>
        <input type="text" name="sujet" required>
        <label>Numéro de l'étudiant</label>
        <input type="text" name="etudiant" required>
        <label>Note</label>
        <input type="text" name="note" pattern="^[0-9]{1,2}[.]{1}[0-9]{0,2}$" required>
        <label>Commentaire</label>
        <input type="text" name="commentaire">
        <input type="submit" value="Valider" id="valideButton">
    </form>
</section>

<?php 
    //Appel du footer
    require_once(PATH_VIEW_COMPONENT.'footer.php');
?>
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
    <h1>Ajouter une Note</h1>

    <form method="post">
        <label>Ressource</label>
        <input type="text" name="ressource">
        <label>Numéro de l'étudiant</label>
        <input type="text" name="etudiant">
        <label>Note</label>
        <input type="text" name="note" pattern="[0-9]{1,2}+[.]{0,1}+[0-9]{0,2}">
        <input type="submit" value="Valider" id="valideButton">
    </form>
</section>

<?php 
    //Appel du footer
    require_once(PATH_VIEW_COMPONENT.'footer.php');
?>
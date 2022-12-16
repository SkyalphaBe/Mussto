<?php

//Tableau des fichiers CSS nécessaire
$style = ["main.css", "sideBarre.css","gererAdmin.css"];

//Appel de l'header
require_once(PATH_VIEW_COMPONENT.'header.php');

//Appel du composant SideBarre

require_once(PATH_VIEW_COMPONENT.'sideBarre.php');

?>
<div class="topBoxUsr">
    <h1>Utilisateur</h1>
    <div class="check">
        <label>Liste Etudiant<input type="radio" name="choix" value="/api/listeEtu" checked></label>
        <label>Liste Professeur<input type="radio" name="choix" value="/api/listeProfesseur"></label>
    </div>
    <button id="btnCreer">Créer un compte</button>
</div>
<div class="content"></div>
<script type="module" src="<?php echo PATH_SCRIPTS?>gestionAdmin.js"></script>

<?php require_once (PATH_VIEW_COMPONENT.'footer.php');?>

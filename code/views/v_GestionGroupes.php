<?php
//Tableau des fichiers CSS nécessaire
$style = ["sideBarre.css", "main.css", "gererAdmin.css"];

//Appel de l'header
require_once(PATH_VIEW_COMPONENT.'header.php');

//Appel du composant SideBarre
//Définition du contenu de la sideBar

require_once(PATH_VIEW_COMPONENT.'sideBarre.php');
?>
<div class="topBoxUsr">
    <h1>Groupes</h1>
    <div class="check">
        <label>Année 1<input type="radio" name="year" value="/api/listeGroupes/Annee1" checked></label>
        <label>Année 2<input type="radio" name="year" value="/api/listeGroupes/Annee2" ></label>
        <label>Année 3<input type="radio" name="year" value="/api/listeGroupes/Annee3" ></label>
    </div>
    <button>Créer un Groupe</button>
</div>
<div class="content"></div>
<script type="module" src="<?= PATH_SCRIPTS?>gestionAdminGroupes.js"></script>
<?php
//Appel du footer
require_once(PATH_VIEW_COMPONENT.'footer.php');
?>

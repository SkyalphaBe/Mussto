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
    <h1>Modules</h1>
    <button>Créer module</button>
</div>
<div class="content"></div>
<script type="module" src="<?= PATH_SCRIPTS?>gestionAdminModule.js"></script>
<?php
//Appel du footer
require_once(PATH_VIEW_COMPONENT.'footer.php');
?>

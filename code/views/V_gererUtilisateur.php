<?php

//Tableau des fichiers CSS nécessaire
$style = ["main.css", "sideBarre.css"];

//Appel de l'header
require_once(PATH_VIEW_COMPONENT.'header.php');

//Appel du composant SideBarre

require_once(PATH_VIEW_COMPONENT.'sideBarre.php');

?>

<script src="/code/public/assets/scripts/salle.js"></script>

<?php require_once (PATH_VIEW_COMPONENT.'footer.php');?>

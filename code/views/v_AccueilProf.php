<?php
//Tableau des fichiers CSS nécessaire
$style = ["main.css", "sideBarre.css"];

//Appel de l'header
require_once(PATH_VIEW_COMPONENT.'header.php');


//Appel du composant SideBarre

require_once(PATH_VIEW_COMPONENT.'sideBarre.php');
?>

<?php
//Appel du footer
require_once(PATH_VIEW_COMPONENT.'footer.php');
?>

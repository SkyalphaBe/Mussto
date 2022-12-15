<?php
//Tableau des fichiers CSS nécessaire
$style = ["sideBarre.css", "main.css", "accueilAdmin.css"];

//Appel de l'header
require_once(PATH_VIEW_COMPONENT.'header.php');

//Appel du composant SideBarre
//Définition du contenu de la sideBar

require_once(PATH_VIEW_COMPONENT.'sideBarre.php');
?>
<div class="gestionAdmin">
    <a href="">Gérer les modules</a>
    <a href="<?=$router->generate('gererUtilisateurAdmin')?>">Gérer les utilisateurs</a>
    <a href="">Gérer les groupes</a>
</div>

<?php
//Appel du footer
require_once(PATH_VIEW_COMPONENT.'footer.php');
?>
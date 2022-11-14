<?php
//Tableau des fichiers CSS nécessaire
$style = ["main.css", "sideBarre.css", "module.css"];

//Appel de l'header
require_once(PATH_VIEW_COMPONENT.'header.php');


//Appel du composant SideBarre

require_once(PATH_VIEW_COMPONENT.'sideBarre.php');
?>

<div class="module-detail">
    <h1>Nom</h1>
    <div class="content">
        <div class="left">
            <div class="prof">
                <h2>Enseignant</h2>
            </div>
            <div class="groups">
                <h2>Groupes</h2>
            </div>
        </div>
        <div class="notes">
            <h2>Notes</h2>
        </div>
    </div>
</div>

<?php
//Appel du footer
require_once(PATH_VIEW_COMPONENT.'footer.php');
?>
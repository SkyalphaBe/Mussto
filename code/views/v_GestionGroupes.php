<?php
//Tableau des fichiers CSS nécessaire
$style = ["sideBarre.css", "main.css", "gererAdmin.css"];

//Appel de l'header
require_once(PATH_VIEW_COMPONENT.'header.php');

//Appel du composant SideBarre
//Définition du contenu de la sideBar

require_once(PATH_VIEW_COMPONENT.'sideBarre.php');
?>
<div class="topBoxAdmin">
    <h1>Groupes</h1>
    <div class="check">
        <label>Année 1<input type="radio" name="year" value="/api/listeGroupes/Annee1" checked></label>
        <label>Année 2<input type="radio" name="year" value="/api/listeGroupes/Annee2" ></label>
        <label>Année 3<input type="radio" name="year" value="/api/listeGroupes/Annee3" ></label>
    </div>
    <button id="btnCreer">Créer un Groupe</button>
</div>
<template>
    <form method="post" class="formAdmin">
        <div class="formContentAdmin">
            <label>Intituler du groupe</label>
            <input type="text" name="intitule" required>
        </div>
        <div class="formContentAdmin">
            <label>Année du groupe</label>
            <input type="text" name="annee" required>
        </div>
        <input type="submit" name="create" value="créer">
    </form>
</template>
<template>
    <div class="ExcelExport">
        <a href="assets/excels/creerModule.xlsx" download>Télécharger excel exemple</a>
        <form class="formAdminExcel">
            <input type="file" id="fileGroup">
            <input type="submit" id="sendItGroup">
        </form>
    </div>
</template>
<div class="content"></div>
<script type="module" src="<?= PATH_SCRIPTS?>gestionAdminGroupes.js"></script>
<?php
//Appel du footer
require_once(PATH_VIEW_COMPONENT.'footer.php');
?>

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
    <h1>Modules</h1>
    <button id="btnCreer">Créer module</button>
</div>
<template>
    <form method="post" class="formAdmin">
        <div class="formContentAdmin">
            <label>Reférence module</label>
            <input type="text" name="refmodule" required>
        </div>
        <div class="formContentAdmin">
            <label>nom du module</label>
            <input type="text" name="nommodule" required>
        </div>
        <div class="formContentAdmin">
            <label>Description</label>
            <input type="text" name="description" required>
        </div>
        <input type="submit" name="create" value="créer">
    </form>
</template>
<template>
    <div class="ExcelExport">
        <a href="assets/excels/creerModule.xlsx" download>Télécharger excel exemple</a>
        <form class="formAdminExcel">
            <input type="file" id="fileModule">
            <input type="submit" id="sendItModule">
        </form>
    </div>
</template>
<div class="content"></div>
<script type="module" src="<?= PATH_SCRIPTS?>gestionAdminModule.js"></script>
<?php
//Appel du footer
require_once(PATH_VIEW_COMPONENT.'footer.php');
?>

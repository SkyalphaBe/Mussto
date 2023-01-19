<?php

//Tableau des fichiers CSS nécessaire
$style = ["main.css", "sideBarre.css","gererAdmin.css"];

//Appel de l'header
require_once(PATH_VIEW_COMPONENT.'header.php');

//Appel du composant SideBarre

require_once(PATH_VIEW_COMPONENT.'sideBarre.php');

?>
<div class="topBoxAdmin">
    <h1>Utilisateur</h1>
    <div class="search">
        <input type="text" id="search" placeholder="Rechercher"/>
    </div>
    <div class="check">
        <label>Liste Étudiant<input type="radio" name="choix" value="/api/listeEtu" checked></label>
        <label>Liste Professeur<input type="radio" name="choix" value="/api/listeProfesseur"></label>
    </div>
    <button id="btnCreer">Créer un compte</button>
</div>
<template>
    <form method="post" class="formAdmin">
        <div class="formContentAdmin">
            <label>Login</label>
            <input type="text" name="login" required>
        </div>
        <div class="formContentAdmin">
            <label>Mot de passe</label>
            <input type="text" name="mdp" required>
        </div>
        <div class="formContentAdmin">
            <label>Prénom</label>
            <input type="text" name="prenom" required>
        </div>
        <div class="formContentAdmin">
            <label>Nom</label>
            <input type="text" name="nom" required>
        </div>
        <div class="formContentAdmin">
            <label>Type de compte</label>
            <select name="type">
                <option value="ETUDIANT">Etudiant</option>
                <option value="PROFESSEUR">Professeur</option>
            </select>
        </div>
        <input type="submit" name="create" value="créer"></form>
</template>
<template>
    <div class="ExcelExport">
        <a href="assets/excels/creerCompte.xlsx" download>Télécharger excel exemple</a>
        <form class="formAdminExcel">
            <input type="file" id="fileCompte">
            <input type="submit" id="sendIt">
        </form>
    </div>
</template>
<div class="content"></div>
<script type="module" src="<?php echo PATH_SCRIPTS?>/gestionUser/gestionAdminUser.js"></script>

<?php require_once (PATH_VIEW_COMPONENT.'footer.php');?>

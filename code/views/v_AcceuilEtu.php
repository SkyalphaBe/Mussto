<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="<?php echo PATH_CSS ?>sideBarre.css">
    <link rel="stylesheet" href="<?php echo PATH_CSS ?>accueilEtu.css">
    <link rel="stylesheet" href="<?php echo PATH_CSS ?>accueilEtuGrid.css">
    <script src="https://kit.fontawesome.com/36631c7287.js" crossorigin="anonymous"></script>
    <title>Page accueil</title>
</head>
<body>
    <?php
        require_once(PATH_VIEW_COMPONENT.'sideBarre.php');
    ?>
    <div class="content">
        <div class="welcome">
            <img id="student" src="assets/images/etudiant.png">
            <div class="msg">
                <h2>Bonjour <?= $_SESSION["name"]?> !</h2>
                <p>Tu as des nouvelles fraîches</p>
            </div>
        </div>
        <div class="informationEleve">
            <div id="lastMark" class="info">
                <h2>Dernière note</h2>
            </div>
            <div id="sondage" class="info">
                <h2>Sondages</h2>
            </div>
            <div id="othersMarks" class="info">
                <h2>Autres notes</h2>
            </div>
            <div id="DS" class="info">
                <h2>DS à venir</h2>
            </div>
        </div>
    </div>
</body>
</html>
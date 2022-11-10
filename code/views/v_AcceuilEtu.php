<?php
$style = ["sideBarre.css", "main.css", "accueilEtu.css", "accueilEtuGrid.css"];
require_once(PATH_VIEW_COMPONENT.'header.php');
?>
<?php
    require_once(PATH_VIEW_COMPONENT.'sideBarre.php');
?>
<div class="welcome">
    <img id="student" src="assets/images/etudiant.png">
    <div class="msg">
        <h2>Bonjour <?= $_SESSION["firstname"]?> !</h2>
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
        <?php if (isset($devoir_coming) && $devoir_coming){
            foreach($devoir_coming as $devoir) { ?>
                <div style="background-color: hsl(<?=hexdec(substr(bin2hex($devoir['NOMMODULE']), 0, 16))%360?>, 66%, 41%)" class="devoir">
                    <h3 class="devoir-module-name"><?=$devoir['NOMMODULE']?></h3>
                    <p class="devoir-date"><?=$devoir['DATEDEVOIR']?></p>
                    <p class="devoir-salle">SALLE <?=$devoir['SALLE']?></p>
                </div>

        <?php } } else { ?>
            <p>Aucun devoir en prévision</p>
        <?php } ?>

    </div>
</div>

<?php
require_once(PATH_VIEW_COMPONENT.'footer.php');
?>
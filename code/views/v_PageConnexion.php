<?php
$style = ["connexion.css"];
require_once(PATH_VIEW_COMPONENT.'header.php');
?>

<section class="connexionBox">
    <div class = "titleBox">
        <h1>musst</h1>
        <h1 id="oTitre">o</h1>

    </div>
    <h2>Se connecter</h2>
    <?php if (isset($error)) { ?>
        <h3 class="error"><?=$error?></h3>
    <?php } ?>
    <form method="post">
        <input type="text" name="login" placeholder="Identifiant">
        <input type="password" name="pswd" placeholder="Mot de passe">
        <input type="submit" value="OK" id="okButton">
    </form>
</section>

<?php
require_once(PATH_VIEW_COMPONENT.'footer.php');
?>
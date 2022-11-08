<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="../assets/css/connexion.css">
    <title>Connexion</title>
</head>
<body>
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
            <input type="text" name="pswd" placeholder="Mot de passe">
            <input type="submit" value="OK" id="okButton">
        </form>
    </section>
</body>
</html>
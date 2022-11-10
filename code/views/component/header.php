<!DOCTYPE html>
<html lang="fr">
<head>
    <?php
    if (isset($style)){
        foreach ($style as $elt){
    ?>
            <link rel="stylesheet" href="<?=PATH_CSS.$elt?>">
    <?php
        }
    }
    ?>
    <script src="https://kit.fontawesome.com/36631c7287.js" crossorigin="anonymous"></script>
    <meta charset="UTF-8">
    <title>Mussto</title>
</head>
<body>
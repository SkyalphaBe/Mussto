<div class="sideBarre <?=$_SESSION['logged']?>">
    <div class="topBox">
        <div class="titleBox">
            <div class="titre">
                <h1>musst</h1>
                <h1 id="oTitre">o</h1>
            </div>
            <h2></h2>
        </div>
        <div class="ligneSep"></div>
        <div class="menu">
            <h3>Menu</h3>
            <a href="<?=$router->generate("accueil")?>" class="<?php if ($router->generate("accueil") == $_SERVER['REQUEST_URI']) echo 'active'; ?>"><i class="fa-solid fa-house"></i>Accueil</a>
            <?php
                if (isset($menu)){
                    foreach ($menu as $line){ ?>
                        <a href="<?=$line['href']?>" class="<?php if ($line['href'] == $_SERVER['REQUEST_URI']) echo 'active'; ?>"><i class="fa-solid fa-book"></i><?=$line["name"]?></a>
                    <?php
                    }
                }
            ?>
        </div>
    </div>
    <div class="botBox">
        <div class="ligneSep"></div>
        <h3>Profil</h3>
        <div class="account">
            <div class="box">
                <div class="circle"><i class="fa-solid fa-user"></i></div>
            </div>
            <div class="person">
                <p><?= $_SESSION["firstname"]?></p>
                <p><?= $_SESSION['lastname']?></p>
            </div>
        </div>
        <div class="button">
            <a href= <?= $router->generate('info') ?> id="dataButton">Mes informations</a>
        </div>
        <div class="button">
            <a href= <?= $router->generate('deconnexion') ?> class="decoButton"><i class="fa-solid fa-right-from-bracket"></i> Déconnexion</a>
        </div>
    </div>
</div>
<div id="menuButton" onclick="document.body.classList.toggle('hide-side')">
</div>
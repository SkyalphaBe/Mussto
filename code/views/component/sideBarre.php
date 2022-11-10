
<div class="sideBarre">
    <div class="topBox">
        <div class="titleBox">
            <div class="titre">
                <h1>musst</h1>
                <h1 id="oTitre">o</h1>
            </div>
            <h2>Etudiant</h2>
        </div>
        <div class="ligneSep"></div>
        <div class="menu">
            <h3>Menu</h3>
            <a href=""><i class="fa-solid fa-house"></i> Acceuil</a>
            <a href=""><i class="fa-solid fa-book"></i> Mes modules</a>
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
                <p><?= $_SESSION["firstname"]?> <?= $_SESSION['lastname']?></p>
                <!--<p>Last Name</p>-->
            </div>
        </div>
        <div class="button">
            <a href= <?= $router->generate('disconnect') ?> class="decoButton"><i class="fa-solid fa-right-from-bracket"></i> Deconnexion</a>
        </div>
    </div>
</div>
<div id="menuButton" onclick="document.body.classList.toggle('hide-side')">
</div>
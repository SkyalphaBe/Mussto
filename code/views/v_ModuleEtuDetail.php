<?php
//Tableau des fichiers CSS nécessaire
$style = ["main.css", "sideBarre.css", "module.css"];

//Appel de l'header
require_once(PATH_VIEW_COMPONENT.'header.php');


//Appel du composant SideBarre

require_once(PATH_VIEW_COMPONENT.'sideBarre.php');
?>

    <div style="background-color: <?=CSScolorByName($module['NOMMODULE'])?>" class="module-detail">
    <div class="header">
        <h1><?=$module['REFMODULE']?> - <?=$module['NOMMODULE']?></h1>
        <a class="button" href="<?=$router->generate('module')?>">Retour à la liste des modules</a>
    </div>
    <p class="desc"><?=$module['DESCRIPTIONMODULE']?></p>
    <div class="content">
        <div class="prof">
            <h2>Enseignant : </h2>
            <ul>
            <?php if ($enseignants) {
                foreach ($enseignants as $prof){ ?>
                    <li><?=$prof['NOMEPROF']?> <?=$prof['PRENOMPROF']?></li>
                <?php }
            }?>
            </ul>
        </div>
        <div class="groups">
            <h2>Groupes : </h2>
        </div>
        <div class="notes">
            <h2>Notes : </h2>
            <div class="notes-list">
                <?php if (isset($notes) && $notes) {
                    foreach ($notes as $note){
                        //print_r($note);
                    }
                }
                ?>
                <div class="note">
                    <div>
                        <h3>16/20</h3>
                        <p>12/10/2023</p>
                    </div>
                    <p class="coef">Coefficient 1</p>
                    <p class="ds-content">Base de JS</p>
                    <p class="ds-date">Devoir du 10/10/2023</p>
                </div>
                <div class="note">
                    <div>
                        <h3>16/20</h3>
                        <p>12/10/2023</p>
                    </div>
                    <p class="coef">Coefficient 1</p>
                    <p class="ds-content">Base de JS</p>
                    <p class="ds-date">Devoir du 10/10/2023</p>
                </div>
                <div class="note">
                    <div>
                        <h3>16/20</h3>
                        <p>12/10/2023</p>
                    </div>
                    <p class="coef">Coefficient 1</p>
                    <p class="ds-content">Base de JS</p>
                    <p class="ds-date">Devoir du 10/10/2023</p>
                </div>
                <div class="note">
                    <div>
                        <h3>16/20</h3>
                        <p>12/10/2023</p>
                    </div>
                    <p class="coef">Coefficient 1</p>
                    <p class="ds-content">Base de JS</p>
                    <p class="ds-date">Devoir du 10/10/2023</p>
                </div>
                <div class="note">
                    <div>
                        <h3>16/20</h3>
                        <p>12/10/2023</p>
                    </div>
                    <p class="coef">Coefficient 1</p>
                    <p class="ds-content">Base de JS</p>
                    <p class="ds-date">Devoir du 10/10/2023</p>
                </div>
                <div class="note">
                    <div>
                        <h3>16/20</h3>
                        <p>12/10/2023</p>
                    </div>
                    <p class="coef">Coefficient 1</p>
                    <p class="ds-content">Base de JS</p>
                    <p class="ds-date">Devoir du 10/10/2023</p>
                </div>
            </div>
        </div>
    </div>
</div>

<?php
//Appel du footer
require_once(PATH_VIEW_COMPONENT.'footer.php');
?>
<?php
//Tableau des fichiers CSS nécessaire
$style = ["main.css", "sideBarre.css", "module.css"];

//Appel de l'header
require_once(PATH_VIEW_COMPONENT.'header.php');


//Appel du composant SideBarre

require_once(PATH_VIEW_COMPONENT.'sideBarre.php');
?>

    <div style="--color: <?=DegreeColorByName($module['NOMMODULE'])?>" class="module-detail">
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
                        foreach ($notes as $note){ ?>
                            <div class="note-elt">
                                <div>
                                    <h3 class="note"><?=$note['NOTE']?>/20</h3>
                                    <p><?=$note['DATE_ENVOIE']?></p>
                                </div>
                                <p class="coef">Coefficient <?=$note['COEF']?></p>
                                <p class="ds-content"><?=$note['CONTENUDEVOIR']?></p>
                                <p class="ds-date">Devoir du <?=$note['DATEDEVOIR']?></p>
                            </div>
                            <?php
                        }
                    } else {
                        echo "Aucune notes";
                    }
                    ?>
                </div>
            </div>
        </div>
        <?php if (isset($avg) and $avg){ ?>
            <div class="moyenne">
                <h2>Moyenne</h2>
                <h3 class="note"><?=$avg?> / 20</h3>
            </div>
        <?php } ?>
    </div>

<?php
//Appel du footer
require_once(PATH_VIEW_COMPONENT.'footer.php');
?>
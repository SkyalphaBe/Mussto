<?php
//Tableau des fichiers CSS nécessaire
$style = ["sideBarre.css", "main.css", "sondage.css", "loader.css"];

//Appel de l'header
require_once(PATH_VIEW_COMPONENT.'header.php');

//Appel du composant SideBarre
require_once(PATH_VIEW_COMPONENT.'sideBarre.php');

?>
<script>
    const id = <?=$sondage['IDSONDAGE']?>;
</script>
<script type="module" src="/assets/scripts/sondage/sondage.js" defer></script>

<div style="background-color: <?=CSScolorByName($sondage['REFMODULE'])?>" class="sondage">
    <div id="title">
        <h1>Sondage</h1>
        <a class="button" href="<?=$router->generate("listeDsUe", ['ue' => $sondage['REFMODULE']])?>">Retour</a>
    </div>
    <div id="infoSondage">
        <h2><?=$sondage['TITLESONDAGE']?></h2>
        <div>
            <p>Publié le <?=$sondage['DATESONDAGE']?></p>
            <?php if ($sondage['AFFICHER'] == '0') { ?>
                <p>Ce sondage n'est actuellement pas visible par les étudiants</p>
            <?php } ?>
        </div>
        <ul>
            <?php foreach($sondage['GROUPS'] as $group){
                echo "<li>".$group."</li>";
            }?>
        </ul>
        <div id="delete-section">
            <button id="delete-button" class="delete-button">Supprimer le sondage</button>
        </div>
        <div id="show-section">
            <?php if ($sondage['AFFICHER'] == '0') { ?>
                <button value="1" id="show-button">Rendre visible</button>
            <?php } else {?>
                <button value="0" id="show-button">Rendre invisible</button>
            <?php } ?>
        </div>
    </div>
    <table>
        <thead>
            <tr>
                <th rowspan="0" class="name-header">Nom et Prenom</th>
                <th rowspan="0" class="date-header">Date de réponse</th>
                <th colspan="99">Questions</th>
            </tr>
            <tr>
                <?php foreach($sondage['CONTENUSONDAGE'] as $question){
                    echo "<th>".htmlspecialchars($question['question'])."</th>";
                }?>
            </tr>
        </thead>
        <tbody>
            <?php 
            if ($result){
                foreach($result as $line){
                    $answerHTML = "";              
                    foreach($sondage['CONTENUSONDAGE'] as $question){
                        $answerHTML.= "<td>".htmlspecialchars($line['CONTENUREPONSE'][$question['question']])."</td>";
                    }
    
                    $html = <<<HTML
                    <tr>
                        <td>{$line['PRENOMETU']} {$line['NOMETU']}</td>
                        <td>{$line['DATEREPONSE']}</td>
                        {$answerHTML}
                    </tr>
                    HTML;
                    
                    echo $html;
                
                }
            } else {
                echo "<tr><td colspan='99'>Aucun résulat pour le moment</td></tr>";
            }?>
        </tbody>
    </table>
</div>

<?php 
    //Appel du footer
    require_once(PATH_VIEW_COMPONENT.'footer.php');
?>
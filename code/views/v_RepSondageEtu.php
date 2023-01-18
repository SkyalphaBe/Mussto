<?php
//Tableau des fichiers CSS nécessaire
$style = ["sideBarre.css", "main.css", "loader.css", "repSondage.css"];

//Appel de l'header
require_once(PATH_VIEW_COMPONENT.'header.php');

//Appel du composant SideBarre
require_once(PATH_VIEW_COMPONENT.'sideBarre.php');


require_once(PATH_MODELS.'EtuDAO.php');



?>

<div id="rep-sondage" style="--color: <?=DegreeColorByName($data['NOMMODULE'])?>">
    <div class="header">
        <h1>Repondre au sondage</h1>
        <a class="button" href="<?=$router->generate("accueil")?>">Retour</a>
    </div>
    <div class="info">
        <h2>Objet du sondage : <?=$data['TITLESONDAGE']?></h2>
        <p>Publié le <?=$data['DATESONDAGE']?></p>
    </div>
    <div id="form">
        <?php
            $i = 0; 
            foreach($data['CONTENUSONDAGE'] as $quest){
                if ($quest['type'] == "free" && $quest['question']){
                    if($data['CONTENUREPONSE'])
                        $res = htmlspecialchars($data['CONTENUREPONSE'][$quest['question']]);
                    else
                        $res = "";
                    $label = htmlspecialchars($quest['question']);
                    echo <<<HTML
                        <div class="question">
                            <label for="input{$i}">{$label}</label>
                            <input class="res-sondage" id="input{$i}" type="text" placeholder="reponse" name="{$label}" value='{$res}'/>
                        </div>
                    HTML;
                } else if ($quest['type'] == "choice") {
                    $res = "";
                    foreach($quest['choices'] as $choice){
                        $sel = "";
                        if($data['CONTENUREPONSE']){
                            if ($data['CONTENUREPONSE'][$quest['question']] == $choice){
                                $sel = "selected";
                            }
                        }
                        $choice = htmlspecialchars($choice);
                        $res.="<option value='{$choice}' {$sel}>{$choice}</option>";
                    }

                    $label = htmlspecialchars($quest['question']);
                    echo <<<HTML
                        <div class="question">
                            <label for="input{$i}">{$label}</label>
                            <select class="res-sondage" id="input{$i}" type="text" placeholder="reponse" name="{$label}">
                                <option value="">--</option>
                                {$res}
                            </select>
                        </div>
                    HTML;
                }
                $i++;
            }
        ?>
        <button id="sondage-submit">Envoyer</button>
    </div>
</div>


<script>
    const id = <?=$data['IDSONDAGE']?>;
</script>
<script type="module" src="/assets/scripts/sondage/reponse_sondage.js"></script>


<?php
//Appel du footer
require_once(PATH_VIEW_COMPONENT.'footer.php');
?>


    

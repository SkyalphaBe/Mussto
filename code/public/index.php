<?php
session_start();


require_once('../config/configuration.php');
require_once('../lib/AltoRouter.php');
require_once('../lib/color.php');

$router = new AltoRouter();

/*$router->map("GET", "/", "home", "home");
$router->map("GET|POST", "/login", "login", "login");
$router->map("GET", "/disconnect", "disconnect", "disconnect");*/

#$router->setBasePath('/~pXXXXXXX/'); Pour le serveur de l'iut;


if (array_key_exists('logged', $_SESSION) && $_SESSION['logged']){
    if ($_SESSION['logged'] === 'etu'){


        ##Routes pour les étudiants
        $router->map("GET", "/", "homeEtu", "home");
        $router->map("GET", "/modules", "moduleEtu", "module");
        $router->map("GET", "/modules/detail-[:ue]", "moduleEtuDetail", "moduleDetail");

        $router->map("GET", "/sondage-[:id]", "repSondageEtu", "repSondageEtu");

        $router->map("POST", "/api/modif-rep-sondage-[:id]", "modificationReponsesSondage");
        $router->map("GET", "/api/obtenir-rep-sondage-[:id]", "obtenirReponsesSondage");

        ##Définition des élements dans le menu
        $menu = [
            [ 'href' => $router->generate("module"), 'name' => "Mes Modules" ]
        ];
    } else if ($_SESSION['logged'] === 'prof'){
        ##Routes pour les professeurs
        $router->map("GET", "/", "homeProf", "home");

        $router->map("GET", "/modules-[:ue]", "ListeDS", "listeDsUe");
        $router->map("GET", "/modules-[:ue]/nouveau-devoir", "CreerDS", "CreerDSProf");
        $router->map("GET", "/modules-[:ue]/nouveau-sondage", "CreerSondage", "CreerSondage");

        $router->map("GET", "/devoir-[:id]", "AjouterNote", "AjouterNote");
        $router->map("GET", "/sondage-[:id]", "sondage", "sondage");

        $router->map("PUT", "/api/devoir/creer-ds", "creerDS");
        $router->map("GET", "/api/devoir/obtenir-infos-ds-[:id]", "obtenirInfoDS");
        $router->map("GET", "/api/devoir/obtenir-notes-ds-[:id]", "obtenirNotesDS");
        $router->map("POST", "/api/devoir/modif-notes-ds-[:id]", "modificationNotesDS");
        $router->map("POST", "/api/devoir/modif-infos-ds-[:id]", "modificationInfoDS");
        $router->map("DELETE", "/api/devoir/suppression-[:id]", "suppressionDS");

        $router->map("PUT", "/api/sondage/creer-sondage", "creerSondage");
        $router->map("DELETE", "/api/sondage/suppression-[:id]", "suppressionSondage", "suppressionSondage");
        $router->map("POST", "/api/sondage/modif-visibilite-[:id]", "modificationVisibiliteSondage", "modificationVisibiliteSondage");

        $router->map("GET", "/api/modules-[:ue]", "obtenirInfosModule");
        $router->map("GET", "/api/modules-[:ue]/etu", "obtenirEtudiantParModule");
        $router->map("GET", "/api/modules-[:ue]/groupes", "obtenirGroupesParModule");
        $router->map("GET", "/api/modules-[:ue]/profs", "obtenirProfParModule");

        $router->map("GET", "/api/salles", "obtenirSalles");

        //Définition du contenu de la sideBar
        $menu = [
            [ 'href' => "", 'name' => "Contact" ]
        ];
    } else if ($_SESSION['logged'] === 'admin'){
        ##Routes pour les admins
        $router->map("GET", "/", "homeAdmin", "home");
        $router->map("GET", "/api/listeEtu", "listeEtu");
        $router->map("GET", "/api/listeProfesseur", "listeProfesseur");
        $router->map("GET", "/api/listeGroupes/Annee1", "listeGroupesAnnee1");
        $router->map("GET", "/api/listeGroupes/Annee2", "listeGroupesAnnee2");
        $router->map("GET", "/api/listeGroupes/Annee3", "listeGroupesAnnee3");
        $router->map("POST", "/api/creerCompteExcel", "creerCompteExcel");
        $router->map("GET", "/api/listeModules", "listeModules");
        $router->map("POST", "/api/creerModuleExcel", "creerModuleExcel");
        $router->map("POST", "/api/creerGroupeExcel", "creerGroupeExcel");

        $router->map("GET|POST", "/api/suppressionUtilisateur", "suppressionUtilisateur");
        $router->map("GET|POST", "/api/suppressionGroupe", "suppressionGroupe");
        $router->map("GET|POST", "/api/suppressionModule", "suppressionModule");

        $router->map("GET|POST", "/gererUtilisateur", "gererUtilisateur","gererUtilisateurAdmin");
        $router->map("GET|POST", "/gererGroupes", "GestionGroupes","GestionGroupes");
        $router->map("GET|POST", "/gererModules", "gererModules","GestionModules");
    }
    ##Route test home (temporaire)

    ##Route de deconnection
    $router->map("GET", "/disconnect", "disconnect", "disconnect");

    $router->map("GET", "/allyourinfo", "info", "info");
} else {
    $router->map("GET|POST", "/", "login", "home");
}

$match = $router->match();
if ($match){
    if (substr($_SERVER['REQUEST_URI'], 0, 5) === "/api/"){
        header('Content-Type: application/json; charset=utf-8');
        require_once (PATH_API.$match['target'].'.php');
    } else {
        require_once (PATH_CONTROLLERS.$match['target'].'.php');
    }
} else {
    http_response_code(404);
    echo '404'; #A modifier
    header('Location: '.$router->generate('home'));
}

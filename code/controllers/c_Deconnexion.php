<?php
$_SESSION['logged'] = false;
$_SESSION['name'] = false;
if (isset($router)){
    header('Location: '.$router->generate('accueil'));
} else {
    header('Location: ./');
}
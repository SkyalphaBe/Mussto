<?php
$_SESSION['logged'] = false;
if (isset($router)){
    header('Location: '.$router->generate('home'));
} else {
    header('Location: ./');
}
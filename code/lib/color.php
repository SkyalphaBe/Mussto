<?php

/**
 * @param $name
 * @return string Retourne une couleur css unique par rapport au nom
 */
function CSScolorByName($name): string
{
    $degrees = hexdec(substr(bin2hex($name), 0, 16))%360;
    return "hsl($degrees, 66%, 41%, 0.8)";
}
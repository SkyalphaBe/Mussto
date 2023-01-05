<?php

/**
 * @param $name
 * @return string Retourne une couleur css unique par rapport au nom
 */
function CSScolorByName($name): string
{
    $degrees = DegreeColorByName($name);
    return "hsl($degrees, 66%, 41%, 0.8)";
}

function DegreeColorByName($name)
{
    return (hexdec(substr(bin2hex($name), 0, 16)))*15000%360;
}
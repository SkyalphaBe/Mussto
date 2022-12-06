<?php

$file = "FichierTest.xlsx";

header('Content-Type: application/octet-stream');
header('Content-Transfer-Encoding: Binary');
header('Content-disposition: attachment; filename="'.$file.'"');
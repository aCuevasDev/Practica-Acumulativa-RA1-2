<?php
require_once(__DIR__ . "/class/Cancion.php");

// $title = 'Sesión de prueba';
// $artist = 'Grupo del aula';
// $duration = 185;
// $volume = 0.5;
// $available = true;

const APP_NAME = 'Jukebox';
$cancion = new Cancion();
$cancion->populate_cancion('Sesión de prueba', 'Grupo del aula', 185, 0.5, true);

var_dump($cancion->get_associative_array());

$cancion2 = new Cancion();
$cancion2->populate_cancion('<b>Demo</b>');


ob_start();
var_dump($cancion2->get_associative_array());
$dumpedVars = ob_get_clean();

echo "ESCAPED: " . htmlspecialchars($dumpedVars);
echo "NO ESCAPED: " . $dumpedVars;

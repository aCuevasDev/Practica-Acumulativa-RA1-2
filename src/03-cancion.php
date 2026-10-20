<?php
require_once("Cancion.php");

// $title = 'Sesión de prueba';
// $artist = 'Grupo del aula';
// $duration = 185;
// $volume = 0.5;
// $available = true;

const APP_NAME = 'Jukebox';
$cancion = new Cancion();
$cancion->populate_cancion('Sesión de prueba', 'Grupo del aula', 185, 0.5, true);

var_dump($cancion->dump_variables());

$cancion2 = new Cancion();
$cancion2->populate_cancion('<b>Demo</b>');

htmlspecialchars(var_dump($cancion2->dump_variables()));



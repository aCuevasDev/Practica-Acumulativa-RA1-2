<?php
require_once(__DIR__ . "/../class/Cancion.php");
//require_once(__DIR__ . "/class/CancionesSingleton.php");
// require_once(__DIR__ . "/class/NoExiste.php");

$JSON_SRC = __DIR__ . "/../PracticaJS/Practica2/songs.json";
//$song = new Cancion();
// $songs = array($song);
$json = file_get_contents($JSON_SRC);


// $mockJson = array(
//     "id" => "1",
//     "name" => "song",
//     "author" => "dy",
//     "file" => "/test/song",
// );
// $songs = json_decode(mockJson, true);


$json = json_decode($json, true);

/** @var Cancion[] $songs */
$songs = [];

foreach ($json['songs'] as $songData) {
    $songs[] = new Cancion(json_encode($songData, JSON_THROW_ON_ERROR));
}
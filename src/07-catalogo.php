<?php

$JSON_SRC = __DIR__ . "PracticaJS/songs.json";
$song = new Cancion();
// $songs = array($song);
$json = file_get_contents($JSON_SRC);

$songs = json_decode($json, true);

foreach ($songs as $song) {
    echo var_dump($song->get_associative_array());
}


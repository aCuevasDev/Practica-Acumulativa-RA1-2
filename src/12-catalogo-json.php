<?php
// Ya había cargado el json antes usando el service que hice así que no tiene la estructura/nombre que pides
require_once(__DIR__ . "/services/read-json.php");



foreach ($songs as $song) {
    // var_dump($song->get_associative_array());
    $catalogo[] = $song->get_associative_array();
}


if (empty($songs)) {
    echo 'Todavía no hay canciones';
}
$response = Response::make()
    ->status(200)
    ->body(['songs' => $catalogo])
    ->send();

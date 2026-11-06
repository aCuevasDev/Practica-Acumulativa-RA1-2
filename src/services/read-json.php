<?php
require_once(__DIR__ . "/../class/Cancion.php");
require_once(__DIR__ . "/../class/Response.php");

$JSON_SRC = __DIR__ . "/../PracticaJS/Practica2/songs.json";

$json = file_get_contents($JSON_SRC);


// $mockJson = array(
//     "id" => "1",
//     "name" => "song",
//     "author" => "dy",
//     "file" => "/test/song",
// );
// $songs = json_decode(mockJson, true);

try {
    $json = json_decode($json, true, JSON_THROW_ON_ERROR);

    /** @var Cancion[] $songs */
    $songs = [];

    foreach ($json['songs'] as $songData) {
        $songs[] = new Cancion(json_encode($songData, JSON_THROW_ON_ERROR));
    }
} catch (Exception $e) {
    // No me gusta devolver a la vista en un servicio pero como tenemos una estructura tan dispersa y php no lanza errores para unchecked exceptions creo que será mejor así
    Response::make()
                ->body("Error al leer el json: ". $e->getMessage())
                ->send();
}
<?php
require_once(__DIR__ . "/../class/Cancion.php");
require_once(__DIR__ . "/../class/ResponseBuilder.php");

$JSON_SRC = dirname(__DIR__, 2) . "/data/songs.json";


// Deprectated, usamos fopen ahora en canciones.php. Lo mantengo para 07 y 12 catalogos

try {
    $json = file_get_contents($JSON_SRC);
    $json = json_decode($json, true, 512, JSON_THROW_ON_ERROR);

    /** @var Cancion[] $songs */
    $songs = [];

    foreach ($json['songs'] as $songData) {
        $songs[] = new Cancion(json_encode($songData, JSON_THROW_ON_ERROR));
    }
} catch (JsonException $e) {
    // No me gusta devolver a la vista en un servicio pero como tenemos una estructura tan dispersa y php no lanza errores para unchecked exceptions creo que será mejor así
    ResponseBuilder::make()
        ->status(400)
        ->append("Error al leer el json: " . $e->getMessage())
        ->send();
}
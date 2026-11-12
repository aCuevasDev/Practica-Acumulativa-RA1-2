<?php
require_once dirname(__DIR__) . '/services/sesion.php';
require_once dirname(__DIR__) . '/persistence/songs.php';
require_once dirname(__DIR__) . '/class/Cancion.php';
require_once dirname(__DIR__) . '/class/ResponseBuilder.php';


if (!isset($_SESSION['usuario_id'])) {
    ResponseBuilder::make()->status(401)->send();
    exit;
}


try {
    $songs = read_songs();

    ResponseBuilder::make()
        ->status(200)
        ->body($songs)
        ->send();

} catch (Exception $e) {
    ResponseBuilder::make()
        ->status(500)
        ->body('No se pudo leer el catálogo de canciones.')
        ->send();
}

?>
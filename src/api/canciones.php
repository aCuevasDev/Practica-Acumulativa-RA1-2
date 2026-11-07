<?php
require_once dirname(__DIR__) . '/persistence/songs.php';
require_once dirname(__DIR__) . '/class/Cancion.php';
require_once dirname(__DIR__) . '/class/Response.php';


if (!isset($_SESSION['usuario_id'])) {
    Response::make()->status(401)->send();
    exit;
}


try {
    $songs = read_songs();

    Response::make()
        ->status(200)
        ->body($songs)
        ->send();

} catch (Exception $e) {
    Response::make()
        ->status(500)
        ->body('No se pudo leer el catálogo de canciones.')
        ->send();
}

?>
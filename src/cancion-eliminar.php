<?php
if (!in_array($_SERVER['REQUEST_METHOD'], ['GET', 'POST'], true)) {
    http_response_code(405);
    exit('Método de la petición no permitido.');
}

require_once __DIR__ . '/services/acceso.php';
require_once __DIR__ . '/services/song-validation.php';
require_once __DIR__ . '/persistence/songs.php';

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $songId = validate_song_id($_GET['id'] ?? null);

    if ($songId === null) {
        http_response_code(400);
        exit('El identificador no es válido.');
    }

    try {
        $songs = read_songs();
    } catch (Exception $e) {
        http_response_code(500);
        exit('No se pudo leer el catálogo de canciones.');
    }

    $position = find_song_position($songs, (string) $songId);

    if ($position === null) {
        http_response_code(404);
        exit('La canción no existe.');
    }

    $songTitle = (string) ($songs[$position]['name'] ?? '');
} else {
    csrf_check();
    $songId = validate_song_id($_POST['id'] ?? null);

    if ($songId === null) {
        http_response_code(400);
        exit('El identificador no es válido.');
    }

    $result = delete_song((string) $songId);

    if ($result['errors'] !== []) {
        exit('No se pudo eliminar la canción.');
    }

    if (!$result['found']) {
        http_response_code(404);
        exit('La canción no existe.');
    }

    header('Location: canciones.php');
    exit;
}

require __DIR__ . '/views/song-delete.php';

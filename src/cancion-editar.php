<?php
if (!in_array($_SERVER['REQUEST_METHOD'], ['GET', 'POST'], true)) {
    http_response_code(405);
    exit('Método no permitido.');
}

require_once __DIR__ . '/services/acceso.php';
require_once __DIR__ . '/services/song-validation.php';
require_once __DIR__ . '/persistence/songs.php';

$errors = [];
$values = [];

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

    $song = $songs[$position];
    $values = [
        'title' => $song['name'] ?? '',
        'artist' => $song['author'] ?? '',
        'category' => $song['category'] ?? '',
        'duration' => $song['duration'] ?? '',
        'src' => $song['file'] ?? '',
    ];
} else { // POST
    csrf_check();
    $songId = validate_song_id($_POST['id'] ?? null);

    if ($songId === null) {
        http_response_code(400);
        exit('El identificador no es válido.');
    }

    $validation = validate_song($_POST);
    $values = $validation['values'];
    $errors = $validation['errors'];

    if ($errors === []) {
        $song = new Cancion();
        $song->populate_cancion(
            (string) $songId,
            $values['title'],
            $values['artist'],
            $values['duration'],
            100,
            $values['src'],
            $values['category']
        );
        $result = update_song((string) $songId, $song);

        if ($result['errors'] !== []) {
            $errors = $result['errors'];
        } elseif (!$result['found']) {
            http_response_code(404);
            exit('La canción no existe.');
        } else {
            header('Location: canciones.php');
            exit;
        }
    }
}

$formAction = 'cancion-editar.php';
$submitLabel = 'Guardar cambios';
$formTitle = 'Editar canción';

require __DIR__ . '/views/song-form.php';
